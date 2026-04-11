<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationRequest extends FormRequest
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
            'to_user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'title' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'message' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'type' => [
                'required',
                'string',
                Rule::in(['accept', 'reject', 'system', 'general'])
            ],
            'is_read' => [
                'boolean'
            ]
        ];
    }
}
