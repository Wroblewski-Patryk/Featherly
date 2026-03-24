<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\ContentPolicy;

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
        Gate::policy(Page::class, ContentPolicy::class);
        Gate::policy(Post::class, ContentPolicy::class);
        Gate::policy(Project::class, ContentPolicy::class);

        // Implicitly grant "admin" role all permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
