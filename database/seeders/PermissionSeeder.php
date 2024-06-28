<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Enums\Permissions;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permissions::getValues();

        foreach ($permissions as $permission) {
            $permission_check = Permission::where('name', $permission)->first();
            if(blank($permission_check)) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
