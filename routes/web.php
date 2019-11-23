<?php

use App\Events\WebsocketEventDemo;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chat', 'ChatController@index');
Route::get('/chat_data', 'ChatController@data');
Route::post('/chat_store', 'ChatController@store');