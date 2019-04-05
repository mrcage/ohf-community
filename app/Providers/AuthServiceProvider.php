<?php

namespace App\Providers;

class AuthServiceProvider extends BaseAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Role::class => \App\Policies\RolePolicy::class,
        \App\Person::class => \App\Policies\PersonPolicy::class,
        \App\CouponType::class => \App\Policies\People\Bank\CouponTypePolicy::class,
    ];

    protected $permissions = [
    ];

    protected $permission_gate_mappings = [
        'view-reports' => ['people.reports.view', 'bank.statistics.view', 'app.usermgmt.view'],
    ];

}
