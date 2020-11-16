<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {

    // Route::get('posts', 'PostController@index');
    // Route::post('posts', 'PostController@store');

    Route::apiResources([
        'posts' => 'PostController',
        'users' => 'UserController'
    ]);
});
