<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyProgramRequest extends FormRequest
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
        return [
            'program_code' => 'required|string|max:255|unique:study_programs,program_code',
            'program_name' => 'required|string|max:255',
            'program_type' => 'required|string|size:1|in:B,M,D',
            'faculty_code' => 'required|string|size:3|exists:faculties,faculty_code',
            'is_valid' => 'required|boolean',
        ];
    }
}
