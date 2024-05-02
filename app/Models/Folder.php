<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName($this->getMorphClass());
    }
}
