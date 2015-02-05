<?php

class WebhookController extends BaseController {

	public function sso(){
		$foxycart_api_key = $cart->f('api');
		$user = Auth::user();
		$user_is_authenticated = !empty($user->foxycart_id);
		$return_hash = '';
		$redirect_url = '';
		$customer_id = 0;
		$timestamp = 0;
		$fcsid = '';
		if($user_is_authenticated):
			$customer_id = $user->foxycart_id;
		endif;
	
		$redirect_url = 'https://' . $foxycart_domain . '/checkout?fc_auth_token=';
	
		if(isset($_REQUEST['timestamp']) && isset($_REQUEST['fcsid'])):
			$fcsid = $_REQUEST['fcsid'];
			$timestamp = $_REQUEST['timestamp'] + (60 * 30); // valid for 30 minutes;
		endif;
		
		$return_hash = sha1($customer_id . '|' . $timestamp . '|' . $foxycart_api_key);
		$full_redirect = $redirect_url . $return_hash . '&fc_customer_id=' . $customer_id . '&timestamp=' . $timestamp . '&fcsid=' . $fcsid;
		
		return Redirect::to($full_redirect);
	}

	public function receive()
	{
		$response = '';
		$api_key = Config::get('foxycart.api-key');
		// Handle the Webhook from Foxycart
		if(!empty($api_key)):
			if(isset($_POST["FoxyData"])):
				$response = $this->handle_transaction_webhook();
			elseif (isset($_POST["FoxySubscriptionData"])): 	
				$response = $this->handle_subscription_webhook();
			else:
				$response = 'No data received from Foxycart.';
			endif;		
		else:
			$response = 'No Foxycart API Key set.';
			Log::error($response);
		endif;

		return $response;
	}

	public function handle_transaction_webhook(){
		// ****************************************
		// TRANSACTION DATAFEED
		// ****************************************		
		$api_key = Config::get('foxycart.api-key');

		try{
			$foxyXML = rc4crypt::decrypt($api_key, urldecode($_POST['FoxyData']));
		
			$response = simplexml_load_string($foxyXML);
			Transaction::create_from_foxy_api($response,true); // true denotes it's from the webhook

			// Any errors?
			return 'foxy';
		}
		catch(Exception $e){
			Log::error($e);
			return $e;
		}
	}
	
