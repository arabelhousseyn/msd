<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Company()
 * @method static static Document()
 * @method static static Folder()
 * @method static static User()
 */
final class ModelType extends Enum
{
    const Company = 'company';
    const Document = 'document';
    const Folder = 'folder';
    const User = 'user';
}
