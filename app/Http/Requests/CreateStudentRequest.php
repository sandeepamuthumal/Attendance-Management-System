<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15',
            'parent_contact_no' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email',
            'nic' => 'required|string|max:12|unique:students,nic',
            'address' => 'required|string',
            'class_ids' => 'array',
            'class_ids.*' => 'exists:classes,id'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'contact_no.required' => 'Contact number is required',
            'parent_contact_no.required' => 'Parent contact number is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'nic.required' => 'NIC is required',
            'nic.unique' => 'NIC already exists',
            'address.required' => 'Address is required',
            'class_ids.*.exists' => 'Selected class is invalid'
        ];
    }
}
