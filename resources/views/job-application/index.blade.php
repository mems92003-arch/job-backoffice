<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toust-notification />

        <div class="flex justify-end items-center space-x-4 mb-4">
            @if (request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active -->
                <a href="{{ route('job-applications.index') }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-gray-900">
                    Active Job Applications
                </a>
            @else
                <!-- Archived -->
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-gray-900">
                    Archived Job Applications
                </a>
            @endif

        </div>

        <!-- Job Vacancy Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Position (Job Vacancy)</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobApplications as $jobApplication)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived') == 'true')
                                <span class="text-gray-500">{{ $jobApplication->user->name }}</span>
                            @else
                                <a class="text-blue-500 hover:text-blue-700 underline font-medium"
                                    href="{{ route('job-applications.show', $jobApplication->id) }}">
                                    {{ $jobApplication->user?->name ?? 'N/A' }}
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy?->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy->company?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->status }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-4">
                                @if (request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-medium">
                                            🔄 Restore
                                        </button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium">
                                        ✍️ Edit
                                    </a>

                                    <!-- Delete/Archive Button -->
                                    <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="post"
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
            {{ $jobApplications->links() }}
        </div>
    </div>
</x-app-layout>