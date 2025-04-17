<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Models\Faculty;
use Illuminate\Http\Request;


class FacultyController extends Controller
{
    public function index()
    {
        return Faculty::all();
    }

    public function store(FacultyRequest $request)
    {
        $faculty = Faculty::create($request->validated());
        return response()->json([
            "faculty_code" => $faculty->faculty_code
        ], 201);
    }

    public function show(string $code)
    {   
        $searched = Faculty::find($code);
        if (is_null($searched)) {
            return response()->json([
                "message" => "Faculty with code $code not found"
            ], 404);
        }

        return response()->json($searched, 200);
    }

    public function update(Request $request, string $code)
    {
        $searched = Faculty::find($code);
        if (is_null($searched)) {
            return response()->json([
                "message" => "Faculty with code $code not found."
            ], 404);
        }

        $request->validate(["faculty_name" => "required|string|max:100"]);
        $searched->faculty_name = $request->faculty_name;
        $searched->save();
        return response()->json($searched, 201);
    }
}
