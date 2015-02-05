<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('test',function(){
	$api = new FoxyApiController;
	return $api->get_transactions();
});

Route::get('/', ['as'=>'index','uses'=> 'HomeController@getIndex']);

/*** FOXYCART ***/
// Webhook (Datafeed)
Route::any('/foxycart/webhook', ['as'=>'webhook','uses'=> 'WebhookController@receive']);
Route::any('/foxycart/webhook/test', ['as'=>'webhook.test','uses'=> 'WebhookTestController@send']);
// SSO
Route::any('/foxycart/sso', ['as'=>'sso','uses'=> 'WebhookController@sso']);


/*** CUSTOMER ACCOUNT ***/
Route::get('account/login', ['as'=>'account.login','uses'=> 'AccountController@getLogin']);
Route::post('account/login', ['as'=>'account.login.post','uses'=> 'AccountController@postLogin']);
//Route::group(['before'=>'auth.customer', 'prefix' => 'account'], function(){
Route::group(['prefix' => 'account'], function(){
    Route::get('/', ['as'=>'account.index','uses'=> 'AccountController@getIndex']);
    Route::post('/', ['as'=>'account.index.post','uses'=> 'AccountController@postIndex']);
    Route::get('address',['as'=>'account.address','uses'=>'AccountController@getAddress']);
    Route::post('address',['as'=>'account.address.post','uses'=>'AccountController@postAddress']);
});

/*** ADMIN ***/
Route::get('admin/login', ['as'=>'admin.login','uses'=> 'AdminController@getLogin']);
Route::post('admin/login', ['as'=>'admin.login.post','uses'=> 'AdminController@postLogin']);
//Route::group(['before'=>'auth.admin', 'prefix' => 'admin'], function(){
Route::group(['prefix' => 'admin'], function(){
    
    Route::get('/', ['as'=>'admin.index','uses'=> 'AdminController@index']);
    Route::get('transaction/refresh',['as'=>'admin.transaction.refresh','uses'=>'Admin\TransactionController@refresh']);
    Route::get('user/{id}/deactivate-subscription',['as'=>'admin.user.deactivate-subscription','uses'=>'Admin\UserController@deactivate_subscription']);
	Route::resource('user', 'Admin\UserController');
	Route::resource('transaction', 'Admin\TransactionController');
});

Route::get('logout',['as'=>'logout','uses'=>'AccountController@getLogout']);