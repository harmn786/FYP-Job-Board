<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_id' => 1,
            'title' => fake()->jobTitle,
            'location' => fake()->city,
            'type' => fake()->randomElement(array('PartTime','Remote','Freelance','FullTime') ),
            'education' => fake()->text, // password
            'experience' => rand(2,5).'Years',
            'salary' => rand(20000,100000),
            'gender' => fake()->randomElement(array('Male','Female') ),
            'vacancy' => rand(1,5),
            'category' => fake()->randomElement(array('AI','WEB','Education','Game Development','Tech') ),
            'application_deadline' => '2024-03-30',
            'description' => fake()->text,
            'other_requirements' => fake()->text, // password
            'other_benifits' => fake()->text,
            'company_email' => fake()->companyEmail,
            'company_name' => fake()->company,
            'approved_by_admin' => false, // password
            'featured' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
