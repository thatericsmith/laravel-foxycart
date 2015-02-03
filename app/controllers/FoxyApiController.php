<?php

class FoxyApiController extends BaseController {

	public function call($action,$data = array()){		
		// foxy api
		$foxy_domain = Config::get('foxycart.store-url').'.foxycart.com';
		$data["api_token"] = Config::get('foxycart.api-key');
		$data["api_action"] = $action;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://" . $foxy_domain . "/api");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		// If you get SSL errors, you can uncomment the following, or ask your host to add the appropriate CA bundle
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = trim(curl_exec($ch));

		// The following if block will print any CURL errors you might have
		if ($response == false):
			Log::error("Foxycart API error: CURL Error: \n" . curl_error($ch));
			return false;
		endif;

		curl_close($ch);

		libxml_use_internal_errors(true);

		if(!$foxyResponse = simplexml_load_string($response, NULL, LIBXML_NOCDATA)):
			libxml_clear_errors();
			Log::error('Foxycart API error: XML error');
			return false;
		endif;
		
		return $foxyResponse;
	}

	public function get_customers(){
		return $this->call('customer_list');
	}

	public function get_transactions(){
		dd($this->call('transaction_list'));
	}

	public function get_subscriptions(){
		return $this->call('subscription_list');
	}

	public function get_customer($email){
		return $this->call('customer_get',['customer_email'=>$email]);
	}

	public function save_customer($user){
		$data = ['customer_id'=>$user->foxcart_id];
		$user_arr = $user->toArray();
		$fields = ['first_name','last_name','address1','address2','company','city','state','zip','country','email','phone'];
		foreach($fields as $field):
			$data['customer_'.$field] = $user_arr[$field];
		endforeach;

		return $this->call('customer_save',$data);
	}

}
