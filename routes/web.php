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

Route::post('/books', 'BooksController@store' );

Route::patch('/books/{book}', 'BooksController@update' );

Route::delete('/books/{book}', 'BooksController@destroy');

//Author

Route::post('/author', 'AuthorController@store' );
Route::patch('/author/{author}',  'AuthorController@update' );


//Reservation
Route::post('/reservation_out/{book}', 'ReservationController@store' )->middleware('auth');

Route::post('/reservation_in/{book}', 'ReservationController@update' );
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
