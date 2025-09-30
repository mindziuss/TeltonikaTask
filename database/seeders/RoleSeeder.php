<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    private static $roles = ['Admin', 'Company'];

    public function run(): void
    {
        foreach (self::$roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
