<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(app()->environment() !== 'production') {
            Company::factory(10)->create();
            User::factory(10)->create();
        }

        $this->call([PermissionSeeder::class, AdminSeeder::class]);
    }
}
