<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ballot', 'BoothController@ballot_json');
Route::get('/ballot/qr/{ref}', 'BoothController@ballot_qr');
Route::post('/precheck', 'BoothController@precheck');
Route::post('/request_sms', 'BoothController@request_sms');
Route::post('/cast_ballot', 'BoothController@cast_ballot');