	public function handle_subscription_webhook(){
		// ****************************************
		// SUBSCRIPTION DATAFEED
		// ****************************************
		$api_key = Config::get('foxycart.api-key');

		$failedDaysBeforeCancel = Config::get('foxycart.failedDaysBeforeCancel');
		$billingReminderFrequencyInDays = Config::get('foxycart.billingReminderFrequencyInDays');
		$updatePaymentMethodReminderDaysOfTheMonth = Config::get('foxycart.updatePaymentMethodReminderDaysOfTheMonth');
		
		$FoxyData_encrypted = urldecode($_POST["FoxySubscriptionData"]);
		$FoxyData_decrypted = rc4crypt::decrypt($api_key,$FoxyData_encrypted);
		// make sure we have a valid character encoding
		$enc = mb_detect_encoding($FoxyData_decrypted);
		$FoxyData_decrypted = mb_convert_encoding($FoxyData_decrypted, 'UTF-8', $enc);
		$FoxyDataArray = new SimpleXMLElement($FoxyData_decrypted);

		$admins = User::where('role','admin')->get();
		$freqs = array('1w'=>'weekly','2w'=>'2 weeks','4w'=>'4 weeks','.5m'=>'Twice a month','1m'=>'monthly','2m'=>'2 months','3m'=>'3 months','6m'=>'6 months','1y'=>'yearly','2y'=>'2 years','3y'=>'3 years');

		foreach($FoxyDataArray->subscriptions->subscription as $subscription):
			$email_data = [];
			$user = User::where('foxycart_id',$subscription->customer_id)->where('role','customer')->first();

			$frequency = $subscription->frequency.'';
			$email_data['receipt'] = 'Frequency: <strong>';
			$email_data['receipt'] .= array_key_exists($frequency,$freqs) ? $freqs[$frequency] : $frequency;
			$email_data['receipt'] .= '</strong><br><br>';
			foreach($subscription->transaction_details->transaction_detail as $td):
				// write the receipt
				$email_data['receipt'].= $td->product_quantity.' x <strong>'.$td->product_name.'</strong> @ $'.$td->product_price.' '.($td->product_code.'' ? '(SKU: '.$td->product_code.')' : '').'<br>';
			endforeach;

			$email_data['customer_info'] = '<strong>Customer Info:</strong><br />
				'.$subscription->customer_first_name.' '.$subscription->customer_last_name.' (#'.$subscription->customer_id.')<br />
				'.$subscription->customer_address1.' '.$subscription->customer_address2.'<br />
				'.$subscription->customer_city.' '.$subscription->customer_state.' '.$subscription->customer_postal_code.' '.$subscription->customer_country.' <br />
				'.$subscription->customer_phone.'<br />
				'.$subscription->customer_email;

			if(!empty($subscription->error_message)):
				$email_data['error'] = $subscription->error_message;
			endif;

			$canceled = 0;
			$sendReminder = 0;
			$pastgraceperiod = 0;
			$SUBNEXTDATE = date('F j, Y',strtotime($subscription->next_transaction_date.''));
			if (date("Y-m-d",strtotime("now")) == date("Y-m-d", strtotime($subscription->end_date))):
				// this entry was cancelled today...
				$canceled = 1;
			endif;
			if (!$canceled && $subscription->past_due_amount > 0):
				$failedDays = floor((strtotime("now") - strtotime($subscription->transaction_date)) / (60 * 60 * 24));
				
				if ($failedDays > $failedDaysBeforeCancel):
					$pastgraceperiod = 1;
				else:
					if (($failedDays % $billingReminderFrequencyInDays) == 0):
						$sendReminder = 1;
					endif;
				endif;
			endif;
			if ($canceled):
				// Set subscription to inactive
				$user->subscription_active = 0;
				$user->save();

				Log::info('Foxy ID #'.$subscription->customer_id.' '.$subscription->customer_first_name.' '.$subscription->customer_last_name.' canceled '.$email_data['receipt']);
				// Send an email to the Admin(s) that the customer canceled								
				Mail::send('emails.subscriptions.canceled', $email_data, function($message){
					foreach($admins as $admin):
						$message->to($admin->email, $admin->name)->subject('A customer subscription ended');
					endforeach;
					// send the email to the customer too
					$message->to($user->email, $user->name)->subject('Subscription ended');
				});
				
			endif;
			if ($sendReminder):
				Log::info('#'.$subscription->customer_id.' '.$subscription->customer_first_name.' '.$subscription->customer_last_name.' expired cc - reminder to update '.$email_data['receipt']);
				// Send an email to the Customer asking to update cc
				Mail::send('emails.subscriptions.update-cc', $email_data, function($message){
					foreach($admins as $admin):
						$message->to($admin->email, $admin->name)->subject('A customer\'s payment information needs update');
					endforeach;
					// send the email to the customer too
					$message->to($user->email, $user->name)->subject('Payment information needs update');
				});
			endif;
			if($pastgraceperiod):
				Log::info('#'.$subscription->customer_id.' '.$subscription->customer_first_name.' '.$subscription->customer_last_name.' past grace period '.$email_data['receipt']);
				// the customer is past the grace period - let them know
				Mail::send('emails.subscriptions.past-grace-period', $email_data, function($message){
					foreach($admins as $admin):
						$message->to($admin->email, $admin->name)->subject('A customer is past the grace period');
					endforeach;
					// send the email to the customer too
					$message->to($user->email, $user->name)->subject('Past grace period');
				});
			endif;
			unset($email_data);
		endforeach;
		// send emails to customers with soon to expire credit cards. 
		// Ignore already expired cards, since they should have already been sent an email when their payment failed.
		if (in_array(date("j"),$updatePaymentMethodReminderDaysOfTheMonth)):
			foreach($FoxyDataArray->payment_methods_soon_to_expire->customer as $customer):
				if (mktime(0,0,0,$customer->cc_exp_month+1, 1, $customer->cc_exp_year+0) > strtotime("now")):
					// email reminders
					Log::info('#'.$customer->customer_id.' '.$customer->customer_first_name.' '.$customer->customer_last_name.' about to expire cc');
					// Send an email to the Customer asking to update cc
					Mail::send('emails.subscriptions.cc-almost-expired', [], function($message){
						foreach($admins as $admin):
							$message->to($admin->email, $admin->name)->subject('A customer credit card will expire soon');
						endforeach;
						// send the email to the customer too
						$message->to($customer->email, $customer->customer_first_name.' '.$customer->customer_last_name)->subject('Your credit card will expire soon');
					});
				endif;
			endforeach;
		endif;

		return "foxy";
	}

}
