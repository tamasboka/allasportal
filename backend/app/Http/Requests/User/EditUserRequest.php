<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
                'string',
                'min:2',
                'max:25'
            ],
            'lastname' => [
                'string',
                'min:2',
                'max:25'
            ],
            'email' => [
                'email',
                'unique:users,email'
            ],
            'password' => [
                'string',
                'min:8',
                'max:255',
            ],
            'phone' => [
                'string',
                'min:8',
                'max:15',
                'unique:users,phone',
            ],
            'bio' => [
                'string',
                'min:1',
                'max:1000'
            ]
        ];
    }
}
