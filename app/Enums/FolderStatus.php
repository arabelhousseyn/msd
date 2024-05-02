<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DRAFT()
 * @method static static INPROGRESS()
 * @method static static TERMINATED()
 * @method static static REJECTED()
 */
final class FolderStatus extends Enum
{
    const DRAFT = 'draft';
    const INPROGRESS = 'inprogress';
    const TERMINATED = 'terminated';
    const REJECTED = 'rejected';
}
