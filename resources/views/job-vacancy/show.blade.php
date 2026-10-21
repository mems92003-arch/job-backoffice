<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $jobVacancy->title }}
            </h2>
        </div>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toust-notification />

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('job-vacancies.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800  px-4 py-2 rounded-md">← Back</a>
        </div>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md border border-gray-100 mt-4">
            <!-- Company Details -->

            <div class="space-y-4 text-gray-700">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-3">Job Vacancy Information</h3>
                <p><strong>Company:</strong>{{ $jobVacancy->company->name }}</p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Location</span>
                    {{ $jobVacancy->location ?: 'Not provided' }}
                </p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Type</span>
                    {{ $jobVacancy->type ?: 'Not provided' }}
                </p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Salary</span>
                    {{ number_format($jobVacancy->salary, 2) ?: 'Not provided' }}
                </p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Description</span>
                    {{ $jobVacancy->description }}
                </p>
            </div>

            <!-- Tabs Navigation (مع إضافة مسافة فصل واضحة وحواشي أنيقة) -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <ul class="flex space-x-3 border-b border-gray-200 pb-2">
                    <li>
                        <a href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'jobs']) }}"
                            class="inline-block px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-800 border border-transparent hover:border-gray-300 rounded-t-lg transition-all {{ request('tab') == 'jobs' || request('tab') == '' ? 'bg-blue-500 text-white' : ''}}">
                            Jobs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}"
                            class="inline-block px-5 py-2.5 text-sm font-medium  text-gray-500 hover:text-gray-800 border border-transparent hover:border-gray-300 rounded-t-lg transition-all {{ request('tab') == 'applications' || request('tab') == '' ? 'bg-blue-500 text-white' : '' }}">
                            Applications
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div>

                <!-- Jobs Tab -->
                <div id="jobs" class="{{request('tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden'}}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-100 rounded-tl-lg">Job Title</th>
                                <th class="py-2 px-4 bg-gray-100">Type</th>
                                <th class="py-2 px-4 bg-gray-100">Location</th>
                                <th class="py-2 px-4 bg-gray-100 rounded-tl-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobVacancy->jobApplications as $job)
                                <tr>
                                    <td class="py-2 px-4 text-center">{{ $job->title }}</td>
                                    <td class="py-2 px-4 text-center">{{ $job->type }}</td>
                                    <td class="py-2 px-4 text-center">{{ $job->location }}</td>
                                    <td class="py-2 px-4 text-center">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}"
                                            class="text-blue-500 hover:text-blue-700 underline">View</a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Applications Tab -->
                <div id="applications" class="{{request('tab') == 'applications' ? 'block' : 'hidden'}}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Applicant Name</th>
                                <th class="py-2 px-4 text-left bg-gray-100">Job Title</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Status</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobVacancy->jobApplications as $aplication)
                                <tr>
                                    <td class="py-2 px-4">{{ $aplication->user->name }}</td>
                                    <td class="py-2 px-4">{{ $aplication->jobVacancy->title }}</td>
                                    <td class="py-2 px-4">{{ $aplication->status }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('job-applications.show', $aplication->id) }}"
                                            class="text-blue-500 hover:text-blue-700 underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons (نُقلت لأسفل الصفحة وشكلها بقى شيك ومتنسق) -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end items-center space-x-3">
                <a href="{{ route('job-vacancies.edit', ["job_vacancy" => $jobVacancy->id, 'redirectToList' => 'false']) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-blue-600 text-blue-600 rounded-md font-medium text-sm hover:bg-blue-600 hover:text-white transition duration-150 shadow-sm">
                    Edit
                </a>

                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="post" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to archive this company?')"
                        class="inline-flex items-center px-4 py-2 bg-white border border-red-500 text-red-500 rounded-md font-medium text-sm hover:bg-red-500 hover:text-white transition duration-150 shadow-sm">
                        Archive
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>