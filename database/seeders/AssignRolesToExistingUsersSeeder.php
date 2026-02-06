<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AssignRolesToExistingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->user_type === 'recruiter') {
                $user->assignRole('recruiter');
            } elseif ($user->user_type === 'job_seeker') {
                $user->assignRole('job_seeker');
            }
        }
    }
}
