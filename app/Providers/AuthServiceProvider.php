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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // super-admin
        Gate::define('isSuperAdmin', function ($user) {
            if ($user->fk_users_role == config('user_roles.super_admin_role_id'))
            {
                return true;
            }
            return false;
        });
        // admin
        Gate::define('isAdmin', function ($user) {
            if ($user->fk_users_role == config('user_roles.admin_role_id'))
            {
                return true;
            }
            return false;
        });
        //
        // org-admin
        Gate::define('isOrgAdmin', function ($user) {
            if ($user->fk_users_role == config('user_roles.org_admin_role_id'))
            {
                return true;
            }
            return false;
        });
        
    }
}
