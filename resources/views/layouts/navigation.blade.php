<nav class="w-64 min-h-screen bg-white border-r border-gray-200 p-4">
    <div class="flex items-center mb-6 px-4 border-b border-gray-200 pb-4 pt-2">
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-3 text-2xl font-bold text-gray-800 tracking-wide hover:opacity-80 transition">
            <x-application-logo class="w-8 h-8 text-indigo-600 fill-current shrink-0" />
            <span>Shaghalni</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col px-4 py-6 space-y-4">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        {{-- استخدام ?-> عشان نتجنب الـ Null Error --}}
        @if (auth()->user()?->role === 'admin')
            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('company.*')">
                {{ __('Companies') }}
            </x-nav-link>
        @endif

        @if (auth()->user()?->role === 'company-owner')
            <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.show')">
                My Company
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('application.*')">
            {{ __('Applications') }}
        </x-nav-link>

        @if (auth()->user()?->role === 'admin')
            <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('category.*')">
                {{ __('Categories') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancy.*')">
            {{ __('Job Vacancies') }}
        </x-nav-link>

        @if (auth()->user()?->role === 'admin')
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                Users
            </x-nav-link>
        @endif

        <hr />

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <x-nav-link class="text-red-500" :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-nav-link>
        </form>
    </ul>
</nav>