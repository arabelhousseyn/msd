<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'id',
        'title',
        'code',
        'folder_id',
        'format',
        'size',
        'url'
    ];

    protected static function booted(): void
    {
        static::creating(function ($company) {
            $company->code = self::generateCode($company);
        });
    }

    protected function size(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value . " byte",
        );
    }

    /**
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id', 'id');
    }

    public static function generateCode($company): string
    {
        $year = date('Y');
        $count = static::all()->count() + 1;

        return "{$year}-{$count}";
    }

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName($this->getMorphClass());
    }
}
