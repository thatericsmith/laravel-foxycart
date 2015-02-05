<?php namespace Admin;

use Config,Exception,Input,Log,Redirect,Response,Transaction,View;

class TransactionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$view_args['transactions'] = Transaction::with('user')->orderBy('id','DESC')->get();
		return View::make('admin.transaction.index')->with($view_args);
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
		$view_args['transaction'] = Transaction::find($id);
		return View::make('admin.transaction.edit')->with($view_args);
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
	}

	//

	public function refresh(){
		$api = new FoxyApiController;
		Transaction::create_from_foxy_api($api->get_transactions());
		Session::flash('alert','Transactions downloaded.');
		return Redirect::route('admin.transaction.index');
	}


}
