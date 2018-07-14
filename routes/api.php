<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth:api'], function() {
  Route::get('mail_lists', 'MailListController@index');
  Route::get('mail_lists/{mailList}', 'MailListController@show');
  Route::post('mail_lists', 'MailListController@create');
  Route::put('mail_lists/{mailList}', 'MailListController@update');
  Route::delete('mail_lists/{mailList}', 'MailListController@delete');
});