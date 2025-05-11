<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class FacultyTest extends TestCase
{
    use RefreshDatabase;
    // test naming convention: test_{name of function/route args(or their absence)}_{anticipated result}

    // retrieving faculties
    public function test_getFacultiesAsAdmin_noArgs_allFaculties(): void
    {
        $response = $this->asUserRole('A')->getJson('/faculties'); // Act

        $response->assertStatus(200); // Assert
        $response->assertJsonIsArray();
        $response->assertExactJsonStructure([
            '*' => [
                'faculty_code',
                'faculty_name'
            ]
        ]);
    }

    public function test_getFacultiesAsProf_noArgs_noPrivilege(): void
    {
        $response = $this->asUserRole('P')->getJson('/faculties'); // Act

        $response->assertStatus(200); // Assert
        $response->assertJsonIsArray();
        $response->assertExactJsonStructure([
            '*' => [
                'faculty_code',
                'faculty_name'
            ]
        ]);
    }

    public function test_getFacultiesAsStudent_noArgs_noPrivilege(): void
    {
        $response = $this->asUserRole('S')->getJson('/faculties'); // Act

        $response->assertStatus(403); // Assert
        $response->assertJsonIsObject();
        $response->assertExactJson([
            'message' => 'No privilege to access this resource'
        ]);
    }

    public function test_getFacultiesAsAdmin_routeWithID_oneFaculty(): void
    {
        $facultyCode='FIZ';
        
        $response = $this->asUserRole('A')->getJson('/faculties/'.$facultyCode); // Act

        $response->assertStatus(200); // Assert
        $response->assertJsonIsObject();
        $response->assertExactJsonStructure([
            'faculty_code',
            'faculty_name'
        ]);
        $response->assertExactJson([
            'faculty_code' => 'FIZ',
            'faculty_name' => 'Faculty of Physics'
        ]);
    }

    public function test_getFacultiesAsProf_routeWithID_oneFaculty(): void
    {
        $facultyCode='FIZ';
        
        $response = $this->asUserRole('P')->getJson('/faculties/'.$facultyCode); // Act

        $response->assertStatus(200); // Assert
        $response->assertJsonIsObject();
        $response->assertExactJsonStructure([
            'faculty_code',
            'faculty_name'
        ]);
        $response->assertExactJson([
            'faculty_code' => 'FIZ',
            'faculty_name' => 'Faculty of Physics'
        ]);
    }

    public function test_getFacultiesAsStudent_routeWithID_oneFaculty(): void
    {
        $facultyCode='FIZ';
        
        $response = $this->asUserRole('S')->getJson('/faculties/'.$facultyCode); // Act

        $response->assertStatus(200); // Assert
        $response->assertJsonIsObject();
        $response->assertExactJsonStructure([
            'faculty_code',
            'faculty_name'
        ]);
        $response->assertExactJson([
            'faculty_code' => 'FIZ',
            'faculty_name' => 'Faculty of Physics'
        ]);
    }

    public function test_postFacultiesAsAdmin_newValid_validPost(): void
    {
        $code_to_add = 'VBS';
        $name_to_add = 'VU Busines School';
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                'faculty_code' => $code_to_add,
                'faculty_name' => $name_to_add
            ]
        );

        $response->assertStatus(201);
        $response->assertJsonIsObject();
        $response->assertExactJson(["faculty_code" => $code_to_add]);
        $this->assertDatabaseHas('faculties', [
            'faculty_code' => $code_to_add,
            'faculty_name' => $name_to_add
        ]);
    }

    public function test_postFacultiesAsProf_newValid_noPrivilege(): void
    {
        $code_to_add = 'VBS';
        $name_to_add = 'VU Busines School';
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                'faculty_code' => $code_to_add,
                'faculty_name' => $name_to_add
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_newValid_noPrivilege(): void
    {
        $code_to_add = 'VBS';
        $name_to_add = 'VU Busines School';
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                'faculty_code' => $code_to_add,
                'faculty_name' => $name_to_add
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsAdmin_invalidTooShortCode_error422Caught(): void
    {
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                "faculty_code" => "VF",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(422);
        $response->assertExactJsonStructure([
            'message',
            'errors' => [
                'faculty_code'
            ]
        ]);
    }

    public function test_postFacultiesAsProf_invalidTooLongCode_noPrivilege(): void
    {
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                "faculty_code" => "VFF1",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_invalidTooLongCode_noPrivilege(): void
    {
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                "faculty_code" => "VFF1",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsAdmin_invalidEmptyCode_error422Caught(): void
    {
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                "faculty_code" => "",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(422);
        $response->assertExactJsonStructure([
            'message',
            'errors' => [
                'faculty_code'
            ]
        ]);
        $response->assertJsonPath("message", "The faculty code field is required.");
    }

    public function test_postFacultiesAsProf_invalidEmptyCode_error422Caught(): void
    {
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                "faculty_code" => "",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_invalidEmptyCode_error422Caught(): void
    {
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                "faculty_code" => "",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsAdmin_invalidTakenCode_error422Caught(): void
    {
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                "faculty_code" => "MIF",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'faculty_code' => []
            ]
        ]);
        $response->assertJsonPath("message", "The faculty code has already been taken.");
    }

    public function test_postFacultiesAsProf_invalidTakenCode_error422Caught(): void
    {
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                "faculty_code" => "MIF",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_invalidTakenCode_error422Caught(): void
    {
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                "faculty_code" => "MIF",
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsAdmin_codeIsANumber_error422Caught(): void
    {
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                "faculty_code" => 333,
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'faculty_code' => []
            ]
        ]);
        $response->assertJsonPath("message", "The faculty code field must be a string.");
    }

    public function test_postFacultiesAsProf_codeIsANumber_error422Caught(): void
    {
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                "faculty_code" => 333,
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_codeIsANumber_error422Caught(): void
    {
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                "faculty_code" => 333,
                "faculty_name" => "imaginary faculty"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsAdmin_nameEmpty_error422Caught(): void
    {
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => ""
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'faculty_name' => []
            ]
        ]);
        $response->assertJsonPath("message", "The faculty name field is required.");
    }

    public function test_postFacultiesAsProf_nameEmpty_error422Caught(): void
    {
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => ""
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_nameEmpty_error422Caught(): void
    {
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => ""
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsAdmin_nameIsANumber_error422Caught(): void
    {
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => 333
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'faculty_name' => []
            ]
        ]);
        $response->assertJsonPath("message", "The faculty name field must be a string.");
    }

    public function test_postFacultiesAsProf_nameIsANumber_error422Caught(): void
    {
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => 333
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_nameIsANumber_error422Caught(): void
    {
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => 333
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsAdmin_nameIsTooLong_error422Caught(): void
    {
        $too_long_faculty_name = "Faculty of Mathematics and Computer ScienceFaculty of Mathematics and Computer ScienceFaculty of Math";
        $this->assertTrue(strlen($too_long_faculty_name) === 101);
        $response = $this->asUserRole('A')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => $too_long_faculty_name
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The faculty name field must not be greater than 100 characters.');
    }

    public function test_postFacultiesAsProf_nameIsTooLong_error422Caught(): void
    {
        $too_long_faculty_name = "Faculty of Mathematics and Computer ScienceFaculty of Mathematics and Computer ScienceFaculty of Math";
        $this->assertTrue(strlen($too_long_faculty_name) === 101);
        $response = $this->asUserRole('P')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => $too_long_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_postFacultiesAsStudent_nameIsTooLong_error422Caught(): void
    {
        $too_long_faculty_name = "Faculty of Mathematics and Computer ScienceFaculty of Mathematics and Computer ScienceFaculty of Math";
        $this->assertTrue(strlen($too_long_faculty_name) === 101);
        $response = $this->asUserRole('S')->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => $too_long_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    
    
    public function test_patchFacultiesAsAdmin_NonExistingFacultyCode_error404Caught(): void
    {
        $faculty_code_to_modify_non_existing = 'FIF';
        $response = $this->asUserRole('A')->patchJson('/faculties/'.$faculty_code_to_modify_non_existing,
            [
                "faculty_name" => "New faculty name"
            ]
        );

        $response->assertStatus(404);
        $response->assertExactJson([
            'message' => "Faculty with code $faculty_code_to_modify_non_existing not found.",
        ]);
    }

    public function test_patchFacultiesAsProf_NonExistingFacultyCode_error404Caught(): void
    {
        $faculty_code_to_modify_non_existing = 'FIF';
        $response = $this->asUserRole('P')->patchJson('/faculties/'.$faculty_code_to_modify_non_existing,
            [
                "faculty_name" => "New faculty name"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_patchFacultiesAsStudent_NonExistingFacultyCode_error404Caught(): void
    {
        $faculty_code_to_modify_non_existing = 'FIF';
        $response = $this->asUserRole('S')->patchJson('/faculties/'.$faculty_code_to_modify_non_existing,
            [
                "faculty_name" => "New faculty name"
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_patchFacultiesAsAdmin_emptyFacultyCode_error405Caught(): void
    {
        $faculty_code_to_modify_non_existing = '';
        $response = $this->asUserRole('A')->patchJson('/faculties/'.$faculty_code_to_modify_non_existing,
            [
                "faculty_name" => "New faculty name"
            ]
        );

        $response->assertStatus(405); //method not allowed
    }

    public function test_patchFacultiesAsProf_emptyFacultyCode_error405Caught(): void
    {
        $faculty_code_to_modify_non_existing = '';
        $response = $this->asUserRole('P')->patchJson('/faculties/'.$faculty_code_to_modify_non_existing,
            [
                "faculty_name" => "New faculty name"
            ]
        );

        $response->assertStatus(405);
    }

    public function test_patchFacultiesAsStudent_emptyFacultyCode_error405Caught(): void
    {
        $faculty_code_to_modify_non_existing = '';
        $response = $this->asUserRole('S')->patchJson('/faculties/'.$faculty_code_to_modify_non_existing,
            [
                "faculty_name" => "New faculty name"
            ]
        );

        $response->assertStatus(405);
    }

    public function test_patchFacultiesAsAdmin_EmptyStringName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $new_faculty_name = "";
        $response = $this->asUserRole('A')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $new_faculty_name
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'faculty_name' => []
            ]
        ]);
        $response->assertJsonPath("message", "The faculty name field is required.");
    }

    public function test_patchFacultiesAsProf_EmptyStringName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $new_faculty_name = "";
        $response = $this->asUserRole('P')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $new_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_patchFacultiesAsStudent_EmptyStringName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $new_faculty_name = "";
        $response = $this->asUserRole('S')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $new_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_patchFacultiesAsAdmin_NonStringName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $new_faculty_name = 41414;
        $response = $this->asUserRole('A')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $new_faculty_name
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'faculty_name' => []
            ]
        ]);
        $response->assertJsonPath("message", "The faculty name field must be a string.");
    }

    public function test_patchFacultiesAsProf_NonStringName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $new_faculty_name = 41414;
        $response = $this->asUserRole('P')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $new_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_patchFacultiesAsStudent_NonStringName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $new_faculty_name = 41414;
        $response = $this->asUserRole('S')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $new_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_patchFacultiesAsAdmin_TooLongName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $too_long_new_faculty_name = "Faculty of Mathematics and Computer ScienceFaculty of Mathematics and Computer ScienceFaculty of Math";
        $this->assertTrue(strlen($too_long_new_faculty_name) === 101);
        $response = $this->asUserRole('A')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $too_long_new_faculty_name
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'faculty_name' => []
            ]
        ]);
        $response->assertJsonPath("message", "The faculty name field must not be greater than 100 characters.");
    }

    public function test_patchFacultiesAsProf_TooLongName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $too_long_new_faculty_name = "Faculty of Mathematics and Computer ScienceFaculty of Mathematics and Computer ScienceFaculty of Math";
        $this->assertTrue(strlen($too_long_new_faculty_name) === 101);
        $response = $this->asUserRole('P')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $too_long_new_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }

    public function test_patchFacultiesAsStudent_TooLongName_error422Caught(): void
    {
        $faculty_code_to_modify = 'FIZ';
        $too_long_new_faculty_name = "Faculty of Mathematics and Computer ScienceFaculty of Mathematics and Computer ScienceFaculty of Math";
        $this->assertTrue(strlen($too_long_new_faculty_name) === 101);
        $response = $this->asUserRole('S')->patchJson('/faculties/'.$faculty_code_to_modify,
            [
                "faculty_name" => $too_long_new_faculty_name
            ]
        );

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(["message" => 'No privilege to access this resource']);
    }
}
