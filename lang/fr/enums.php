<?php

use App\Enums\Permissions;

return [
    Permissions::class => [
        Permissions::MANAGE_DASHBOARD => 'Gérer les statistiques',
        Permissions::MANAGE_USERS => 'Gérer les utilisateurs',
        Permissions::MANAGE_COMPANIES => 'Gérer les départements',
        Permissions::MANAGE_FOLDERS => 'Gérer les dossiers',
        Permissions::MANAGE_PROFILE => 'Gérer le profil',
        Permissions::MANAGE_SETTINGS => 'Gérer les paramètres',
        Permissions::MANAGE_MAIN_COMPANY => 'Gérer les paramètres généraux',
        Permissions::MANAGE_ALL_FOLDERS => 'Gérer tous les dossiers assignés à tous les utilisateurs',
        Permissions::MANAGE_INBOX => 'Gérer la boîte de réception',
        Permissions::MANAGE_UNREAD => 'Gérer les non lus',
        Permissions::MANAGE_INPROGRESS => 'Gérer en cours',
        Permissions::MANAGE_ARCHIVE => 'Gérer l\'archive',
        Permissions::MANAGE_TRASH => 'Gérer la corbeille',
    ]
];
