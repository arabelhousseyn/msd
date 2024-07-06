<?php

use App\Enums\Permissions;

return [
    Permissions::class => [
        Permissions::MANAGE_DASHBOARD => 'إدارة الإحصائيات',
        Permissions::MANAGE_USERS => 'إدارة المستخدمين',
        Permissions::MANAGE_COMPANIES => 'إدارة الأقسام',
        Permissions::MANAGE_FOLDERS => 'إدارة المجلدات',
        Permissions::MANAGE_PROFILE => 'إدارة الملف الشخصي',
        Permissions::MANAGE_SETTINGS => 'إدارة الإعدادات',
        Permissions::MANAGE_MAIN_COMPANY => 'إدارة الإعدادات العامة',
        Permissions::MANAGE_ALL_FOLDERS => 'إدارة جميع المجلدات المعينة لجميع المستخدمين',
        Permissions::MANAGE_INBOX => 'إدارة البريد الوارد',
        Permissions::MANAGE_UNREAD => 'إدارة غير المقروء',
        Permissions::MANAGE_INPROGRESS => 'إدارة قيد التقدم',
        Permissions::MANAGE_ARCHIVE => 'إدارة الأرشيف',
        Permissions::MANAGE_TRASH => 'إدارة المهملات',
    ]
];
