<?php

namespace App\Providers;

use App\Models\User;
use App\Services\ComplaintService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ComplaintService::class, function ($app) {
            return new ComplaintService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add the leading backslash here:
        Gate::define('manage-admins', function (User $user) {
            return $user->email === 'admin@example.com';
        });
    }
}
