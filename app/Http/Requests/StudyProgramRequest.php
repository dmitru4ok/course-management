<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        // dd($this->program_code);
        if ($this->routeIs('study_program.create')) {
            return [
                'program_code' => 'required|string|size:6|unique:study_programs,program_code',
                'program_name' => 'required|string|max:100',
                'program_type' => 'required|string|size:1|in:B,M,D',
                'faculty_code' => 'required|string|size:3|exists:faculties,faculty_code',
                'is_valid' => 'boolean',
            ];
        } else if ($this->routeIs('study_program.instantiate')) {
            // dd($this->program_code);
            return [
                'program_code' => 'required|string|size:6|exists:study_programs,program_code',
                'year_started' => [
                    'required',
                    Rule::unique('study_program_instances', 'year_started')->where('program_code', $this->program_code),
                ],
                'perform_deep_copy' => 'required|boolean',
                'copy_program_code' => [
                    'required_if:perform_deep_copy,true',
                    'string',
                    'size:6'
                ],
                'copy_program_year' => [
                    'required_if:perform_deep_copy,true',
                    'integer',
                    'digits:4',
                    'max:'.now()->year,
                    Rule::exists('study_program_instances', 'year_started')->where('program_code', $this->copy_program_code)
                ]
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
           'copy_program_year.exists' => 'Copy error: the copy_program_code was not instantiated in year_started.'
        ];
    }
}
