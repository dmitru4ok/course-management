<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\StudyProgramInstance;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        return Semester::all();
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $program, int $year)
    {
        return Semester::where('program_code', $program)
            ->where('year_started', $year)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
