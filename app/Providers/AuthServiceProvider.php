<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // 'App\User' => 'App\Policies\ProfilePolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //

        /*
         * Gate Example using Profile Model
        */
        Gate::define('test-gate', function($model, $record_id) {
            // dd($model);
            // dd($record_id);
            dd($model->id . ' ' . $record_id);

            return $model->id === $record_id;
        });

    }

    /*
    * Gate Example App\Providers\AuthServiceProvider.php:
    *
    Gate::define('update-post', function ($user, Post $post) {
        // $user->hasAccess(['update-post']) <- Needs to be defined in the User Model
        return $user->hasAccess(['update-post']) or $user->id == $post->user_id;
    });
    */

    /*
     * Example of code included in Model App\User.php
     *
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }
    */

    /*
     * Example: view (Blade)
        <div class="panel-heading">
            Posts
            @can('create-post')
                <a class="pull-right btn btn-sm btn-primary" href="{{ route('create_post') }}">New</a>
            @endcan
        </div>
        ...

        @can('update-post', $post)
        <p>
            <a href="{{ route('edit_post', ['id' => $post->id]) }}" class="btn btn-sm btn-default" role="button">Edit</a> 
        </p>
        @endcan
    */
}
