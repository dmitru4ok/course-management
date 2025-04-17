<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacultyTest extends TestCase
{
    use RefreshDatabase;
    // test naming convention: test_{name of function/route args(or their absence)}_{anticipated result}

    // retrieving faculties
    public function test_getFaculties_noArgs_allFaculties(): void
    {
        $response = $this->get('/faculties'); // Act

        $response->assertStatus(200); // Assert
        $response->assertJsonIsArray();
        $response->assertJsonStructure([
            '*' => [
                'faculty_code',
                'faculty_name'
            ]
        ]);
    }

    public function test_getFaculties_routeWithID_oneFaculty(): void
    {
        $facultyCode='FIZ';
        
        $response = $this->get('/faculties/'.$facultyCode); // Act

        $response->assertStatus(200); // Assert
        $response->assertJsonIsObject();
        $response->assertJsonStructure([
            'faculty_code',
            'faculty_name'
        ]);
        $response->assertExactJson([
            'faculty_code' => 'FIZ',
            'faculty_name' => 'Faculty of Physics'
        ]);
    }

    public function test_postFaculties_newValid_validPost(): void
    {
        $code_to_add = 'VBS';
        $name_to_add = 'VU Busines School';
        $response = $this->postJson('/faculties',
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

    public function test_postFaculties_invalidTooShortCode_error422Caught(): void
    {
        $response = $this->postJson('/faculties',
            [
                "faculty_code" => "VF",
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
    }

    public function test_postFaculties_invalidTooLongCode_error422Caught(): void
    {
        $response = $this->postJson('/faculties',
            [
                "faculty_code" => "VFF1",
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

        $response->assertJsonPath("message", "The faculty code field must be 3 characters.");
    }

    public function test_postFaculties_invalidEmptyCode_error422Caught(): void
    {
        $response = $this->postJson('/faculties',
            [
                "faculty_code" => "",
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
        $response->assertJsonPath("message", "The faculty code field is required.");
    }

    public function test_postFaculties_invalidTakenCode_error422Caught(): void
    {
        $response = $this->postJson('/faculties',
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

    public function test_postFaculties_codeIsANumber_error422Caught(): void
    {
        $response = $this->postJson('/faculties',
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

    public function test_postFaculties_nameEmpty_error422Caught(): void
    {
        $response = $this->postJson('/faculties',
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

    public function test_postFaculties_nameIsANumber_error422Caught(): void
    {
        $response = $this->postJson('/faculties',
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

    public function test_postFaculties_nameIsTooLong_error422Caught(): void
    {
        $too_long_faculty_name = "Faculty of Mathematics and Computer ScienceFaculty of Mathematics and Computer ScienceFaculty of Math";
        $this->assertTrue(strlen($too_long_faculty_name) === 101);
        $response = $this->postJson('/faculties',
            [
                "faculty_code" => "FIR",
                "faculty_name" => $too_long_faculty_name
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
}
