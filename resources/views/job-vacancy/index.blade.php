<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancies') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toust-notification />

        <div class="flex justify-end items-center space-x-4 mb-4">
            @if (request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active -->
                <a href="{{ route('job-vacancies.index') }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-gray-900">
                    Active Job Vacancies
                </a>
            @else
                <!-- Archived -->
                <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-gray-900">
                    Archived Job Vacancies
                </a>
            @endif
            <!-- Add Company Button -->
            <a href="{{ route('job-vacancies.create') }}"
                class="inline-block rounded-md bg-blue-600 px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-blue-700 active:bg-blue-800">
                Add Job Vacancy
            </a>
        </div>

        <!-- Job Vacancy Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobVacancies as $jobVacancy)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived') == 'true')
                                <spane class="text-gray-500">{{ $jobVacancy->title }}</spane>
                            @else
                                <a class="text-blue-500 hover:text-blue-700 underline font-medium"
                                    href="{{ route('job-vacancies.show', $jobVacancy->id) }}">
                                    {{ $jobVacancy->title }}
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->company?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->type }}</td>
                        <td class="px-6 py-4 text-gray-800">${{ number_format($jobVacancy->salary, 2) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-4">
                                @if (request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-vacancies.restore', $jobVacancy->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-medium">
                                            🔄 Restore
                                        </button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-vacancies.edit', $jobVacancy->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium">
                                        ✍️ Edit
                                    </a>

                                    <!-- Delete/Archive Button -->
                                    <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                            🗃️ Archive
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <!-- عدلت colspan لـ 5 عشان يغطي الجدول كله -->
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No job vacancies found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>
    </div>
</x-app-layout>