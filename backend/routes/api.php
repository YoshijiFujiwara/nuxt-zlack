<?php

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

Route::group(['prefix' => 'workspaces'], function() {
    Route::post('/', 'WorkspaceController@store')->middleware('auth:api');
    Route::get('/', 'WorkspaceController@index')->middleware('auth:api');
});