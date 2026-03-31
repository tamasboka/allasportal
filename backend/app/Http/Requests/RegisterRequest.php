<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => [
                'required',
                'string',
                'min:2',
                'max:25'
            ],
            'lastname' => [
                'required',
                'string',
                'min:2',
                'max:25'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:25'
            ],
            'gender' => [
                'string',
                'in:male,female'
            ],
            'birthdate' => [
                'date',
            ],
            'phone' => [
                'string',
                'min:8',
                'max:15'
            ],
            'work_experience' => [
                'numeric',
                'min:0',
            ],
            'bio' => [
                'string',
                'min:1',
                'max:1000'
            ]
        ];
    }
}
