<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudyProgramTest extends TestCase
{
    use RefreshDatabase;
    // test naming convention: test_{name of function/route args(or their absence)}_{anticipated result}
    public function test_getStudyProgramsAsAdmin_noArgs_allStudyPrograms()
    {
        $response = $this->asUserRole('A')->getJson('/study_programs');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertExactJsonStructure([
            '*' => [
                'program_code',
                'program_name',
                'faculty_code',
                'program_type',
                'is_valid'
            ]
        ]);
    }

    public function test_getStudyProgramsAsProf_noArgs_allStudyPrograms()
    {
        $response = $this->asUserRole('P')->getJson('/study_programs');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertExactJsonStructure([
            '*' => [
                'program_code',
                'program_name',
                'faculty_code',
                'program_type',
                'is_valid'
            ]
        ]);
    }

    public function test_getStudyProgramsAsStudnoArgs_allStudyPrograms()
    {
        $response = $this->asUserRole('S')->getJson('/study_programs');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertExactJsonStructure([
            '*' => [
                'program_code',
                'program_name',
                'faculty_code',
                'program_type',
                'is_valid'
            ]
        ]);
    }
}
