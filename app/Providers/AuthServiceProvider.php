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
        \App\User::class                        => \App\Policies\UserPolicy::class,
        \App\Role::class                        => \App\Policies\RolePolicy::class,
        \App\Tag::class                         => \App\Policies\TagPolicy::class,
        \App\Models\Fundraising\Donor::class    => \App\Policies\Fundraising\DonorPolicy::class,
        \App\Models\Fundraising\Donation::class => \App\Policies\Fundraising\DonationPolicy::class,
    ];

    protected $permissions = [
        'app.usermgmt.view' => [
            'label' => 'permissions.view_usermgmt',
            'sensitive' => true,
        ],
        'app.usermgmt.users.manage' => [
            'label' => 'permissions.usermgmt_manage_users',
            'sensitive' => true,
        ],
        'app.usermgmt.roles.manage' => [
            'label' => 'permissions.usermgmt_manage_roles',
            'sensitive' => false,
        ],

        'app.changelogs.view' => [
            'label' => 'permissions.view_changelogs',
            'sensitive' => false,
        ],

        'app.logs.view' => [
            'label' => 'permissions.view_logs',
            'sensitive' => true,
        ],

        'badges.create' => [
            'label' => 'permissions.create_badges',
            'sensitive' => false,
        ],

        'fundraising.donors.view' => [
            'label' => 'permissions.view_fundraising_donors',
            'sensitive' => true,
        ],
        'fundraising.donors.manage' => [
            'label' => 'permissions.manage_fundraising_donors',
            'sensitive' => true,
        ],
        'fundraising.donations.view' => [
            'label' => 'permissions.view_fundraising_donations',
            'sensitive' => true,
        ],
        'fundraising.donations.register' => [
            'label' => 'permissions.register_fundraising_donations',
            'sensitive' => true,
        ],
        'fundraising.donations.edit' => [
            'label' => 'permissions.edit_fundraising_donations',
            'sensitive' => true,
        ],
        'fundraising.donations.accept_webhooks' => [
            'label' => 'permissions.accept_fundraising_donations_webhooks',
            'sensitive' => false,
        ],
    ];

    protected $permission_gate_mappings = [
        'view-reports'                => ['people.reports.view', 'bank.statistics.view', 'app.usermgmt.view'], // TODO
        'view-usermgmt-reports'       => 'app.usermgmt.view',
        'view-changelogs'             => 'app.changelogs.view',
        'view-logs'                   => 'app.logs.view',
        'create-badges'               => 'badges.create',
        'accept-fundraising-webhooks' => 'fundraising.donations.accept_webhooks',
    ];

}
