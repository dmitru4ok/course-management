<?php

namespace Database\Factories;

use App\Enums\Building;
use App\Models\CourseBlueprint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseOffering>
 */
class CourseOfferingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'classroom' => fake()->numberBetween(100, 500),
            'building' => fake()->randomElement( array_column(Building::cases(), 'value')),
            'course_code' => CourseBlueprint::inRandomOrder()->value('course_code')
        ];
    }
}
