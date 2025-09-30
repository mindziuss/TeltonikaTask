<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;

class CompanyEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyRole = Role::where('name', 'Company')->first();

        Company::factory(5)->create()->each(function ($company, $index) use ($companyRole) {
            $company->update([
                'email' => "company{$index}@example.com",
                'password' => Hash::make('password123'),
            ]);

            $company->roles()->attach($companyRole->id);

            Employee::factory(rand(3, 8))->createQuietly([
                'company_id' => $company->id,
            ]);
        });
    }
}
