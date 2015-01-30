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

Route::get('/', array('as'=>'index','uses'=> 'HomeController@getIndex'));

Route::get('/foxycart/webhook', array('as'=>'webhook','uses'=> 'WebhookController@receive'));

// Admin
Route::get('/login', array('as'=>'login','uses'=> 'AdminController@getLogin'));
Route::post('/login', array('as'=>'login.post','uses'=> 'AdminController@postLogin'));

//Route::group(array('before'=>'auth.admin', 'prefix' => 'admin'), function(){
Route::group(array('prefix' => 'admin'), function(){
    
    Route::get('/', array('as'=>'admin.index','uses'=> 'AdminController@getIndex'));
	Route::resource('customer', 'Admin\CustomerController');
	Route::resource('subscription', 'Admin\SubscriptionController');
});