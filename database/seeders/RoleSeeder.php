<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'super_admin',
        ]);

       $companyUser= Role::firstOrCreate([
            'name' => 'company_user',
        ]);
        $employee=Role::firstOrCreate([
            'name' => 'employee',
        ]);

         $companyUser->givePermissionTo([
            'task-create',
            'task-read',
            'task-update',
            'task-delete',
        ]);

        // Employee
        $employee->givePermissionTo([
            'task-read',
        ]);
    }
}