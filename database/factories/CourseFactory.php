<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(
                [
                    'CS 101', 'Operating Systems',
                    'Calculus I', 'Calculus II',
                    'Calculus III', 'Discrete Mathematics', 'Algebra', 'DBMS', 'Etical Hacking'
                ]
            )
        ];
    }
}
