<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static En()
 * @method static static Ar()
 * @method static static Fr()
 */
final class Lang extends Enum
{
    const En = 'en';
    const Ar = 'ar';
    const Fr = 'fr';
}
