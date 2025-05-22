<?php

namespace App\Http\Controllers;

use App\Models\CourseBlueprint;
use Illuminate\Http\Request;

class CourseBlueprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CourseBlueprint::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $code)
    {
        $courseBlueprint = CourseBlueprint::find($code);

        if (is_null($courseBlueprint)) {
            return response()->json(['message' => 'Course blueprint not found'], 404);
        }

        return $courseBlueprint;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseBlueprint $courseBlueprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseBlueprint $courseBlueprint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function invalidate(int $code)
    {
        $courseBlueprint = CourseBlueprint::find($code);
        if (is_null($courseBlueprint)) {
            return response()->json(['message' => 'Course blueprint not found'], 404);
        }
        $courseBlueprint->is_valid = false;
        $courseBlueprint->save();
        return response($courseBlueprint, 201);
    }
}
