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
        $validated = $request->validate();
        $faculty = new Faculty();
        $faculty->faculty_code = $validated["faculty_code"];
        $faculty->faculty_name = $validated["faculty_name"];
        $faculty->save();
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

    /**
     * Update the specified resource in storage.
     */
    public function update(FacultyRequest $request, string $id)
    {
        //
    }
}
