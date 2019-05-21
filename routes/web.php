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


/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'PageController@index');

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

Route::get('/getSearchAuction', 'SearchController@getSearchAuction')->name('getSearch.auction');	
Route::post('/postSearchAuction', 'SearchController@postSearchAuction')->name('postSearch.auction');


