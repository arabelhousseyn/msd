<?php

use App\Enums\Permissions;

return [
    Permissions::class => [
        Permissions::MANAGE_DASHBOARD => 'Manage statistics',
        Permissions::MANAGE_USERS => 'Manage Users',
        Permissions::MANAGE_COMPANIES => 'Manage departments',
        Permissions::MANAGE_FOLDERS => 'Manage Folders',
        Permissions::MANAGE_PROFILE => 'Manage Profile',
        Permissions::MANAGE_SETTINGS => 'Manage Settings',
        Permissions::MANAGE_MAIN_COMPANY => 'Manage general settings',
        Permissions::MANAGE_ALL_FOLDERS => 'Manage all folders assigned to all users',
        Permissions::MANAGE_INBOX => 'Manage inbox',
        Permissions::MANAGE_UNREAD => 'Manage unread',
        Permissions::MANAGE_INPROGRESS => 'Manage in progress',
        Permissions::MANAGE_ARCHIVE => 'Manage archive',
        Permissions::MANAGE_TRASH => 'Manage trash',
    ]
];
