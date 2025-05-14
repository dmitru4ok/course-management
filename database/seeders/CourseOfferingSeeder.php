<?php

namespace Database\Seeders;

use App\Models\CourseBlueprint;
use App\Models\CourseOffering;
use Illuminate\Database\Seeder;

class CourseOfferingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseOffering::factory()->count(100)->create();
    }
}
