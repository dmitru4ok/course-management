<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

// test naming convention: test_{name of function/route args(or their absence)}_{anticipated result}
class AuthEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_whoamiUnathenticated_fail() {
        $response = $this->getJson('/me');

        $response->assertStatus(401);
        $response->assertJsonIsObject();
        $response->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_whoamiUnathenticated_successAdmin() {
        $response = $this->asUserRole('A')->getJson('/me');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        assertEquals(auth('api')->user()->role, 'A');
        $this->assertDatabaseHas('users', ['user_id' => auth('api')->user()->user_id, 'role' => auth('api')->user()->role]);
    }

    public function test_whoamiUnathenticated_successProf() {
        $response = $this->asUserRole('P')->getJson('/me');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        assertEquals(auth('api')->user()->role, 'P');
        $this->assertDatabaseHas('users', ['user_id' => auth('api')->user()->user_id, 'role' => auth('api')->user()->role]);
    }

    public function test_whoamiUnathenticated_successStud() {
        $response = $this->asUserRole('S')->getJson('/me');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        assertEquals(auth('api')->user()->role, 'S');
        $this->assertDatabaseHas('users', ['user_id' => auth('api')->user()->user_id, 'role' => auth('api')->user()->role]);
    }

    public function test_registerUnathenticated_fail() {
        $response = $this->postJson('/register');

        $response->assertStatus(401);
        $response->assertJsonIsObject();
        $response->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_registerAuthenticatedAsStud_fail() {
        $response = $this->asUserRole('S')->postJson('/register');

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_registerAuthenticatedAsProf_fail() {
        $response = $this->asUserRole('P')->postJson('/register');

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_RigthParams_success() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'S',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(201);
        $response->assertJsonIsObject();
        $response->assertJson([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'S',
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => "S",
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_A_RigthParams_success() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'A']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'A',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(201);
        $response->assertJsonIsObject();
        $response->assertJson([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'A'
        ]);

        $response->assertJsonPath('program_code', null);
        $response->assertJsonPath('year_started', null);

        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => "A",
            'program_code' => null,
            'year_started' => null
        ]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_P_RigthParams_success() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'P']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'P',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(201);
        $response->assertJsonIsObject();
        $response->assertJson([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'P'
        ]);

        $response->assertJsonPath('program_code', null);
        $response->assertJsonPath('year_started', null);

        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => "P",
            'program_code' => null,
            'year_started' => null
        ]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_nameEmpty_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => '',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'S',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The name field is required.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_surnameEmpty_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => '',
            'email' => 'example@example.com',
            'role' => 'S',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The surname field is required.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
    }

    public function test_registerAuthenticatedAsAdmin_Create_A_emailTaken_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => 'A']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => env('ADMIN_ONE_EMAIL'),
            'role' => 'A',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The email has already been taken.');

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => 'A']);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_emailBad_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);
        $badEmail = 'example@';
        $this->assertDatabaseMissing('users', ['email' => $badEmail, 'role' => 'S']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => $badEmail,
            'role' => 'S',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The email field must be a valid email address.');

        $this->assertDatabaseMissing('users', ['email' => $badEmail, 'role' => 'S']);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_roleBad_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'Q',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The selected role is invalid.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_passwordTooShort_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'S',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The password field must be at least 8 characters.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_nonExistingStudyProgram_FailNameRequired() {
        $study_pr_year_to_insert_with = 2025;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseMissing('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
        $response = $this->asUserRole('A')->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => 'S',
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla123'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The selected program code is invalid.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => 'S']);
    }
}
