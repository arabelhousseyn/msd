<?php

use App\Enums\Permissions;

return [
    Permissions::class => [
        Permissions::MANAGE_DASHBOARD => 'Manage Dashboard',
        Permissions::MANAGE_USERS => 'Manage Users',
        Permissions::MANAGE_COMPANIES => 'Manage Companies',
        Permissions::MANAGE_FOLDERS => 'Manage Folders',
        Permissions::MANAGE_PROFILE => 'Manage Profile',
        Permissions::MANAGE_SETTINGS => 'Manage Settings',
        Permissions::MANAGE_MAIN_COMPANY => 'Manage main company'
    ]
];
