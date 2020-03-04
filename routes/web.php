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

Route::middleware('auth')->group(function () {
    Route::get('admin/account', 'UsersController@show')->name('account');
    Route::get('admin/account/edit', 'UsersController@editAccount')->name('account/edit');
    Route::put('admin/account/udpate', 'UsersController@updateAccount')->name('account.update');
    Route::get('admin/account/reset-password', 'UsersController@resetPassword')->name('account/reset-password');
    Route::put('admin/account/udpate-password', 'UsersController@updatePassword')->name('account.updatePassword');
    Route::get('admin/currencies', 'HomeController@showCurrencies')->name('currencies');
    Route::get('admin/currency/{n}', 'HomeController@showCurrency')->where('n', '[A-Z]+');

    Route::middleware('Client')->group(function () {
        Route::get('admin/currency/{n}/buy', 'TransactionsController@buy')->name('buy');
        Route::get('admin/wallet/sell/{n}', 'TransactionsController@sell');
        Route::resource('admin/wallet', 'TransactionsController');
    });

    Route::middleware('Admin')->group(function () {
        Route::resource('admin/users', 'UsersController');
    });

});
