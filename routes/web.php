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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/embedded', 'HomeController@embedded')->name('embedded');

Route::middleware('auth')->group(function (){
    Route::post('/rooms', 'RoomController@store');
    Route::get('/rooms/data', 'RoomController@data');
    Route::delete('/rooms/{room}', 'RoomController@delete');
    Route::delete('/rooms/multi_delete', 'RoomController@multiDelete');
    Route::post('/rooms/join/{room}', 'RoomController@join');
});


