<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');

//Flights
Route::get( '/flight', 'FlightController@index')->name('flight');
Route::get( '/flight/search', 'FlightController@findFlight')->name('find.flight');

//Cities
Route::get( 'city', 'CityController@index')->name('city.index');
Route::get( 'city/list', 'CityController@getList')->name('city.list');
Route::get( 'city/search', 'CityController@search')->name('city.search');
Route::post( 'city/add', 'CityController@addCity')->name('city.add');

//Comments
Route::resource('comments', 'CommentController');

//Import files
Route::post( 'import/', 'ImportDataController@importData')->name('import.data');





