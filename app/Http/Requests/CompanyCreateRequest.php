<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',

            // owner details
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8'

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name  is required',
            'name.unique' => 'The category name already been token',
            'name.max' => 'The category name must be less than 255 characters',
            'name.string' => 'The category name must be a string',
            'address.required' => 'The company address is required',
            'address.max' => 'The company address must be at less than 255 character',
            'address.string' => 'The company name must be a string',
            'industry.required' => 'The company industry is required',
            'industry.string' => 'The company industry must be a string',
            'industry.max' => 'The company industry must be at less than 255 character',
            'website.url' => 'The company website must be a valid URL',
            'website.max' => 'The company website must be at less than 255 character',
            'website.string' => 'The company website must be a string',

            // owner details
            'owner_name.required' => 'The owner name is required.',
            'owner_name.string' => 'The owner name must be a string.',
            'owner_name.max' => 'The owner name may not be greater than 255 characters.',
            'owner_email.required' => 'The owner email address is required.',
            'owner_email.email' => 'Please enter a valid email address.',
            'owner_email.unique' => 'This email address is already taken.',
            'owner_password.required' => 'The password is required.',
            'owner_password.string' => 'The password must be a string.',
            'owner_password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
