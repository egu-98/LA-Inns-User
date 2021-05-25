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


Route::get( '/', 'Auth\LoginController@showLoginForm' );
Auth::routes([
    'reset' => false,
    'confirm' => false,
]);


Route::get( '/', 'UserHomeController@user_home')->name( 'user_home' );

Route::resource('inns', 'InnController');
Route::get('innSearch', 'InnController@search')->name( 'inn_search' );

Route::resource( 'users', 'UserController' );
Route::get( 'userSearch', 'UserController@search' )->name( 'user_search' );

Route::resource( 'plans', 'PlanController' );

Route::resource( 'reviews', 'ReviewController' );

Route::resource( 'books', 'BookController' );
Route::get( 'preCreateBook', 'BookController@preCreateBook' )->name( 'pre_create_book' );