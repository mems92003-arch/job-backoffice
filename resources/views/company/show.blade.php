<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $company->name }}
            </h2>
        </div>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toust-notification />

        @if (auth()->user()->role == 'admin')
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('companies.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800  px-4 py-2 rounded-md">← Back</a>
            </div>
        @endif

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md border border-gray-100 mt-4">
            <!-- Company Details -->

            <div class="space-y-4 text-gray-700">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-3">Company Information</h3>
                <p><strong>Owner:</strong>{{ $company->owner->name }}</p>
                <p><strong>Email:</strong>{{ $company->owner->email }}</p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Address</span>
                    {{ $company->address ?: 'Not provided' }}
                </p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Industry</span>
                    {{ $company->industry ?: 'Not provided' }}
                </p>
                <p>
                    <span class="font-semibold text-gray-900 block mb-1">Website</span>
                    @if($company->website)
                        <a class="text-blue-600 hover:text-blue-800 underline" href="{{ $company->website }}"
                            target="_blank">
                            {{ $company->website }}
                        </a>
                    @else
                        Not provided
                    @endif
                </p>
            </div>

            @if (auth()->user()->role == 'admin')
                <!-- Tabs Navigation (مع إضافة مسافة فصل واضحة وحواشي أنيقة) -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <ul class="flex space-x-3 border-b border-gray-200 pb-2">
                        <li>
                            <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                                class="inline-block px-5 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-800 border border-transparent hover:border-gray-300 rounded-t-lg transition-all {{ request('tab') == 'jobs' || request('tab') == '' ? 'bg-blue-500 text-white' : ''}}">
                                Jobs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applications']) }}"
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
                                @foreach ($company->jobVacancies as $job)
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
                                @foreach ($company->jobApplications as $aplication)
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
            @endif

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end items-center space-x-3">
                @if (auth()->user()->role == 'company-owner')
                    {{-- تصحيح قفزة القوس هنا --}}
                    <a href="{{ route('my-company.edit') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-blue-600 text-blue-600 rounded-md font-medium text-sm hover:bg-blue-600 hover:text-white transition duration-150 shadow-sm">
                        Edit
                    </a>
                @else
                    <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-blue-600 text-blue-600 rounded-md font-medium text-sm hover:bg-blue-600 hover:text-white transition duration-150 shadow-sm">
                        Edit
                    </a>
                @endif {{-- إضافة الـ endif الناقصة --}}

                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('companies.destroy', $company->id) }}" method="post" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to archive this company?')"
                            class="inline-flex items-center px-4 py-2 bg-white border border-red-500 text-red-500 rounded-md font-medium text-sm hover:bg-red-500 hover:text-white transition duration-150 shadow-sm">
                            Archive
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>