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
    return view('welcome');
});

Route::get('/getEmails/{page}', ['uses' => 'appController@index'])->name('next');
Route::get('/getData', ['uses' => 'appController@getData'])->name('gdata');

Route::get('/generate-xls', ['uses' => 'appController@generate']);
