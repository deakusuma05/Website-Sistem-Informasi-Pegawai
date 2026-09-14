<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'education' => ['required', 'in:SMA/SMK,D3,S1,S2,S3'],
            'age' => ['required', 'integer', 'min:18', 'max:100'],
            'work_duration' => ['required', 'integer', 'min:0'],
            'phone' => ['required', 'string', 'min:10', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    /**
     * Custom validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The employee name is required.',
            'name.string' => 'The employee name must be a valid string.',
            'name.max' => 'The employee name may not exceed 255 characters.',
            'gender.required' => 'The gender field is required.',
            'gender.in' => 'The selected gender must be either Laki-laki or Perempuan.',
            'education.required' => 'The education level is required.',
            'education.in' => 'The selected education must be one of: SMA/SMK, D3, S1, S2, S3.',
            'age.required' => 'The age is required.',
            'age.integer' => 'The age must be an integer.',
            'age.min' => 'The employee age must be at least 18 years old.',
            'age.max' => 'The employee age may not exceed 100 years old.',
            'work_duration.required' => 'The work duration is required.',
            'work_duration.integer' => 'The work duration must be an integer.',
            'work_duration.min' => 'The work duration must be at least 0.',
            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a valid string.',
            'phone.min' => 'The phone number must be at least 10 characters.',
            'phone.max' => 'The phone number may not exceed 20 characters.',
            'phone.regex' => 'The phone number format is invalid.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address may not exceed 255 characters.',
        ];
    }
}
