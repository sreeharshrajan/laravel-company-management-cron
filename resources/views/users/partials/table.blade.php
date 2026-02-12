<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Name</th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Email</th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Role</th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        @foreach ($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('users.edit', $user) }}"
                        class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>

                    @if ($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-4 px-6 pb-6">
    {{ $users->links() }}
</div>
