<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Enums\AdminRole;
use App\Enums\MerchantRole;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::resolveUsersUsing(function ($guard = null) {

            if (auth('epay')->check()) {
                return auth('epay')->user();
            }
            if (auth('merchant')->check()) {
                return auth('merchant')->user();
            }

            return auth('')->user();
        });

        Gate::define("epay_admin", function () {
            if (!auth('epay')->user()){
                return false;
            }
            return auth('epay')->user()->role["name"] ==
                AdminRole::ADMINISTRATOR->value;
        });

        Gate::define("epay_operator", function () {
            if (!auth('epay')->user()){
                return false;
            }
            return auth('epay')->user()->role["name"] ==
                AdminRole::OPERATOR->value;
        });

        Gate::define("epay_all_role", function () {
            if (!auth('epay')->user()){
                return false;
            }
            return auth('epay')->user()->role["name"] ==
                AdminRole::ADMINISTRATOR->value ||
                auth('epay')->user()->role["name"] ==
                AdminRole::OPERATOR->value;
        });

        // make policies for merchant         
        Gate::define("merchant_admin_operator", function () {
            if (!auth('merchant')->user()){
                return false;
            }
            return auth('merchant')->user()->role["name"] ==
            MerchantRole::ADMINISTRATOR->value ||
            auth('merchant')->user()->role["name"] ==
            MerchantRole::OPERATOR->value;
        }); 

        Gate::define("merchant_admin", function () {
            if (!auth('merchant')->user()){
                return false;
            }
            return auth('merchant')->user()->role["name"] ==
            MerchantRole::ADMINISTRATOR->value;
        }); 

        Gate::define("merchant_all_role", function () {
            if (!auth('merchant')->user()){
                return false;
            }
            return auth('merchant')->user()->role["name"] ==
            MerchantRole::ADMINISTRATOR->value ||
            auth('merchant')->user()->role["name"] ==
            MerchantRole::OPERATOR->value ||
            auth('merchant')->user()->role["name"] ==
            MerchantRole::USER->value;
        }); 
    }
}
