<?php

namespace Database\Factories;

use App\Models\Recruiter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOffer>
 */
class JobOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recruiter_id' => Recruiter::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'company_name' => null,
            'location' => fake()->city(),
            'contract_type' => fake()->randomElement(['CDI', 'CDD', 'Full-time', 'Stage', 'Freelance']),
            'image_path' => null,
            // 'image_path' => 'job-offers/o41DBg9TsHEgpaVNevq9Xl2BjNOeDRil4uV2cozD.jpg',
            'status' => 'open',
        ];
    }
}
