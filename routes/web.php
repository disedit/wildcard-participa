<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

/* Booth */
Route::get('/booth/summary', 'HomeController@index');
Route::get('/booth/confirmation', 'HomeController@index');

/* Archive */
Route::get('/archive', 'ArchiveController@home');
Route::get('/archive/{edition}', 'ArchiveController@edition');

/* Admin */
Route::get('/admin', 'AdminController@index');
