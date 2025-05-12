<?php

namespace Tests\Feature;

use App\Models\StudyProgram;
use App\Models\StudyProgramInstance;
use App\Http\Controllers\StudyProgramController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudyProgramTest extends TestCase
{
    use RefreshDatabase;
    // test naming convention: test_{name of function/route args(or their absence)}_{anticipated result}
    public function test_getStudyPrograms_noArgs_allStudyPrograms()
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

    public function test_getStudyPrograminstances_noArgs_allStudyProgramInstances()
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

    public function test_getStudyProgramByCode_OneStudyProgram()
    {
        $program_code = 'BX0012';
        $response = $this->asUserRole('A')->getJson('/study_programs/'. $program_code);
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
    
    public function test_getStudyProgramInstancesByCode_OneStudyProgram()
    {
        $program_code = 'BX0012';
        $response = $this->asUserRole('A')->getJson('/study_programs/'. $program_code.'/instances');
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $program_code, 
            'is_active'=>true
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

    public function test_getStudyProgramInstancesByYear_OneStudyProgram()
    {
        $year = 2024;
        $response = $this->asUserRole('A')->getJson('/study_programs/instances/'.$year);
        $this->assertDatabaseHas('study_program_instances', [
            'year_started' => $year, 
            'program_code' => 'BX0012',
            'is_active' => true
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
        $response->assertJsonCount(StudyProgramInstance::where('year_started', $year)->count());
    }

    public function test_getStudyProgramInstance_OneStudyProgram()
    {
        $year = 2024;
        $program_code = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'year_started' => $year, 
            'program_code' => $program_code,
            'is_active' => true
        ]);

        $response = $this->asUserRole('A')->getJson("/study_programs/$program_code/instances/$year");

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertExactJson([
            'program_code' => $program_code,
            'year_started' => $year,
            'is_active' => true
        ]);
    }

    // -------------------------------
    public function test_getStudyProgramByCode_NonExistingCode_NotFound()
    {
        $program_code = 'BX0011';
        $this->assertDatabaseMissing('study_programs', ['program_code'=>$program_code]);
        $response = $this->asUserRole('A')->getJson('/study_programs/'. $program_code);

        $response->assertStatus(404);
        $response->assertJsonIsObject();

        $response->assertExactJson([
           'message' => StudyProgramController::$notFoundMessage
        ]);
    }
    
    public function test_getStudyProgramInstancesByCode_NonExisting_NotFound()
    {
        $program_code = 'BX0011';
        $this->assertDatabaseMissing('study_program_instances', ['program_code'=>$program_code]);
        $response = $this->asUserRole('A')->getJson('/study_programs/'. $program_code.'/instances');

        $response->assertStatus(404);

        $response->assertJsonIsObject();

        $response->assertExactJson([
           'message' => StudyProgramController::$notFoundMessage
        ]);
    }

    public function test_getStudyProgramInstancesByYear_NonExistingYear_OneStudyProgram()
    {
        $year = 2027;
        $this->assertDatabaseMissing('study_program_instances', ['year_started'=>$year]);
        $response = $this->asUserRole('A')->getJson('/study_programs/instances/'.$year);

        $response->assertStatus(404);

        $response->assertJsonIsObject();

        $response->assertExactJson([
            'message' => StudyProgramController::$notFoundMessage
        ]);
    }

    public function test_getStudyProgramInstance_NonExistingInstance_OneStudyProgram()
    {
        $year = 2027;
        $program_code = 'BX0012';
        $this->assertDatabaseMissing('study_program_instances', ['year_started'=>$year, 'program_code'=>$program_code]);

        $response = $this->asUserRole('A')->getJson("/study_programs/$program_code/instances/$year");

        $response->assertStatus(404);
        $response->assertJsonIsObject();
        $response->assertExactJson([
            'message' => StudyProgramController::$notFoundMessage
        ]);
    }
}
