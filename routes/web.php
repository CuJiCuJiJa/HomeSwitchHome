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

Route::get('/', 'PageController@index')->name('slash');

//TEST ROUTE
Route::get('/test', 'AdminController@testFunction');

Auth::routes();

  Route::group(['middleware' => 'checkAuction'], function() {
    Route::group(['middleware' => 'auth'], function() {
		Route::resources([
			'auction'		=> 'AuctionController',
			'home'			=> 'HomeController',
			'hotsale'		=> 'HotsaleController',
			'reservation'	=> 'ReservationController',
			'user'			=> 'UserController',
			'admin'			=> 'AdminController',
		]);
	

//ADJUDICAR SUBASTA
Route::post('/adjudicate/{auction_id}', 'AdminController@adjudicar')->name('admin.adjudicar');

//PUJAR SUBASTA CON VERIFYCARD MIDDLEWARE
Route::post('/bid/{id}', 'UserController@pujar')->name('user.bid'); //->middleware('verifyCard'); comentado para el demo1
//BUSCAR SUBASTA
Route::get('/getSearchAuction', 'SearchController@getSearchAuction')->name('getSearch.auction');
Route::post('/postSearchAuction', 'SearchController@postSearchAuction')->name('postSearch.auction');
//BUSCAR HOTSALE
Route::get('/getSearchHotsale', 'SearchController@getSearchHotsale')->name('getSearch.Hotsale');
Route::post('/postSearchHotsale', 'SearchController@postSearchHotsale')->name('postSearch.Hotsale');
//BUSCAR RESERVA
Route::get('/getSearchReserve', 'SearchController@getSearchHome')->name('getSearch.reserve');
Route::post('/postSearchReserve', 'SearchController@postSearchHome')->name('postSearch.reserve');
//RESERVAR
Route::get('/reservation/create/{home_id}', 'ReservationController@create')->name('reservation.create');
//
Route::get('/reservation/create/{home_id}/{week}', 'ReservationController@create')->name('reservation.create');
//ANULAR RESIDENCIA
Route::post('/anular/{id}', 'HomeController@anular')->name('home.anular');
//RESTAURAR RESIDENCIA BORRADA
Route::post('/restore/{id}', 'HomeController@restore')->name('home.restore');
//APROBAR NRO DE TARJERA
Route::post('/approbe/{id}', 'AdminController@approbeCard')->name('admin.approbe');
//RECHAZAR NRO DE TARJERA
Route::post('/decline/{id}', 'AdminController@declineCard')->name('admin.decline');
//MARCAR USUARIO COMO...
Route::post('/markAs/{user}', 'AdminController@markAs')->name('admin.markAs');
//BUSCAR HOTSALE
Route::get('/getSearchHotsale', 'SearchController@getSearchHotsale')->name('getSearch.hotsale');
Route::post('/postSearchHotsale', 'SearchController@postSearchHotsale')->name('postSearch.hotsale');
//PUBLICAR HOTSALE
Route::post('/activate/{id}', 'HotsaleController@activate')->name('hotsale.activate');
//DESPUBLICAR HOTSALE
Route::post('/desactivate/{id}', 'HotsaleController@desactivate')->name('hotsale.desactivate');
//RESERVAR HOTSALE
Route::post('/reserve/{id}', 'HotsaleController@reserve')->name('hotsale.reserve');
//CANCELAR HOTSALE
Route::post('/cancel/{id}', 'HotsaleController@cancel')->name('hotsale.cancel');
//MIS HOTSALES
Route::get('/myHotsales', 'HotsaleController@myHotsales')->name('hotsale.myHotsales');
//MIS SUBASTAS
Route::get('/myAuctions', 'AuctionController@myAuctions')->name('auction.myAuctions');
//MIS HOTSALES
Route::get('/myHotsales', 'HotsaleController@myHotsales')->name('hotsale.myHotsales');
//MIS RESERVAS
Route::get('/myReservations', 'ReservationController@myReservations')->name('reservation.myReservations');
//MI HISTORIAL
Route::get('/myHistory', 'UserController@myHistory')->name('user.myHistory');
//CANCELAR SUBASTA
Route::post('/cancelAuction/{auction}', 'UserController@cancelAuction')->name('user.cancelAuction');

Route::post('/changePassword','HomeController@changePassword')->name('changePassword');
Route::get('/getchangePassword','HomeController@getchangePassword')->name('getchangePassword');
});
});

//

