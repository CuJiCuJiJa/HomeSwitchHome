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

//TEST ROUTE
Route::get('/test', 'AdminController@testFunction');

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

//PUJAR SUBASTA CON VERIFYCARD MIDDLEWARE
Route::post('/bid/{id}', 'UserController@pujar')->name('user.bid'); //->middleware('verifyCard'); comentado para el demo1
//BUSCAR SUBASTA
Route::get('/getSearchAuction', 'SearchController@getSearchAuction')->name('getSearch.auction');
Route::post('/postSearchAuction', 'SearchController@postSearchAuction')->name('postSearch.auction');
//BUSCAR HOTSALE
Route::get('/getSearchHotsale', 'SearchController@getSearchHotsale')->name('getSearch.hotsale');
Route::post('/postSearchHotsale', 'SearchController@postSearchHotsale')->name('postSearch.hotsale');
//BUSCAR RESERVA
Route::get('/getSearchReserve', 'SearchController@getSearchHome')->name('getSearch.reserve');
Route::post('/postSearchReserve', 'SearchController@postSearchHome')->name('postSearch.reserve');
//ANULAR RESIDENCIA
Route::post('/anular/{id}', 'HomeController@anular')->name('home.anular');
//ADJUDICAR
Route::post('/adjudicate/{auction_id}', 'AdminController@adjudicar')->name('admin.adjudicar');
//APROBAR NRO DE TARJERA
Route::post('/approbe/{id}', 'AdminController@approbeCard')->name('admin.approbe');
//RECHAZAR NRO DE TARJERA
Route::post('/decline/{id}', 'AdminController@declineCard')->name('admin.decline');
//RESERVAR
Route::get('/reservation/create/{home_id}/{week}', 'ReservationController@create')->name('reservation.create');
//RESTAURAR RESIDENCIA BORRADA
Route::post('/restore/{id}', 'HomeController@restore')->name('home.restore');
//MARCAR USUARIO COMO...
Route::post('/markAs/{user}', 'AdminController@markAs')->name('admin.markAs');
//LISTAR MIS HOTSALES
Route::get('/myHotsales/{user}', 'HotsaleController@listMyHotsales')->name('hotsales.myHotsales');
