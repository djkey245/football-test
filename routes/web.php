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

Route::get('/', 'MainController@index')->name('home');
Route::get('/test', 'MainController@test');
Route::get('/policy', 'MainController@policy');
Route::get('/blogs', 'BlogController@index');
Route::get('/blog/{blog}', 'BlogController@post');
Route::get('/news', 'NewsController@index');
Route::get('/news/{news}', 'NewsController@news');
Route::get('/label/{label}', 'NewsController@label');
Route::get('/league/{league}', 'ScoreController@league');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
