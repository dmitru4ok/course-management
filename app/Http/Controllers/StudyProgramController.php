<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyProgramRequest;
use App\Models\Semester;
use App\Models\SemesterCourseRequirement;
use App\Models\StudyProgramInstance;
use App\Models\StudyProgram;
use DateTime;
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
        if (!is_null($data['perform_deep_copy']) && $data['perform_deep_copy']) {
            $copy_code = $data['copy_program_code'];
            $copy_year = $data['copy_program_year'];
            $old_semesters = StudyProgramInstance::where('program_code', $copy_code)
                ->where('year_started', $copy_year)->first()->semesters;
                $new_semesters = [];
                $new_compulsories = [];
                $yr_diff = $data['year_started'] - $copy_year;
                foreach ($old_semesters as $old_semester) {
                    $new_sem = [
                        'program_code' => $data['program_code'],
                        'year_started' => $data['year_started'],
                        'sem_no' => $old_semester->sem_no,
                        'is_valid' => $old_semester->is_valid,
                        'date_from' => new DateTime($old_semester->date_from)->modify("+$yr_diff year")->format('Y-m-d'),
                        'date_to' =>  new DateTime($old_semester->date_to)->modify("+$yr_diff year")->format('Y-m-d'),
                    ];
                    $new_semesters[] = $new_sem;

                    $sem_comp_courses = SemesterCourseRequirement::where([
                        ['program_code', '=', $old_semester->program_code],
                        ['year_started', '=', $old_semester->year_started],
                        ['sem_no', '=', $old_semester->sem_no]
                    ])->get('course_code')->map(function(SemesterCourseRequirement $course_code_to_duplicate) use ($new_sem) {
                        return [
                            'program_code' => $new_sem['program_code'],
                            'year_started' => $new_sem['year_started'],
                            'sem_no' => $new_sem['sem_no'],
                            'course_code' => $course_code_to_duplicate->course_code
                        ];
                    });
                    array_push($new_compulsories, ...$sem_comp_courses);
                }
                Semester::insert($new_semesters);
                SemesterCourseRequirement::insert($new_compulsories);
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
