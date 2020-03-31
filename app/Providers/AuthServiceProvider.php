<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
         'App\BlogPost' => 'App\Policies\BlogPostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//----------------- first way of giving privileges -------------------

        // Gate::define('update-post',function($user, $post) {
        //    return $user->id == $post->user_id;
        //  });
        //   Gate::define('delete-post',function($user, $post) {
        //    return $user->id == $post->user_id;
        //  });

         Gate::before(function($user,  $ability){  // ::before is called before all others Gate methods
            if($user->is_admin && in_array($ability, ['update', 'delete'])) {
                return true;
            }
         });  // all rights to the admin user !!!

// ---------------------------------------------------------------------------

//---------------------- second way to define privileges ----------------------

         // ------this works with authotize()
        //  Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        //  Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');
         Gate::resource('posts', 'App\Policies\BlogPostPolicy');


// -----------------------------------------------------------------------------
    }
}
