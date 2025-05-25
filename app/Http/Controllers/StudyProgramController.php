<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyProgramRequest;
use App\Models\StudyProgramInstance;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public static string $notFoundMessage = 'Not found';
    public function index()
    {
        return StudyProgram::all();
    }

    public function index_with_instances()
    {
        return StudyProgram::with('instances')->get();
    }

    public function index_instances()
    {
        return StudyProgramInstance::all();
    }

    public function show_instances_by_year(int $year)
    {
        $result = StudyProgramInstance::where('year_started', $year)->get();
        if ( count($result) !== 0) {
            return $result;
        }
        return response(['message'=> self::$notFoundMessage ], 404);
    }

    public function show_study_program_by_id(string $code)
    {
        if ($result = StudyProgram::where('program_code', $code)->first()) {
            return $result;
        }
       
        return response(['message'=> self::$notFoundMessage ], 404);
    }

    public function show_by_code_instances(string $code)
    {
        $result = StudyProgramInstance::where('program_code', $code)->get();
        if (count($result) !== 0) {
            return $result;
        }
        return response(['message'=> self::$notFoundMessage ], 404);
    }

    public function show_specific(string $code, int $year)
    {
        if ($result = StudyProgramInstance::where('year_started', $year)->where("program_code", $code)->first()) {
            return $result;
        }
        return response(['message'=> self::$notFoundMessage ], 404);
    }

    public function create_study_program(StudyProgramRequest $request)
    {
        $data = $request->validated();
        return StudyProgram::create($data);
    }

    public function create_study_program_instance(StudyProgramRequest $request) {
        $data = $request->validated();
        $new_instance = StudyProgramInstance::create($data);
        if ($data['perform_deep_copy']) {
            // TODO
            // get semesters
            // for each semester get compulsory courses
            // instert semesters and their courses for the new instance

            // use Model::insert() for bulk insert
        }
       
        return $new_instance;
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
