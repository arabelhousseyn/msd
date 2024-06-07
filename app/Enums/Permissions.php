<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static MANAGE_DASHBOARD()
 * @method static static MANAGE_PROFILE()
 * @method static static MANAGE_COMPANIES()
 * @method static static MANAGE_USERS()
 * @method static static MANAGE_FOLDERS()
 * @method static static MANAGE_SETTINGS()
 * @method static static MANAGE_MAIN_COMPANY()
 * @method static static MANAGE_ALL_FOLDERS()
 */
class Permissions extends Enum implements LocalizedEnum
{
    const MANAGE_DASHBOARD = 'manage_dashboard';
    const MANAGE_PROFILE = 'manage_profile';
    const MANAGE_COMPANIES = 'manage_companies';
    const MANAGE_USERS = 'manage_users';
    const MANAGE_FOLDERS = 'manage_folders';
    const MANAGE_SETTINGS = 'manage_settings';
    const MANAGE_MAIN_COMPANY = 'manage_main_company';
    const MANAGE_ALL_FOLDERS = 'manage_all_folders';
}
