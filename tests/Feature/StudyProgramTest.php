<?php

namespace Tests\Feature;

use App\Models\StudyProgramInstance;
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

    public function test_getStudyPrograminstancesAsAdmin_noArgs_allStudyProgramInstances()
    {
        $response = $this->asUserRole('A')->getJson('/study_programs/instances');

        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertExactJsonStructure([
            '*' => [
                'program_code',
                'year_started',
                'is_active'
            ]
        ]);
    }

    public function test_getStudyProgramByCodeAsAdmin_OneStudyProgram()
    {
        $program_code = 'BX0012';
        $response = $this->asUserRole('S')->getJson('/study_programs/'. $program_code);
        $this->assertDatabaseHas('study_programs', [
            'program_code' => $program_code, 
            'program_type' => 'B', 
            'is_valid'=>true
        ]);

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertExactJsonStructure([
            'program_code',
            'program_name',
            'is_valid',
            'program_type',
            'faculty_code'
        ]);
    }
    
    public function test_getStudyProgramInstancesByCodeAsAdmin_OneStudyProgram()
    {
        $program_code = 'BX0012';
        $response = $this->asUserRole('A')->getJson('/study_programs/'. $program_code.'/instances');
        $this->assertDatabaseHas('study_programs', [
            'program_code' => $program_code, 
            'program_type' => 'B', 
            'is_valid'=>true
        ]);

        $response->assertStatus(200);

        $response->assertJsonIsArray();

        $response->assertExactJsonStructure([
            '*' => [
                'program_code',
                'year_started',
                'is_active'
            ]
        ]);
        $response->assertJsonCount(StudyProgramInstance::where('program_code', $program_code)->count());
    }
    
}
