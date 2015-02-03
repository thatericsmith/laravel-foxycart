<?php

class AccountController extends BaseController {

	public function getLogout()
	{
		// Logout the user, send them home.
		Auth::logout();
		return Redirect::route('index');
	}
	
	public function getLogin()
	{
		// Show the login form
		return View::make('account/login');
	}

	public function postLogin()
	{
		$email = Input::get('email');
		$password = Input::get('password');
		$remember = Input::get('remember');
		// First try them on the site?
		if(!empty($password) && Auth::attempt(array('email' => $email, 'password' => $password),$remember)):
			return Redirect::route('account.index');
		endif;

		// Next - see if they have a Foxy account, but have never logged in before
		$api = new FoxyApiController;
		$response = $api->get_customer($email);
		if(!empty($response) && $response->result == 'SUCCESS'):
			$salt = isset($response->customer_password_salt) ? $response->customer_password_salt :'';
			if(hash("sha256",$password.$salt) == $response->customer_password):
				// Valid user!  Let's add them to our db
				$user = User::create_from_foxy_api($response,$password);
				Auth::login($user);
				return Redirect::route('account.index');
			endif;
		endif;
		
		return Redirect::route('account.login')->with('alert','Login incorrect, please try again.');
	}

	public function getIndex()
	{
		$view_args = ['user'=>Auth::user()];
		return View::make('account/index')->with($view_args);
	}

	public function refreshTransactions()
	{
		return Redirect::route('account.login')->with('alert','Login incorrect, please try again.');
	}

	public function getAddress()
	{
		//show the address form
		$view_args = ['user'=>Auth::user()];
		return View::make('account/address')->with($view_args);
	}

	public function postAddress()
	{
		$user = Auth::user();
		$user->email = Input::get('email');
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->address1 = Input::get('address1');
		$user->address2 = Input::get('address2');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		$user->zip = Input::get('zip');
		$user->phone = Input::get('phone');
		$user->company = Input::get('company');
		$user->save();

		// save this user to Foxy API
		$api = new FoxyApiController;
		$api->save_customer($user);
		
		return Redirect::route('account.index')->with(['alert'=>'Saved.','alert-type'=>'success']);
	}

}
