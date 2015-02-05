<?php namespace Admin;

use User,Config,Exception,FoxyApiController,Input,Log,Redirect,Response,Session,View;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$view_args['users'] = User::orderBy('id','DESC')->where('role','customer')->get();
		return View::make('admin.user.index')->with($view_args);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$view_args = [];
		$view_args['user'] = User::find($id);
		return View::make('admin.user.edit')->with($view_args);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();
		return Redirect::route('admin.user.index');
	}


	// Deactivate Subscription at FoxyCart
	public function deactivate_subscription($id){
		$user = User::find($id);
		$alert = 'There was a problem.';
		if(!empty($user->subscription_active) && !empty($user->subscription_token)):
			$api = new FoxyApiController;
			$response = $api->call('subscription_cancel',['sub_token'=>$user->subscription_token]);
			if($response->result == 'SUCCESS'):
				$user->subscription_active = 0;
				$user->subscription_ends_at = \Carbon\Carbon::tomorrow();
				$user->save();
				$alert = 'Subscription set to cancel tomorrow';
			endif;
		endif;
		Session::flash('alert',$alert);
		return Redirect::route('admin.user.edit',['id'=>$id]);
	}

}
