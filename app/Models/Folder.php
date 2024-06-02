<?php

namespace App\Models;

use App\Enums\FolderStatus;
use App\Enums\ModelType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Folder extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'id',
        'title',
        'user_id',
        'company_id',
        'comment',
        'notify_before',
        'status',
        'end_at'
    ];

    protected $casts = [
        'status' => FolderStatus::class,
        'end_at' => 'datetime'
    ];

    protected $with = [
        'documents'
    ];

    protected static function booted(): void
    {
        static::updating(function ($model) {
            if(filled($model->user->company_id))
            {
                $model->company_id = $model->user->company_id;
            }
        });
    }

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

    public function loadDDocumentHistory()
    {
        $document_ids = $this->documents()->pluck('id')->toArray();

        return Activity::where('causer_id', auth()->id())
            ->where('subject_type', ModelType::Document)
            ->whereIn('subject_id', $document_ids)
            ->with('causer')
            ->orderByDesc('created_at')
            ->get();
    }
}
