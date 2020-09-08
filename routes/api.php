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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/visitor', 'VisitorController@store');

Route::middleware('auth:api')->group(function () {
    Route::post('/question', 'QuestionController@store');
    Route::get('/question', 'QuestionController@getQuestion');
    Route::post('/question/update/{id}', 'QuestionController@update');
    Route::delete('/question/{question}', 'QuestionController@destroy');

    Route::get('/visitors/get', 'VisitorController@getVisitors');
});
