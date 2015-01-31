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

Route::get('/', ['as'=>'index','uses'=> 'HomeController@getIndex']);

Route::any('/foxycart/webhook', ['as'=>'webhook','uses'=> 'WebhookController@receive']);
Route::any('/foxycart/webhook/test', ['as'=>'webhook.test','uses'=> 'WebhookTestController@send']);

// Admin
Route::get('/login', ['as'=>'login','uses'=> 'AdminController@getLogin']);
Route::post('/login', ['as'=>'login.post','uses'=> 'AdminController@postLogin']);

//Route::group(['before'=>'auth.admin', 'prefix' => 'admin'], function(){
Route::group(['prefix' => 'admin'], function(){
    
    Route::get('/', ['as'=>'admin.index','uses'=> 'AdminController@index']);
    Route::get('timeline',['as'=>'admin.timeline','uses'=>'AdminController@timeline']);
	Route::resource('user', 'Admin\UserController');
});