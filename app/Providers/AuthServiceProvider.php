<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->hasRole('admin');
        }); /* use if (Gate::allows('admin')) {} */

        Gate::define('author', function ($user) {
            return $user->hasRole('author');
        });

        Gate::define('user', function ($user) {
            return $user->hasRole('user');
        });

        Gate::define('admin-or-author', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('author');
        }); /* if (Gate::denies('admin-or-author')) { abort(403, 'Unauthorized action.'); } */
        

        Gate::define('view-post', function ($user, $post) {
            return ( ($user->hasRole('admin') || $user->hasRole('author'))
                ||
                $user->id === $post->user_id );
            
        });        

        #Gate::define('update-post', [PostPolicy::class, 'view']);
        #Gate::define('delete-post', [PostPolicy::class, 'delete']);
        
        //
        /* Gate::any(['update-post', 'delete-post'], function (User $user, Post $post) {
            return $user->id === $post->user_id;
        }); */            

        
        /* Gate::any(['view-post'], function (User $user, Post $post) {
            return $user->id === $post->user_id;
        }); */
               

        /* Gate::define('create-post', function (User $user, Category $category, $pinned) {
            if (! $user->canPublishToGroup($category->group)) {
                return false;
            } elseif ($pinned && ! $user->canPinPosts()) {
                return false;
            }
        
            return true;
        });
        
        if (Gate::check('create-post', [$category, $pinned])) {
            // The user can create the post...
        } */      
        
        /* Gate::define('edit-settings', function (User $user) {
            return $user->isAdmin
                        ? Response::allow()
                        : Response::deny('You must be an administrator.');
        });
        before or after 
        Gate::before(function ($user, $ability) {
            if ($user->isAdministrator()) {
                return true;
            }
        });        
        */
    }
}
