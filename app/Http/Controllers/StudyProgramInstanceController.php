<?php

namespace App\Http\Controllers;

use App\Models\StudyProgramInstance;
use Illuminate\Http\Request;

class StudyProgramInstanceController extends Controller
{
    public function index()
    {
        return StudyProgramInstance::all();
    }

    public function store(Request $request)
    {
        //
    }

    public function show_by_code(string $code)
    {
        return StudyProgramInstance::where('program_code', $code)->get();
    }

    public function show_by_year(int $year)
    {
        return StudyProgramInstance::where('year_started', $year)->get();
    }

    public function update(Request $request, string $code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
