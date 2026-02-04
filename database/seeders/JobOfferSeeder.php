<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 recruiters => each with 2-4 job offers
        User::factory(5)->create(['user_type' => 'recruiter'])->each(function ($user) {
            $recruiter = Recruiter::factory()->create(['user_id' => $user->id]);

            JobOffer::factory(rand(2, 4))->create([
                'recruiter_id' => $recruiter->id,
                'company_name' => $recruiter->company_name
            ]);
        });
    }
}
