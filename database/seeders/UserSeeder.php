<?php

namespace Database\Seeders;

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
                'role' => 'A',
                'name' => 'Jonas',
                'email' => env('ADMIN_ONE_EMAIL'),
                'surname' => 'Jonauskas',
                'password' => Hash::make(env('ADMIN_ONE_PASSWORD'))
            ]
        ]);
        \App\Models\User::factory()->count(20)->create();
    }
}
