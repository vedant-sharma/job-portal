<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Job;
use App\Observers\UserObserver;
use App\Observers\JobObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Job::observe(JobObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Contracts\OtpRepository::class,
            \App\Repositories\Database\OtpRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\UserRepository::class,
            \App\Repositories\Database\UserRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\JobRepository::class,
            \App\Repositories\Database\JobRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\AppliedJobRepository::class,
            \App\Repositories\Database\AppliedJobRepository::class
        );
    }
}
