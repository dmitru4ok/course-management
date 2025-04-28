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
        DB::table('study_programs')->insert([
            [
                'program_code' => 'BX0012',
                'program_name' => 'Information Technology',
                'program_type' => 'B',
                'faculty_code' => 'MIF'
            ],
            [
                'program_code' => 'SGM016',
                'program_name' => 'Cybersecurity',
                'program_type' => 'M',
                'faculty_code' => 'MIF'
            ],
            [
                'program_code' => 'MDCX02',
                'program_name' => 'Medicine',
                'program_type' => 'M',
                'faculty_code' => 'MDC'
            ],
            [
                'program_code' => 'MDCX07',
                'program_name' => 'Dentistry',
                'program_type' => 'M',
                'faculty_code' => 'MDC'
            ],
        ]); 
    }
}
