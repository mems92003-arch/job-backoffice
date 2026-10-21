<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Vacancy')  }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form action="{{ route('job-vacancies.update',['job_vacancy' => $jobVacancy->id, 'redirectToList' => request()->query('redirectToList')  ]) }}" method="POST" >
                @csrf
                @method('PUT')

                <!-- Company Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold">Job Vacancy Details</h3>
                    <p class="text-sm mb-4">Enter the job vacancy details below</p>
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title',$jobVacancy->title) }}"
                            class="{{ $errors->has('title') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title')
                            <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location',$jobVacancy->location) }}"
                            class="{{ $errors->has('location') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('location')
                            <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-sm font-medium text-gray-700">Expected Salary(USD)</label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary',$jobVacancy->salary) }}"
                            class="{{ $errors->has('website') ? 'outline-red-500 outline outline-1' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('salary')
                            <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Full-Time" {{ old('type',$jobVacancy->type) == 'Full-Time' ? 'selested' : '' }}>Full-Time
                            </option>
                            <option value="Part-Time" {{ old('type',$jobVacancy->type) == 'Part-Time' ? 'selested' : '' }}>Part-Time
                            </option>
                            <option value="Hypred" {{ old('type',$jobVacancy->type) == 'Hypred' ? 'selested' : '' }}>Hypred</option>
                        </select>


                    </div>
                </div>

                <!-- Company Select Dropdown -->
                <div class="mb-4">
                    <label for="companyId" class="block text-sm font-medium text-gray-700">Company</label>
                    <select name="companyId" id="companyId"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="" disabled {{ old('companyId') ? '' : 'selected' }}>Select a company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('companyId') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Company Error Handling -->
                    @error('companyId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Category Select Dropdown -->
                <div class="mb-4">
                    <label for="jobCategoryId" class="block text-sm font-medium text-gray-700">Job Category</label>
                    <select name="jobCategoryId" id="jobCategoryId"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="" disabled {{ old('jobCategoryId',$jobVacancy->jobCategoryId) ? '' : 'selected' }}>Select a category
                        </option>
                        @foreach ($jobCategories as $category)
                            <option value="{{ $category->id }}" {{ old('jobCategoryId') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Job Category Error Handling -->
                    @error('jobCategoryId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Description Textarea -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Job Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description',$jobVacancy->descreption) }}</textarea>
                    <!-- Job Description Error Handling -->
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end space-x-4">
                    <!-- Cancel Button (خليته رصاصي عشان يبقى مميز عن الإضافة) -->
                    <a href="{{ route('job-vacancies.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 no-underline">
                        Cancel
                    </a>

                    <!-- Add Company Button -->
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Job Vacancy
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>