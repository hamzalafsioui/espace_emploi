<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create job offers']);
        Permission::create(['name' => 'apply for jobs']);

        // Create roles and assign created permissions
        $recruiter = Role::create(['name' => 'recruiter']);
        $recruiter->givePermissionTo('create job offers');

        $jobSeeker = Role::create(['name' => 'job_seeker']);
        $jobSeeker->givePermissionTo('apply for jobs');
    }
}
