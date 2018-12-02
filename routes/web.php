<?php

//Metodos REST index, create, store, show, edit, upgrade, delete

Route::view('/', 'welcome')->name('home');

//Statuses routes
Route::get('statuses', 'StatusesController@index')->name('statuses.index');
Route::post('statuses', 'StatusesController@store')->name('statuses.store')->middleware('auth');

//Statuses Likes routes
Route::post('statuses/{status}/likes', 'StatusLikeController@store')->name('statuses.like.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikeController@destroy')->name('statuses.like.destroy')->middleware('auth');

Route::auth();