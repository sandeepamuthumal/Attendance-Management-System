<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
    public function rules()
    {
        $studentId = $this->route('id') ?? $this->student_id;

        return [
            'student_id' => 'required|exists:students,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15',
            'parent_contact_no' => 'required|string|max:15',
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($studentId),
            ],
            'nic' => [
                'required',
                'string',
                'max:12',
                Rule::unique('students')->ignore($studentId),
            ],
            'address' => 'required|string',
            'class_ids' => 'array',
            'class_ids.*' => 'exists:classes,id'
        ];
    }
}
