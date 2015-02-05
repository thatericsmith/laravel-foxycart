<?php

class Transaction extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'transactions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function user(){
        return $this->belongsTo('User');
    }

	public function admin_permalink(){
		return route('admin.transaction.edit',$this->id);
	}

	public static function create_from_foxy_api($response,$from_webhook = false){
		// add transactions to our db

		foreach($response->transactions[0]->transaction as $foxy_transaction):
		
			$transaction_exists = Transaction::where('id',$foxy_transaction->id)->count();
			if(!$transaction_exists):
				Log::info("NEW TRANSACTION #".$foxy_transaction->id." - ".date('Y-m-d g:ia'));
									
				// find out who the user is
				$user = User::where('foxycart_id',$foxy_transaction->customer_id)->where('role','customer')->first();

				if(empty($user)):
					// create a user
					$user = new User;
					$user->role = 'customer';
					$user->foxycart_id = $foxy_transaction->customer_id;
				endif;
				
				// update the customer details
				$user->first_name = $foxy_transaction->customer_first_name;
				$user->last_name = $foxy_transaction->customer_last_name;
				$user->email = $foxy_transaction->customer_email;
				$user->address1 = $foxy_transaction->customer_address1;
				$user->address2 = $foxy_transaction->customer_address2;
				$user->city = $foxy_transaction->customer_city;
				$user->state = $foxy_transaction->customer_state;
				$user->postal_code = $foxy_transaction->customer_postal_code;
				$user->country = $foxy_transaction->customer_country;
				$user->company = $foxy_transaction->customer_company;
				$user->phone = $foxy_transaction->customer_phone;
				$user->last_four = substr($foxy_transaction->cc_number_masked,-4);					
				$user->exp_month = $foxy_transaction->cc_exp_month;					
				$user->exp_year = $foxy_transaction->cc_exp_year;					
				
				// update subscription in the db
				foreach($foxy_transaction->transaction_details[0]->transaction_detail as $transaction_detail):
					# TODO - only allows for one subscription - takes the last one.
					$user->subscription_token = $transaction_detail->sub_token_url;
					$user->subscription_ends_at = $transaction_detail->subscription_enddate;						
					if($from_webhook):
						$user->subscription_active = 1;
					endif;
				endforeach;

				$user->save();

				$transaction = new Transaction;
				$transaction->id = $foxy_transaction->id;
				$transaction->order_total = $foxy_transaction->order_total;
				$transaction->details = json_encode($foxy_transaction->transaction_details[0]->transaction_detail);
				$transaction->user_id = $user->id;
				$transaction->foxycart_id = $foxy_transaction->customer_id;
				$transaction->created_at = $foxy_transaction->transaction_date;
				$transaction->save();
			endif;
		endforeach;
	}

}
