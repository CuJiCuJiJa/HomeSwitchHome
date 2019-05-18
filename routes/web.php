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

<<<<<<< HEAD
/*Route::get('/', function () {
    return view('welcome');
});*/
=======
>>>>>>> 05e74dda27bd30a8134deff9082418980b7ee9c8

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
Route::post('/bid', 'UserController@pujar'); //->middleware('verifyCard'); comentado para el demo1

<<<<<<< HEAD
Route::get('/', 'PageController@index')->name('home');
=======
Route::get('/', 'PageController@index');
>>>>>>> 05e74dda27bd30a8134deff9082418980b7ee9c8
