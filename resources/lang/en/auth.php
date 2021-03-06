<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'permissions' => [
        'view_usermgmt' => 'User management: View users and roles',
        'usermgmt_manage_users' => 'User management: Create, edit and delete users',
        'usermgmt_manage_roles' => 'User management: Create, edit and delete roles',

        'configure_common_settings' => 'Configure common settings',

        'create_badges' => 'Badges: Create badges',

        'view_fundraising_donors_donations' => 'Donation management: View donors & donations',
        'manage_fundraising_donors_donations' => 'Donation management: Manage donors & donations',
        'view_fundraising_reports' => 'Donation management: View reports',
        'accept_fundraising_donations_webhooks' => 'Donation management: Accept Webhooks',

        'view_transactions' => 'Accounting: View transactions',
        'create_transactions' => 'Accounting: Register transactions',
        'update_transactions' => 'Accounting: Edit transactions',
        'delete_transactions' => 'Accounting: Delete transactions',
        'book_externally' => 'Accounting: Book transactions externally',
        'view_summary' => 'Accounting: View summary',
        'manage_suppliers' => 'Accounting: Manage suppliers',
        'configure_accounting'  => 'Accounting: Configure settings',

        'view_wiki' => 'Wiki: View articles',
        'edit_wiki' => 'Wiki: Create and edit articles',
        'delete_wiki' => 'Wiki: Delete articles',

        'view_community_volunteers' => 'Community volunteers: View community volunteers',
        'manage_community_volunteers' => 'Community volunteers: Manage community volunteers',

        'register_visitors' => 'Visitors: Register',
        'export_visitors' => 'Visitors: Export',
    ],
];
