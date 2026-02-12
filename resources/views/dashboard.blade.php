<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                You are logged in as a <span
                                    class="font-semibold text-indigo-600 dark:text-indigo-400">{{ ucfirst(auth()->user()->role) }}</span>.
                            </p>
                        </div>
                        <div class="hidden sm:block">
                            <span
                                class="inline-flex items-center justify-center p-3 bg-indigo-100 dark:bg-indigo-900 rounded-full">
                                <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Total Companies Card --}}
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                    <div class="p-6 border-l-4 border-blue-500 dark:border-blue-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Companies</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ \App\Models\Company::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Users Card (Admin Only) --}}
                @if (auth()->user()->isAdmin())
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                        <div class="p-6 border-l-4 border-green-500 dark:border-green-400">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ \App\Models\User::count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Quick Actions Card --}}
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                    <div class="p-6 border-l-4 border-purple-500 dark:border-purple-400">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Quick Actions</p>
                                    <a href="{{ route('companies.index') }}"
                                        class="text-sm font-semibold text-purple-600 dark:text-purple-400 hover:underline">
                                        {{ auth()->user()->isAdmin() ? 'Manage Companies' : 'View Companies' }} &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
