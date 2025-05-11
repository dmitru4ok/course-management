<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|size:1|in:S,P,A',
            'email' => 'required|email|unique:users,email|max:255',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'password' => 'required|string|min:8',
        ]);
    
        $validator->sometimes('year_started', [
            'integer',
            'digits:4',
            'max:' . now()->year
        ], fn ($input) => $input->role === 'S');
    
        $validator->sometimes('program_code', [
            'string',
            'size:6',
            Rule::exists('study_program_instances', 'program_code')->where(function ($query) use ($request) {
                $query->where('year_started', $request->year_started);
            })
        ], fn($input) => $input->role === 'S');

        return response(User::create($validator->validate()), 201);
    }

    public function whoami() {
        return auth('api')->user();
    }

    public function refresh() {
        $old_invalid_token = (string)auth('api')->getToken();
        $newtoken = auth('api')->refresh();

        return response()->json([
            'access_token' => $newtoken,
            'old_invalid_token' => $old_invalid_token,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }

    public function logout() 
    {
        return auth('api')->logout();
    }
}
