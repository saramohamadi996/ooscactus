<?php

namespace Milano\User\Providers;

use Illuminate\Support\ServiceProvider;
use Milano\User\Repositories\Interfaces\LoginRepositoryInterface;
use Milano\User\Repositories\Interfaces\UserRepositoryInterface;
use Milano\User\Repositories\Interfaces\VerifyCodeRepositoryInterface;
use Milano\User\Repositories\LoginRepository;
use Milano\User\Repositories\UserRepository;
use Milano\User\Repositories\VerifyCodeRepository;

class UserBindServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(VerifyCodeRepositoryInterface::class, VerifyCodeRepository::class);
        $this->app->bind(LoginRepositoryInterface::class, LoginRepository::class);
    }
}
