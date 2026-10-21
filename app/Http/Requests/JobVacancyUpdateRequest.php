<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
            'title' => 'bail|required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'type' => 'required|string|in:Full-Time,Part-Time,Hypred',
            'description' => 'required|string|max:255',
            'jobCategoryId' => 'nullable|string|min:8|max:255',
            'companyId' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            // Title
            'title.required' => 'The job title is required.',
            'title.string' => 'The job title must be a string.',
            'title.max' => 'The job title may not be greater than 255 characters.',

            // Location
            'location.required' => 'The location is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than 255 characters.',

            // Salary
            'salary.required' => 'The salary is required.',
            'salary.string' => 'The salary must be a string.',
            'salary.max' => 'The salary may not be greater than 255 characters.',

            // Type
            'type.required' => 'The job type is required.',
            'type.string' => 'The job type must be a valid text.',
            'type.in' => 'The selected job type must be one of: Full-Time, Part-Time, Hypred.',


            // Description
            'description.required' => 'The job description is required.',
            'description.string' => 'The job description must be a string.',
            'description.max' => 'The job description may not be greater than 255 characters.',

            // Job Category
            'jobCategoryId.string' => 'The job category must be a string.',
            'jobCategoryId.min' => 'The job category must be at least 8 characters.',
            'jobCategoryId.max' => 'The job category may not be greater than 255 characters.',

            // Company
            'companyId.required' => 'The company name is required.',
            'companyId.string' => 'The company name must be a string.',
            'companyId.max' => 'The company name may not be greater than 255 characters.',
        ];
    }
}
