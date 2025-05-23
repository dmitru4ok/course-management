<?php

namespace App\Http\Controllers;

use App\Models\CourseBlueprint;
use Illuminate\Http\Request;
use App\Http\Requests\CourseBlueprintRequest;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Illuminate\Support\Facades\Storage;

class CourseBlueprintController extends Controller
{
    public function index()
    {
        return CourseBlueprint::all();
    }

    public function store(CourseBlueprintRequest $request)
    {   
        $validated = $request->validated();
        $validated['is_valid'] = boolval($validated['is_valid']);
        if ($request->hasFile('syllabus_pdf')) {
            $validated['syllabus_pdf'] = $request->file('syllabus_pdf')->store('course_offering_blobs');
        }
        return CourseBlueprint::create($validated);
    }

    public function blueprint_pdf(int $code) {
        $course_found = CourseBlueprint::find($code);
        if (!is_null($course_found)) {
            if (is_null($course_found->syllabus_pdf)) {
                return response()->json(['message' => 'No file associated with this course'], 404);
            }
            return Storage::download($course_found->syllabus_pdf);
        }
        return response()->json(['message' => 'No course found'], 404);
    }

    public function show(int $code)
    {
        $courseBlueprint = CourseBlueprint::find($code);

        if (is_null($courseBlueprint)) {
            return response()->json(['message' => 'Course blueprint not found'], 404);
        }

        return $courseBlueprint;
    }

    public function update(CourseBlueprintRequest $request, int $code)
    {
        $validated = $request->validated();
        
        $courseBlueprint = CourseBlueprint::find($code);
        if (is_null($courseBlueprint)) {
            return response()->json(['message' => 'Course blueprint not found'], 404);
        }

        $courseBlueprint->course_name = $validated['course_name'];
        $courseBlueprint->credit_weight = $validated['credit_weight'];
        $courseBlueprint->is_valid = $validated['is_valid'];
        $courseBlueprint->faculty_code = $validated['faculty_code'];
        $courseBlueprint->save();
        return response($courseBlueprint, 201);
    }

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
