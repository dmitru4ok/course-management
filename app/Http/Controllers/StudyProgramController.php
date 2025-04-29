<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyProgramRequest;
use App\Models\StudyProgramInstance;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public function index()
    {
        return StudyProgram::all();
    }

    public function index_instances()
    {
        return StudyProgramInstance::all();
    }

    public function show_instances_by_year(int $year)
    {
        return StudyProgramInstance::where('year_started', $year)->get();
    }

    public function show_study_program_by_id(string $code)
    {
        return StudyProgram::where('program_code', $code)->firstOrFail();
    }

    public function show_by_code_instances(string $code)
    {
        return StudyProgramInstance::where('program_code', $code)->get();
    }

    public function show_specific(string $code, int $year)
    {
        return StudyProgramInstance::where('year_started', $year)->where("program_code", $code)->firstOrFail();
    }

    public function create_study_program(StudyProgramRequest $request)
    {
        $data = $request->validated();
        return StudyProgram::create($data);
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
