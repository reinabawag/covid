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

Route::get('/', function () {
    return redirect()->route('visitor');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/visitor', 'VisitorController@index')->name('visitor');

Route::middleware(['auth'])->group(function () {
    Route::get('question', 'QuestionController@index')->name('question.index');
});