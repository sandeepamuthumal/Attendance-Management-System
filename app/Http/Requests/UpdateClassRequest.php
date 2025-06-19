<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRequest extends FormRequest
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
            'class_id' => 'required|exists:classes,id',
            'class_name' => 'required|string|max:255',
            'subjects_id' => 'required|exists:subjects,id',
            'teachers_id' => 'required|exists:teachers,id',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 5),
            'grades_id' => 'required|exists:grades,id',
            'status' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'class_id.required' => 'Class ID is required',
            'class_id.exists' => 'Class not found',
            'class_name.required' => 'Class name is required',
            'class_name.max' => 'Class name must not exceed 255 characters',
            'subjects_id.required' => 'Subject is required',
            'subjects_id.exists' => 'Selected subject is invalid',
            'teachers_id.required' => 'Teacher is required',
            'teachers_id.exists' => 'Selected teacher is invalid',
            'year.required' => 'Year is required',
            'year.integer' => 'Year must be a valid number',
            'year.min' => 'Year must be at least 2020',
            'year.max' => 'Year cannot be more than ' . (date('Y') + 5),
            'grades_id.required' => 'Grade is required',
            'grades_id.exists' => 'Selected grade is invalid'
        ];
    }
}
