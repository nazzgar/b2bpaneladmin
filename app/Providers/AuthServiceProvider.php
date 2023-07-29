<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\BezPrawaZwrotuProductPolicy;
use App\Policies\ContractorPolicy;
use App\Policies\LinPolicy;
use App\Policies\NagPolicy;
use B2BPanel\SharedModels\BezPrawaZwrotuProduct;
use B2BPanel\SharedModels\Contractor;
use B2BPanel\SharedModels\Lin;
use B2BPanel\SharedModels\Nag;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Nag::class => NagPolicy::class,
        Lin::class => LinPolicy::class,
        Contractor::class => ContractorPolicy::class,
        BezPrawaZwrotuProduct::class => BezPrawaZwrotuProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
