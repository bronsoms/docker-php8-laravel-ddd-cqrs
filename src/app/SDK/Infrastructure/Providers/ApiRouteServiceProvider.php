<?php

namespace App\SDK\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class ApiRouteServiceProvider extends ServiceProvider
{
    public const INTERNAL_API_PREFIX = '/api';

    public const AUTH_NAMESPACE = 'SDK\Infrastructure\Ui\Http\Controller\Auth';
    public const USER_NAMESPACE = 'SDK\Infrastructure\Ui\Http\Controller\User';

    public function map()
    {
        $this->mapAuthRoutes();
        $this->mapUserRoutes();
    }

    private function mapAuthRoutes(): void
    {
        Route::group([
            'namespace' => self::AUTH_NAMESPACE,
            'prefix' => self::INTERNAL_API_PREFIX . '/auth',
        ], function () {
            require __DIR__ . '/../Ui/Http/Routing/auth.php';
        });
    }

    private function mapUserRoutes(): void
    {
        Route::group([
            'namespace' => self::USER_NAMESPACE,
            'prefix' => self::INTERNAL_API_PREFIX . '/users',
        ], function () {
            require __DIR__ . '/../Ui/Http/Routing/user.php';
        });
    }
}
