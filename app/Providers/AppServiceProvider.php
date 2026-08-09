<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Super admins bypass every permission check (including Spatie's own
        // `permission` middleware) without needing every permission explicitly assigned.
        Gate::before(function ($user, $ability) {
            return $user->is_super_admin ? true : null;
        });
    }
}
