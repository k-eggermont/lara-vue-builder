<?php

/** Fields data */
Route::get('/api/forms/{resource}/fields', '\Keggermont\LaraVueBuilder\App\Http\Controllers\IndexController@fields')->name("laraVueBuilder.Fields");
Route::get('/api/forms/{resource}/{resourceId}/fields', '\Keggermont\LaraVueBuilder\App\Http\Controllers\IndexController@fields')->name("laraVueBuilder.FieldsFromResource");

/** List */
Route::get('/api/forms/{resource}', '\Keggermont\LaraVueBuilder\App\Http\Controllers\IndexController@index')->name("laraVueBuilder.All");
Route::get('/api/forms/{resource}/{resourceId}', '\Keggermont\LaraVueBuilder\App\Http\Controllers\IndexController@index')->name("laraVueBuilder.ListResource");

/** Create or Edit route */
Route::post('/api/forms/{resource}', '\Keggermont\LaraVueBuilder\App\Http\Controllers\IndexController@create')->name("laraVueBuilder.CreateRoute");
Route::post('/api/forms/{resource}/{resourceId}', '\Keggermont\LaraVueBuilder\App\Http\Controllers\IndexController@store')->name("laraVueBuilder.EditRoute");

/** Delete route */
Route::delete('/api/forms/{resource}/{resourceId}', '\Keggermont\LaraVueBuilder\App\Http\Controllers\IndexController@delete')->name("laraVueBuilder.DeleteRoute");