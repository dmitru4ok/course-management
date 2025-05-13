<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(FacultySeeder::class);
        $this->call(StudyProgramSeeder::class);
        $this->call(StudyProgramInstanceSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SemesterSeeder::class);
        $this->call(CourseBlueprintSeeder::class);
        $this->call(SemesterCourseRequirementSeeder::class);
        
    }
}
