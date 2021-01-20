<?php

use Illuminate\Support\Facades\Route;
use SDK\Infrastructure\Ui\Http\Controller\User\UserController;

Route::group(['middleware' => ['fully-auth']], static function () {
    //Route::get('user', 'UserController@profile')->name(UserController::USER_PROFILE_ROUTE);
    Route::post('user', 'UserController@create')->name(UserController::CREATE_USER);
});

