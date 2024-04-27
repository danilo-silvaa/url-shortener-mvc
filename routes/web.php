<?php

use App\Http\Route;

Route::get('/', 'ShortenerController@index');
Route::get('/{id}', 'ShortenerController@redirect');
Route::post('/create', 'ShortenerController@create');

Route::dispatch();