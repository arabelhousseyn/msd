<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'avatar',
        'first_name',
        'last_name',
        'is_admin',
        'company_id',
        'email',
        'email_verified_at',
        'password',
        'position'
    ];

    protected static function booted()
    {
        static::deleting(function ($user){
            $user->createdDocuments()->update(['creator_id' => null]);
            $user->createdFolders()->update(['creator_id' => null]);
            $user->folders()->forceDelete();
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean'
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'company',
        'roles'
    ];


    public function scopeSearch($query, $value)
    {
        return $query->where(function($q) use ($value) {
            $q->where('first_name', 'like', "%$value%")
              ->orWhere('last_name', 'like', "%$value%")
              ->orWhere('email', 'like', "%$value%");
        });
    }


    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['first_name'] . ' ' . $this->attributes['last_name'],
        );
    }

    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->roles()->exists() ? $this->roles()->first()->name : null,
        );
    }

    protected function isExternal(): Attribute
    {
        $company = Company::where('is_external', false)->first();
        return Attribute::make(
            get: fn () => !($company->id === $this->attributes['company_id']),
        );
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class, 'user_id', 'id');
    }

    public function createdFolders(): HasMany
    {
        return $this->hasMany(Folder::class, 'creator_id', 'id');
    }

    public function createdDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'creator_id', 'id');
    }

    protected function getDefaultGuardName(): string { return 'web'; }
}
