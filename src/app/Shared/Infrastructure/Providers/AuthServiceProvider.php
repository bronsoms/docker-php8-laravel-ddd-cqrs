<?php

namespace Shared\Infrastructure\Providers;

use Shared\Domain\Model\User\UserRepository;
use Shared\Infrastructure\Service\Auth\DoctrineUserProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        Auth::provider('doctrine', function ($app, array $config) {
            return new DoctrineUserProvider(
                $app->make(DoctrineServiceProvider::ENTITY_MANAGER),
                $app->make(UserRepository::class)
            );
        });
    }
}
