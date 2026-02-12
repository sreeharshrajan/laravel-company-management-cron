<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ $message }}</span>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0">
                        <a href="{{ route('users.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create User
                        </a>

                        <form action="{{ route('users.index') }}" method="GET"
                            class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <input type="text" name="search" placeholder="Search by name or email"
                                value="{{ request('search') }}"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">

                            <select name="status"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>

                            <button type="submit"
                                class="bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </form>
                    </div>

                    <div id="users-table-container">
                        @include('users.partials.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchUsers(url) {
                var search = $('input[name="search"]').val();
                var status = $('select[name="status"]').val();
                var currentUrl = url || "{{ route('users.index') }}";

                $.ajax({
                    url: currentUrl,
                    type: 'GET',
                    data: {
                        search: search,
                        status: status
                    },
                    success: function(response) {
                        $('#users-table-container').html(response);
                        // Update browser URL without reloading
                        var newUrl = currentUrl + (currentUrl.includes('?') ? '&' : '?') + $.param({
                            search: search,
                            status: status
                        });
                        window.history.pushState({
                            path: newUrl
                        }, '', newUrl);
                    },
                    error: function(xhr) {
                        console.error('Error fetching users:', xhr);
                    }
                });
            }

            // Search input keyup
            var timer;
            $('input[name="search"]').on('input', function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    fetchUsers();
                }, 500); // Debounce
            });

            // Status change
            $('select[name="status"]').on('change', function() {
                fetchUsers();
            });

            // Pagination click
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                fetchUsers(url);
            });

            // Prevent form submission
            $('form').on('submit', function(e) {
                e.preventDefault();
                fetchUsers();
            });
        });
    </script>
    </div>
    </div>
    </div>
</x-app-layout>
