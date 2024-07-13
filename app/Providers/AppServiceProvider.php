<?php

namespace App\Providers;

use App\Enums\ModelType;
use App\Models\Company;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Dedoc\Scramble\Scramble;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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

        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });
    }
}
