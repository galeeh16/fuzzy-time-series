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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile')->middleware('auth');
Route::get('/ganti-password/{user}', 'HomeController@changePassword')->name('ganti-password')->middleware('auth');
Route::put('ganti-password/{id}', 'HomeController@updatePassword')->name('update-password')->middleware('auth');
Route::resource('user', 'UserController');
Route::get('fuzzy', 'FuzzyController@index');