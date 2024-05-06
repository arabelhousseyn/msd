<?php

namespace App\Models;

use App\Enums\Lang;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'code',
        'name',
        'color',
        'description',
        'email',
        'phone',
        'logo',
        'address',
        'lang',
        'smtp',
        'directions',
        'is_external'
    ];

    protected $casts = [
        'directions' => 'array',
        'smtp' => 'array',
        'is_external' => 'boolean',
        'lang' => Lang::class
    ];

    protected static function booted()
    {
        static::creating(function ($company) {
            $company->code = self::generateCode($company);
        });
    }

    /**
     * @return HasMany
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class, 'company_id', 'id');
    }

    public static function generateCode($company): string
    {
        $type = ($company->is_external) ? 'E' : 'I';
        $year = date('Y');
        $count = static::all()->count() + 1;

        return "{$type}-{$year}-{$count}";
    }
}
