<?php

namespace Database\Seeders;

use App\Enums\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role' => UserType::Admin,
                'name' => 'Jonas',
                'email' => env('ADMIN_ONE_EMAIL'),
                'surname' => 'Jonauskas',
                'password' => Hash::make(env('ADMIN_ONE_PASSWORD'))
            ]
        ]);
        \App\Models\User::factory()->count(40)->create();
    }
}
