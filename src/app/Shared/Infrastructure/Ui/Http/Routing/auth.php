<?php

use Shared\Infrastructure\Ui\Http\Controller\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => []], static function () {
    Route::post('login', 'AuthController@login')->name(AuthController::LOGIN);
});
