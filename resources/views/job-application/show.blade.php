<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $jobApplication->user->name }} Applied to {{ $jobApplication->jobVacancy->title }}
            </h2>
        </div>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toust-notification />

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('job-applications.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800  px-4 py-2 rounded-md">← Back</a>
        </div>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md border border-gray-100 mt-4">
            <!-- Company Details -->

            <div class="space-y-4 text-gray-700">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-3">Application Details</h3>
                <p><strong>Applicant:</strong>{{ $jobApplication->uesr?->name ?? 'Not Available' }}</p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Job Vacancy</span>
                    {{ $jobApplication->jobVacancy->title}}
                </p>
                <p><strong>Company</strong>{{ $jobApplication->jobVacancy->company->name }}</p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Status</span>
                    {{ $jobApplication->status }}
                </p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Resume</span>

                    <a class="text-blue-600 hover:text-blue-800 underline" href="{{ $jobApplication->resume->fileUrl }}"
                        target="_blank">
                        {{ $jobApplication->resume->fileUrl }}
                    </a>
                </p>
            </div>

            <!-- Tabs Navigation (مع إضافة مسافة فصل واضحة وحواشي أنيقة) -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <ul class="flex space-x-3 border-b border-gray-200 pb-2">
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}"
                            class="inline-block px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-800 border border-transparent hover:border-gray-300 rounded-t-lg transition-all {{ request('tab') == 'resume' || request('tab') == '' ? 'bg-blue-500 text-white' : ''}}">
                            Resume
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'AIFeedback']) }}"
                            class="inline-block px-5 py-2.5 text-sm font-medium  text-gray-500 hover:text-gray-800 border border-transparent hover:border-gray-300 rounded-t-lg transition-all {{ request('tab') == 'AIFeedback' || request('tab') == '' ? 'bg-blue-500 text-white' : '' }}">
                            AI Feedback
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div>

                <!-- Resume Tab -->
                <div id="resume" class="{{request('tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden'}}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-100 rounded-tl-lg">Summary</th>
                                <th class="py-2 px-4 bg-gray-100 rounded-tl-lg">Skills</th>
                                <th class="py-2 px-4 bg-gray-100 rounded-tl-lg">Experience</th>
                                <th class="py-2 px-4 bg-gray-100 rounded-tl-lg">Education</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 text-center">{{ $jobApplication->resume->summary }}</td>
                                <td class="py-2 px-4 text-center">{{ $jobApplication->resume->skills }}</td>
                                <td class="py-2 px-4 text-center">{{ $jobApplication->resume->experience }}</td>
                                <td class="py-2 px-4 text-center">{{ $jobApplication->resume->education }}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- AI Feedback Tab -->
                <div id="AIFeedback" class="{{request('tab') == 'AIFeedback' ? 'block' : 'hidden'}}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">AI Score</th>
                                <th class="py-2 px-4 text-left bg-gray-100">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4">{{ $jobApplication->aiGeneratedScore }}</td>
                                <td class="py-2 px-4">{{ $jobApplication->aiGeneratedFeedback }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>
</x-app-layout>