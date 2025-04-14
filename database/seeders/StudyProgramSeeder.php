<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('study_program_instances')->insert([
            [
                'year_started' => 2023,
                'program_code' => 'BX0012',
                'program_name' => 'Information Technology',
                'program_type' => 'B',
                'faculty_code' => 'MIF'
            ],
            [
                'year_started' => 2024,
                'program_code' => 'BX0012',
                'program_name' => 'Information Technology',
                'program_type' => 'B',
                'faculty_code' => 'MIF'
            ],
            [
                'year_started' => 2023,
                'program_code' => 'MDCX02',
                'program_name' => 'Medicine',
                'program_type' => 'M',
                'faculty_code' => 'MDC'
            ],
            [
                'year_started' => 2024,
                'program_code' => 'MDCX07',
                'program_name' => 'Dentistry',
                'program_type' => 'M',
                'faculty_code' => 'MDC'
            ],
        ]);
    }
}
