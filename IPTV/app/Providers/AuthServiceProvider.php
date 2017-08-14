<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
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
 
        Passport::routes();
 
        Passport::tokensExpireIn(Carbon::now()->addMonths(1));
 
        Passport::refreshTokensExpireIn(Carbon::now()->addYears(1));

        Passport::tokensCan([
            'iptv' => 'Ip TV access',
            'vod' => 'VOD Access',
            'mature-content' => 'mature content access',
            'shopping' => 'shopping access',
            'reception' => 'reception access'
        ]);
    }
}
