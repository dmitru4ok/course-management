<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\CourseOffering;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeachesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professors = User::where('role', UserType::Professor)->get();
        $offerings = CourseOffering::all();
        foreach ($professors as $professor) {
            $assigned = $offerings->random(rand(2, 4))->pluck('offering_id')->toArray();
            $professor->coursesTaught()->attach($assigned);
        }
    }
}
