<?php

use SDK\Infrastructure\Ui\Http\Controller\User\UserController;

Route::group(['middleware' => []], static function () {
    Route::get(
        'user',
        'UserController@profile'
    )->name(UserController::USER_PROFILE_ROUTE);
});

