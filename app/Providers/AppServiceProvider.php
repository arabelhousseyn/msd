<?php

namespace App\Providers;

use App\Enums\ModelType;
use App\Models\Company;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use function Symfony\Component\Translation\t;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            ModelType::Company => Company::class,
            ModelType::Document => Document::class,
            ModelType::Folder => Folder::class,
            ModelType::User => User::class,
        ]);
    }
}
