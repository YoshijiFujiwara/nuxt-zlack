<?php

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

// workspace
Route::group(['prefix' => 'workspaces'], function() {
    Route::post('/', 'WorkspaceController@store')->middleware('auth:api');
    Route::get('/', 'WorkspaceController@index')->middleware('auth:api');
    Route::get('/{workspace}', 'WorkspaceController@show')->middleware('auth:api');
    Route::patch('/{workspace}', 'WorkspaceController@update')->middleware('auth:api');

    // チャンネルルート
    Route::group(['prefix' => '/{workspace}/channels'], function() {
        Route::get('/{channel}', 'ChannelController@show')->middleware('auth:api');
        Route::post('/', 'ChannelController@store')->middleware('auth:api');

        // メッセージ投稿
        Route::group(['prefix' => '/{channel}/messages'], function() {
            Route::get('/', 'MessageController@indexInChannel')->middleware('auth:api');
            Route::post('/', 'MessageController@storeToChannel')->middleware('auth:api');
        });
    });

    // ユーザールート(todo: messsagesテーブルを変えないと、、、)
});