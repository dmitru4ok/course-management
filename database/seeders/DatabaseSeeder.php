<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
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
        $this->call(CourseOfferingSeeder::class);
        $this->call(TeachesSeeder::class);
        $this->call(AvailableInSeeder::class);
        $this->call(CourseRegistrationSeeder::class);
        
        // $res = User::where('role', UserType::Professor)->with('coursesTaught')->get()->map( fn($user) => $user->coursesTaught->toArray());
        // dd($res);
    }
}
