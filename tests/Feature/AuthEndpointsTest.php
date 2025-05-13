<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

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
        $response = $this->asUserRole(UserType::Admin)->getJson('/me');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        assertEquals(auth('api')->user()->role, UserType::Admin);
        $this->assertDatabaseHas('users', ['user_id' => auth('api')->user()->user_id, 'role' => auth('api')->user()->role]);
    }

    public function test_whoamiUnathenticated_successProf() {
        $response = $this->asUserRole(UserType::Professor)->getJson('/me');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        assertEquals(auth('api')->user()->role, UserType::Professor);
        $this->assertDatabaseHas('users', ['user_id' => auth('api')->user()->user_id, 'role' => auth('api')->user()->role]);
    }

    public function test_whoamiUnathenticated_successStud() {
        $response = $this->asUserRole(UserType::Student)->getJson('/me');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        assertEquals(auth('api')->user()->role, UserType::Student);
        $this->assertDatabaseHas('users', ['user_id' => auth('api')->user()->user_id, 'role' => auth('api')->user()->role]);
    }

    public function test_registerUnathenticated_fail() {
        $response = $this->postJson('/register');

        $response->assertStatus(401);
        $response->assertJsonIsObject();
        $response->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_registerAuthenticatedAsStud_fail() {
        $response = $this->asUserRole(UserType::Student)->postJson('/register');

        $response->assertStatus(403);
        $response->assertJsonIsObject();
        $response->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_registerAuthenticatedAsProf_fail() {
        $response = $this->asUserRole(UserType::Professor)->postJson('/register');

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

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Student->value,
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
            'role' => UserType::Student->value,
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Student->value,
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

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Admin]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Admin->value,
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
            'role' => UserType::Admin->value
        ]);

        $response->assertJsonPath('program_code', null);
        $response->assertJsonPath('year_started', null);

        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Admin->value,
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

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Professor]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Professor->value,
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
            'role' => UserType::Professor->value
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

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => '',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Student->value,
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The name field is required.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_surnameEmpty_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => '',
            'email' => 'example@example.com',
            'role' => UserType::Student->value,
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The surname field is required.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_A_emailTaken_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => UserType::Admin]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => env('ADMIN_ONE_EMAIL'),
            'role' => UserType::Admin->value,
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The email has already been taken.');

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => UserType::Admin]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_emailBad_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);
        $badEmail = 'example@';
        $this->assertDatabaseMissing('users', ['email' => $badEmail, 'role' => UserType::Student]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => $badEmail,
            'role' => UserType::Student->value,
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla1234'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The email field must be a valid email address.');

        $this->assertDatabaseMissing('users', ['email' => $badEmail, 'role' => UserType::Student]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_roleBad_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
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

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_passwordTooShort_FailNameRequired() {
        $study_pr_year_to_insert_with = 2023;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseHas('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Student,
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The password field must be at least 8 characters.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
    }

    public function test_registerAuthenticatedAsAdmin_Create_S_nonExistingStudyProgram_FailNameRequired() {
        $study_pr_year_to_insert_with = 2025;
        $study_pr_code_to_insert_with = 'BX0012';
        $this->assertDatabaseMissing('study_program_instances', [
            'program_code' => $study_pr_code_to_insert_with,
            'year_started' => $study_pr_year_to_insert_with
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
        $response = $this->asUserRole(UserType::Admin)->postJson('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'example@example.com',
            'role' => UserType::Student,
            'year_started' => $study_pr_year_to_insert_with,
            'program_code' => $study_pr_code_to_insert_with,
            'password' => 'blabla123'
        ]);

        $response->assertStatus(422);
        $response->assertJsonIsObject();
        $response->assertJsonPath('message', 'The selected program code is invalid.');

        $this->assertDatabaseMissing('users', ['email' => 'example@example.com', 'role' => UserType::Student]);
    }

    public function test_loginUnauthenticated_Success() {

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => UserType::Admin]);
        $response = $this->postJson('/login', [
            'email' => env('ADMIN_ONE_EMAIL'),
            'password' => env('ADMIN_ONE_PASSWORD')
        ]);

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJson([
            'expires_in' => env('JWT_TTL') * 60,
            'user' => [
                'email' => env('ADMIN_ONE_EMAIL'),
                'role' => UserType::Admin->value
            ]
        ]);
        $response->assertJsonPath('user.year_started', null);
        $response->assertJsonPath('user.program_code', null);
    }

    public function test_loginWrongPassword_Fail() {

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => UserType::Admin]);
        $response = $this->postJson('/login', [
            'email' => env('ADMIN_ONE_EMAIL'),
            'password' => env('ADMIN_ONE_PASSWORD').'some_extra_chars' // wrong password
        ]);

        $response->assertStatus(401);
        $response->assertJsonIsObject();
        $response->assertExactJson([
            'error' => 'Invalid credentials',
        ]);
    }

    public function test_logoutUnauthenticated_Fail() {

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => UserType::Admin]);
        $response = $this->postJson('/logout');

        $response->assertStatus(401);
        $response->assertJsonIsObject();
        $response->assertJson([ 'message' => 'Unauthenticated.']);
    }

    public function test_logoutAuthenticated_Success() {

        $this->assertDatabaseHas('users', ['email' => env('ADMIN_ONE_EMAIL'), 'role' => UserType::Admin]);
        $user = User::query()->where('email', env('ADMIN_ONE_EMAIL'))->first();
        auth('api')->login($user);
        assertNotNull(auth('api')->user());

        $response = $this->postJson('/logout');

        $response->assertStatus(200);
        assertNull(auth('api')->user());
    }
}
