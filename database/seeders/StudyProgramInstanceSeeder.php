<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class StudyProgramInstanceSeeder extends Seeder
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
                'is_active' => true
            ],
            [
                'year_started' => 2024,
                'program_code' => 'BX0012',
                'is_active' => true
            ],
            [
                'year_started' => 2023,
                'program_code' => 'MDCX02',
                'is_active' => true
            ],
            [
                'year_started' => 2024,
                'program_code' => 'MDCX07',
                'is_active' => true
            ]
        ]);
    }
}
