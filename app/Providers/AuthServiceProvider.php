<?php

namespace App\Providers;

//use Illuminate\Support\ServiceProvider;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Політики додатку.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('update-post', function ($user, Post $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('delete-post', function ($user, Post $post) {
            return $user->id === $post->user_id;
        });
    }
}
