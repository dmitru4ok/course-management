<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

// test naming convention: test_{name of function/route args(or their absence)}_{anticipated result}
class RoleAuthTest extends TestCase
{
    use RefreshDatabase;
    const path = '/fake_route';

    public function test_NoAuthentinticationReuired_NoRolesAccess_Success() {
        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(200);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'OK']);

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(200);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'OK']);

        $response_role_Prof = $this->asUserRole('P')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);

        $response_role_Stud = $this->asUserRole('S')->getJson(self::path);
        $response_role_Stud->assertStatus(200);
        $response_role_Stud->assertJsonIsObject();
        $response_role_Stud->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationRequired_SuccessForAuthenticated() {
        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware('auth:api');

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(200);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'OK']);

        $response_role_Prof = $this->asUserRole('P')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);

        $response_role_Stud = $this->asUserRole('S')->getJson(self::path);
        $response_role_Stud->assertStatus(200);
        $response_role_Stud->assertJsonIsObject();
        $response_role_Stud->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRole_A_Required_FailForNotAuthenticated() {
        Route::middleware(['auth:api', 'role:A'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_AuthenticationAndRole_A_Required_SuccessForAuthenticated_A() {
        Route::middleware(['auth:api', 'role:A'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(200);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRole_A_Required_FailForAuthenticated_P() {

        Route::middleware(['auth:api', 'role:A'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_role_Admin = $this->asUserRole('P')->getJson(self::path);
        $response_role_Admin->assertStatus(403);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRole_A_Required_FailForAuthenticated_S() {
        Route::middleware(['auth:api', 'role:A'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_role_Admin = $this->asUserRole('S')->getJson(self::path);
        $response_role_Admin->assertStatus(403);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_P_Required_FailForUnauthenticated() {
        Route::middleware(['auth:api', 'role:P'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_AuthenticationAndRoles_P_Required_FailForAuthenticated_A() {
        Route::middleware(['auth:api', 'role:P'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(403);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_P_Required_SuccessForAuthenticated_P() {

        Route::middleware(['auth:api', 'role:P'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_role_Prof = $this->asUserRole('P')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRoles_A_Required_FailForAuthenticated_S() {

        Route::middleware(['auth:api', 'role:P'])->get(self::path, function() {
            return response(['message' => 'OK'], 200);
        });

        $response_role_Prof = $this->asUserRole('S')->getJson(self::path);
        $response_role_Prof->assertStatus(403);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_A_or_P_Required_FailForUnauthenticated() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|P']);

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_AuthenticationAndRoles_A_or_P_Required_SuccessForAuthenticated_A() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|P']);;

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(200);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRoles_A_or_P_Required_SuccessForAuthenticated_P() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|P']);;

        $response_role_Prof = $this->asUserRole('P')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRoles_A_or_P_Required_FailForAuthenticated_S() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|P']);;

        $response_role_Prof = $this->asUserRole('S')->getJson(self::path);
        $response_role_Prof->assertStatus(403);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_A_or_S_Required_FailForUnauthenticated() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|S']);

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_AuthenticationAndRoles_A_or_S_Required_SuccessForAuthenticated_A() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|S']);;

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(200);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRoles_A_or_S_Required_SuccessForAuthenticated_P() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|S']);;

        $response_role_Prof = $this->asUserRole('P')->getJson(self::path);
        $response_role_Prof->assertStatus(403);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_A_or_S_Required_FailForAuthenticated_S() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:A|S']);;

        $response_role_Prof = $this->asUserRole('S')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRoles_P_or_S_Required_FailForUnauthenticated() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:P|S']);

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_AuthenticationAndRoles_P_or_S_Required_SuccessForAuthenticated_A() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:P|S']);;

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(403);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_P_or_S_Required_SuccessForAuthenticated_P() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:P|S']);;

        $response_role_Prof = $this->asUserRole('P')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRoles_P_or_S_Required_FailForAuthenticated_S() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:P|S']);;

        $response_role_Prof = $this->asUserRole('S')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);
    }

    public function test_AuthenticationAndRoles_S_Required_FailForUnauthenticated() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:S']);

        $response_no_auth = $this->getJson(self::path);
        $response_no_auth->assertStatus(401);
        $response_no_auth->assertJsonIsObject();
        $response_no_auth->assertExactJson(['message' => 'Unauthenticated.']);
    }

    public function test_AuthenticationAndRoles_S_Required_FailForAuthenticated_A() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:S']);;

        $response_role_Admin = $this->asUserRole('A')->getJson(self::path);
        $response_role_Admin->assertStatus(403);
        $response_role_Admin->assertJsonIsObject();
        $response_role_Admin->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_S_Required_FailForAuthenticated_P() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:S']);;

        $response_role_Prof = $this->asUserRole('P')->getJson(self::path);
        $response_role_Prof->assertStatus(403);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'No privilege to access this resource']);
    }

    public function test_AuthenticationAndRoles_S_Required_SuccessForAuthenticated_S() {

        Route::get(self::path, function() {
            return response(['message' => 'OK'], 200);
        })->middleware(['auth:api', 'role:S']);;

        $response_role_Prof = $this->asUserRole('S')->getJson(self::path);
        $response_role_Prof->assertStatus(200);
        $response_role_Prof->assertJsonIsObject();
        $response_role_Prof->assertExactJson(['message' => 'OK']);
    }
}
