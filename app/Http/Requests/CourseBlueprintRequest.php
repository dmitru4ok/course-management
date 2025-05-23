<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseBlueprintRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        // if ($this->routeIs('course-blueprint.create')) {
        //     $base['course_code'] = 'required|string|size:6|unique:course_blueprints';
        // } else if ($this->routeIs('course-blueprint.update')) {
        //     $base['course_code'] = 'required|string|size:6|exists:course_blueprints,course_code';
        // } else {
        //     return [];
        // }
        return [
            'course_name' => 'required|string|max:100',
            'credit_weight' => 'required|integer|max:255|min:1',
            'is_valid' => 'required|boolean',
            'syllabus_pdf' => 'file|mimes:pdf|mimetypes:application/pdf,pdf|max:2048', // 2MB
            'faculty_code' => 'required|string|max:3|exists:faculties,faculty_code',
        ];
    }
}
