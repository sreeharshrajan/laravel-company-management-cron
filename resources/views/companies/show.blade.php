<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Company Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Name</label>
                        <p class="mt-1 text-lg">{{ $company->name }}</p>
                    </div>

                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Email</label>
                        <p class="mt-1 text-lg">{{ $company->email }}</p>
                    </div>

                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Address</label>
                        <p class="mt-1 text-lg">{{ $company->address ?: 'N/A' }}</p>
                    </div>

                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Status</label>
                        <p class="mt-1">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $company->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($company->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('companies.index') }}"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Back to List
                        </a>

                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('companies.edit', $company) }}"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Edit
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
