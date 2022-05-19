<?php

use Illuminate\Support\Facades\Route;

use App\User;
use App\Events\sendNotification;
use Pusher\Pusher;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');    
Route::get('/watched', 'ItemsController@index')->middleware('auth');    
Route::get('/account', 'UserController@index')->middleware('auth');    
Route::get('/search/{item}', 'ItemsController@searchItem');
Route::get('/readNotifications/{notifId}', 'UserController@setNotificationsAsRead')->middleware('auth');
Route::get('/deleteNotification/{notifId}', 'UserController@deleteNotification')->middleware('auth');
Route::post('/add', 'ItemsController@addToWatch')->middleware('auth');
Route::post('/changePlatform', "UserController@changePlatform")->middleware('auth');
Route::post('/delete', 'ItemsController@delete')->middleware('auth');
Route::post('/update', 'ItemsController@update')->middleware('auth');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');