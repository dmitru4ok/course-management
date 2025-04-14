<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faculties')->insert([
            [
                'faculty_code' => 'MIF',
                'faculty_name' => 'Faculty of Mathematics and Informatics'
            ],
            [
                'faculty_code' => 'MDC',
                'faculty_name' => 'Faculty of Medicine'
            ],
            [
                'faculty_code' => 'FIZ',
                'faculty_name' => 'Faculty of Physics'
            ],
            [
                'faculty_code' => 'PHL',
                'faculty_name' => 'Faculty of Philology'
            ]
        ]);
    }
}
