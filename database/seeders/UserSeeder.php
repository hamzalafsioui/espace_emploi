<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'name' => 'job_seeker user',
                'email' => 'job_seeker@gmail.com',
                'password' => Hash::make('job_seeker@gmail.com'),
                'user_type' => 'job_seeker',
            ],
            [
                'name' => 'recruiter User',
                'email' => 'recruiter@gmail.com',
                'password' => Hash::make('recruiter@gmail.com'),
                'user_type' => 'recruiter',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
