<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CompanyEmployeeSeeder::class,
        ]);

        $adminRole = Role::where('name', 'Admin')->first();

        $user = User::factory()->createQuietly([
            'name' => 'Admin User',
            'email' => 'test@example.com',
        ]);

        $user->roles()->attach($adminRole->id);
    }
}
