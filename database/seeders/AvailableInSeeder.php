<?php

namespace Database\Seeders;

use App\Models\AvailableIn;
use App\Models\CourseOffering;
use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailableInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offerings = CourseOffering::with('courseBlueprint')->get();
        $semesters = Semester::with('studyProgram')->get()->sortBy('sem_no')->values();

        $semesters->each(function ($sem) use ($offerings) {
            $offerings->each(function ($offering) use ($sem) {
                if (fake()->boolean() && $offering->courseBlueprint->faculty->faculty_code === $sem->studyProgram->faculty->faculty_code) {
                    AvailableIn::create([
                        'sem_no' => $sem->sem_no,
                        'year_started' => $sem->year_started,
                        'program_code' => $sem->program_code,
                        'offering_id' => $offering->offering_id
                    ]);
                }
            }); 
        });

        // dd(Semester::with('studyProgram')->first()->studyProgram->faculty);
        // dd(CourseOffering::with('courseBlueprint')->first()->courseBlueprint->faculty);
    }
}
