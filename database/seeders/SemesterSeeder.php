<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\StudyProgramInstance;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        StudyProgramInstance::all()->each(function ($instance) {
            $total = 7;
            $startYear = $instance->year_started;

            for ($i = 1; $i <= $total; $i++) {
                $startDate = Carbon::create($startYear, 9, 1)->addMonths(6 * ($i - 1));
                $endDate = (clone $startDate)->addMonths(6)->subDay();

                Semester::create([
                    'program_code' => $instance->program_code,
                    'year_started' => $startYear,
                    'sem_no' => $i,
                    'is_valid' => true,
                    'date_from' => $startDate->toDateString(),
                    'date_to' => $endDate->toDateString(),
                ]);
            }
        });
    } 
}
