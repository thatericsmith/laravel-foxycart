<?php

class AdminController extends BaseController {

	public function index()
	{		
		$view_args = [];

		$view_args['num_transactions'] = Transaction::count();
		$view_args['num_customers'] = User::where('role','customer')->count();
		$view_args['num_active'] = User::where('role','customer')->where('subscription_active',1)->count();
		$view_args['num_inactive'] = $view_args['num_customers'] - $view_args['num_active'];
		return View::make('admin/index')->with($view_args);
	}

	public function getLogin()
	{
		//show the login form
		
		return View::make('admin/login');
	}

	public function postLogin()
	{
		$email = Input::get('email');
		$password = Input::get('password');
		$remember = Input::get('remember');
		if(Auth::attempt(array('email' => $email, 'password' => $password),$remember)):
			return Redirect::route('admin.index');
		endif;
		
		return Redirect::route('login')->with('alert','Login incorrect, please try again.');
	}

}