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
Route::get('login/google', 'Auth\GoogleController@redirectToProvider');
Route::get('login/google/callback', 'Auth\GoogleController@handleProviderCallback');

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'panel'], function () {
    Route::get('dashboard', 'Panel\DashboardController@index')->name('panel-dashboard');
    Route::group(['prefix' => 'channels'], function () {
        Route::get('/', 'Panel\ChannelController@index')->name('panel-channels');
        Route::post('add', 'Panel\ChannelController@add')->name('panel-channels-add');
        Route::post('edit', 'Panel\ChannelController@edit')->name('panel-channels-edit');
        Route::post('delete', 'Panel\ChannelController@delete')->name('panel-channels-delete');
    });
    Route::group(['prefix' => 'keywords'], function () {
        Route::get('/', 'Panel\KeywordController@index')->name('panel-keywords');
        Route::post('add', 'Panel\KeywordController@add')->name('panel-keywords-add');
        Route::post('edit', 'Panel\KeywordController@edit')->name('panel-keywords-edit');
        Route::post('delete', 'Panel\KeywordController@delete')->name('panel-keywords-delete');
    });
});
