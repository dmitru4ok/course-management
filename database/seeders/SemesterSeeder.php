<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('semesters')->insert([
            [
                'year_started' => 2023,
                'program_code' => 'BX0012',
                'sem_no' => 1,
                'is_valid' => false,
                'date_from' => '2023-09-01',
                'date_to' => '2024-01-31'
            ],
            [
                'year_started' => 2023,
                'program_code' => 'BX0012',
                'sem_no' => 2,
                'is_valid' => false,
                'date_from' => '2024-02-09',
                'date_to' => '2024-06-15'
            ],
            [
                'year_started' => 2023,
                'program_code' => 'BX0012',
                'sem_no' => 3,
                'is_valid' => true,
                'date_from' => '2024-09-01',
                'date_to' => '2025-01-28'
            ],
            [
                'year_started' => 2023,
                'program_code' => 'BX0012',
                'sem_no' => 4,
                'is_valid' => false,
                'date_from' => '2025-02-05',
                'date_to' => '2025-06-19'
            ],
            [
                'year_started' => 2023,
                'program_code' => 'BX0012',
                'sem_no' => 5,
                'is_valid' => false,
                'date_from' => '2025-09-02',
                'date_to' => '2026-01-28'
            ],
            [
                'year_started' => 2023,
                'program_code' => 'BX0012',
                'sem_no' => 6,
                'is_valid' => false,
                'date_from' => '2026-02-05',
                'date_to' => '2026-06-18'
            ]
        ]);
    }
}
