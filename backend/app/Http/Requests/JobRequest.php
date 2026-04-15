<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'min_salary' => [
                'required',
                'integer',
                'min:1',
            ],
            'max_salary' => [
                'required',
                'integer',
                'min:1',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'has_home_office' => [
                'required',
                'boolean',
            ],
            'type' => [
                'required',
                'string',
                Rule::in(['full-time', 'part-time', 'one-time']),
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:500',
            ]
        ];
    }
}
