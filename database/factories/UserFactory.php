<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudyProgramInstance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $role = fake()->randomElement(['S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'P','A']); // for increasing student probability
        $data = [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'role' => $role,
            'password' => static::$password ??= Hash::make('password'),
            
        ];

        if ($role === 'S') {
            $instance = StudyProgramInstance::inRandomOrder()->first();
            $data['year_started'] = $instance->year_started;
            $data['program_code'] = $instance->program_code;
        }

        return $data;
    }
}
