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

Route::get('/ballot', 'BallotController@ballotJSON');
Route::get('/ballot/qr/{ref}', 'BallotController@ballotQR');
Route::post('/precheck', 'BoothController@precheck');
Route::post('/request_sms', 'BoothController@requestSms');
Route::post('/cast_ballot', 'BoothController@castBallot');
Route::post('/anull_ballot', 'AdminController@anullBallot');
