<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!$token=auth('api')->attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'role' => 'required|string|size:1|in:S,P,A',
            'email' => 'required|email|unique:users,email|max:255',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'password' => 'required|string|min:8'
        ]);

        return response(User::create($validated), 201);
    }

    public function whoami(Request $request) {
        return $request->user();
    }
}
