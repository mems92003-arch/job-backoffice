<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }} {{request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toust-notification />

        <div class="flex justify-end items-center space-x-4">

            @if (request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active -->
                <a href="{{ route('job-categories.index') }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-gray-900">
                    Active
                </a>
            @else
                <!-- Archived (هيبقى على الشمال) -->
                <a href="{{ route('job-categories.index', ['archived' => 'true']) }}"
                    class="inline-block rounded-md bg-black px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-gray-800 active:bg-blue-800">
                    Archived
                </a>
            @endif
            <!-- Add Job Category Button (هيبقى على اليمين) -->
            <a href="{{ route('job-categories.create') }}"
                class="inline-block rounded-md bg-blue-600 px-4 py-2 font-semibold text-white no-underline shadow transition hover:bg-blue-700 active:bg-blue-800">
                Add Job Category
            </a>

        </div>

        <!-- Job Category Table -->
        <table class="min-w-full divide-y divide-gray-200 rouneded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-6">
                                @if (request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Buttone -->

                                    <form action="{{ route('job-categories.restore', $category->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 font-medium">
                                            🔄 Restore
                                        </button>
                                    </form>

                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-categories.edit', $category->id) }}"
                                        class="text-blue-500 hover:text-blue-700">✍️Edit</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('job-categories.destroy', $category->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">🗃️Archive</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-800"> No categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>