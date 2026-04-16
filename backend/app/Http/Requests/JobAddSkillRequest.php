<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobAddSkillRequest extends FormRequest
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
            'job_id' => [
                'required',
                'integer',
                'exists:jobs,id',
            ],
            'skill_id' => [
                'required',
                'integer',
                'exists:skills,id',
                'unique:job_skill,skill_id'
            ]
        ];
    }
}
