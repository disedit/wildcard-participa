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
Route::get('/about', 'HomeController@about');
Route::get('/booth/{route}', 'HomeController@index');
Route::get('/ballots/{ballot}', 'BallotController@ballots');
Route::get('/my_ip', 'HomeController@myIpAddress');
Route::get('/lang/{language}', 'LanguageController@switchLanguage');

Auth::routes();

/* Archive */
Route::get('/archive/{edition}', 'ArchiveController@results');
Route::get('/archive/{edition}/about', 'ArchiveController@about');

/* Admin */
Route::get('/admin', 'AdminController@index')->middleware('auth');
