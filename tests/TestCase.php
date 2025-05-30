<?php

namespace Tests;

use App\Models\User;
use App\Enums\UserType;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    protected $seed = true;

    public function asUserRole(UserType $role) {
        $user = User::factory()->create(['role' => $role]);
        $token = JWTAuth::fromUser($user);
        return $this->withHeader('Authorization', 'Bearer '.$token);
    }
}
