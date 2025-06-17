<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
        $rules = [
            'user_types_id' => 'required|exists:user_types,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];

        // Add teacher-specific validation
        if ($this->user_types_id == 2) {
            $rules['subjects_id'] = 'required|exists:subjects,id';
            $rules['contact_no'] = 'required|string|max:15';
            $rules['address'] = 'required|string';
            $rules['nic'] = 'required|string|max:12|unique:teachers,nic';
        }

        return $rules;
    }

     public function messages()
    {
        return [
            'user_types_id.required' => 'User type is required',
            'user_types_id.exists' => 'Selected user type is invalid',
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'subjects_id.required' => 'Subject is required for teachers',
            'contact_no.required' => 'Contact number is required for teachers',
            'address.required' => 'Address is required for teachers',
            'nic.required' => 'NIC is required for teachers',
            'nic.unique' => 'NIC already exists',
        ];
    }
}
