<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacultyTest extends TestCase
{
    use RefreshDatabase;
    // test naming convention: test_{name of function/route args(or their absence)}_{anticipated result}

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

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
}
