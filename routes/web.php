	<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
  Route::resources([
	'auction'		=> 'AuctionController',
	'home'			=> 'HomeController',
	'hotsale'		=> 'HotsaleController',
	'reservation'	=> 'ReservationController',
	'user'			=> 'UserController',
	'admin'			=> 'AdminController',
]);
});

//PUJA SUBASTA CON VERIFYCARD MIDDLEWARE
Route::post('/bid', 'UserController@pujar')->middleware('verifyCard');

Route::get('/home', 'PageController@index')->name('home');
