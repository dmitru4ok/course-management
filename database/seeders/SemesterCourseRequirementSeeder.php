<?php

namespace Database\Seeders;

use App\Models\CourseBlueprint;
use App\Models\Semester;
use App\Models\SemesterCourseRequirement;
use Illuminate\Database\Seeder;

class SemesterCourseRequirementSeeder extends Seeder
{
    public function run(): void
    {
        $sems = Semester::all();

        foreach ($sems as $semester) {
            $courseBlueprints = CourseBlueprint::pluck('course_code');
            $compulsoryCourseNum = rand(3,5);
            for ($i = 1; $i <= $compulsoryCourseNum; $i++) { // n Compulsory courses for each semester
                $allWithCurrentSem = SemesterCourseRequirement::all()
                    ->where('sem_no', $semester->sem_no)
                    ->where('program_code', $semester->program_code)
                    ->where('year_started', $semester->year_started)
                    ->map(fn($el) => $el->course_code);
                    
                SemesterCourseRequirement::create([
                    'sem_no' => $semester->sem_no,
                    'program_code' => $semester->program_code,
                    'year_started' => $semester->year_started,
                    'course_code' => fake()->randomElement($courseBlueprints->diff($allWithCurrentSem))
                ]);
            }
        }
    }
}
