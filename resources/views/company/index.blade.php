<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toust-notification />

        <div class="flex justify-end items-center space-x-4 mb-4">
            @if (request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active -->
                <a href="{{ route('companies.index') }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-gray-900">
                    Active Companies
                </a>
            @else
                <!-- Archived -->
                <a href="{{ route('companies.index', ['archived' => 'true']) }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-gray-900">
                    Archived Companies
                </a>
            @endif
            <!-- Add Company Button -->
            <a href="{{ route('companies.create') }}"
                class="inline-block rounded-md bg-blue-600 px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-blue-700 active:bg-blue-800">
                Add Company
            </a>
        </div>

        <!-- Companies Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Address</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Industry</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Website</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived') == 'true')
                                <spane class="text-gray-500">{{ $company->name }}</spane>
                            @else
                                <a class="text-blue-500 hover:text-blue-700 underline font-medium"
                                    href="{{ route('companies.show', $company->id) }}">
                                    {{ $company->name }}
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->address ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->industry ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-800">
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank" class="text-blue-400 hover:underline">
                                    {{ $company->website }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-4">
                                @if (request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('companies.restore', $company->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-medium">
                                            🔄 Restore
                                        </button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('companies.edit', $company->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium">
                                        ✍️ Edit
                                    </a>

                                    <!-- Delete/Archive Button -->
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="post"
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
                            No companies found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
</x-app-layout>