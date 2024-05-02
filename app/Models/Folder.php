<?php

namespace App\Models;

use App\Enums\FolderStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Folder extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = [
        'id',
        'title',
        'user_id',
        'company_id',
        'comment',
        'status',
        'end_at'
    ];

    protected $casts = [
        'status' => FolderStatus::class
    ];

    /**
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'folder_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
