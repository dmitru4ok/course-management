<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Models\Faculty;


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

    public function update(FacultyRequest $request, string $code)
    {
        $searched = Faculty::find($code);
        $searched->update($request->validated());
        return response()->json([
            "message" => "Faculty with code $code updated"
        ], 200);
    } // TODO: validation fails here when editing existing object
}
