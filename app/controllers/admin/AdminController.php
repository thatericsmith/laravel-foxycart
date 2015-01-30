<?php

class AdminController extends BaseController {

	public function getIndex()
	{		
		$view_args = [];
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