<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function transactions(){
        return $this->hasMany('Transaction');
    }

	public function admin_permalink(){
		return route('admin.user.edit',$this->id);
	}

	public static function create_from_foxy_api($response,$password = null){
		$user_error = empty($response->customer_email) || User::where('email',$response->customer_email)->count();
		if($user_error):
			Log::error('Attempted to add new customer with email:'.$response->customer_email);
			return false;
		endif;
		$user = new User;
		$user->role = 'customer';
		$user->foxycart_id = $response->customer_id;
		$user->first_name = $response->customer_first_name;
		$user->last_name = $response->customer_last_name;
		$user->email = $response->customer_email;
		$user->address1 = $response->customer_address1;
		$user->address2 = $response->customer_address2;
		$user->city = $response->customer_city;
		$user->state = $response->customer_state;
		$user->postal_code = $response->customer_postal_code;
		$user->country = $response->customer_country;
		$user->company = $response->customer_company;
		$user->phone = $response->customer_phone;
		$user->last_four = substr($response->cc_number_masked,-4);	
		$user->exp_month = $response->cc_exp_month;	
		$user->exp_year = $response->cc_exp_year;	
		if(!empty($password)):
			$user->password = Hash::make($password);
		endif;

		$user->save();

		return $user;
	}

}
