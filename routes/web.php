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

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');
Route::get('admin', 'HomeController@index')->name('admin');

Route::get('admin/wallet', 'HomeController@showWallet')->name('wallet')->middleware('auth');
Route::get('admin/currencies', 'HomeController@showCurrencies')->name('currencies')->middleware('auth');
Route::get('admin/currency/{n}', 'HomeController@showCurrency')->where('n', '[A-Z]+')->middleware('auth');
Route::get('admin/account', 'HomeController@showAccount')->name('account')->middleware('auth');

Route::resource('admin/users', 'UsersController')->middleware('auth');
