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
}
