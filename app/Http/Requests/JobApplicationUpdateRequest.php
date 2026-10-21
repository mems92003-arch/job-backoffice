<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'bail|required|string|in:Pending,Accepted,Rejected',
        ];
    }

    public function messages(): array
    {
        return [
            // Status
            'status.required' => 'The applicant status is required.',
            'status.string' => 'The applicant status must be either pending, accepted or rejected',
        ];
    }
}
