<x-app-layout>
    <style>
        .promote-button,
        .demote-button {
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            border: none;
        }

        .promote-button {
            background-color: #28a745;
        }

        .demote-button {
            background-color: #dc3545;
        }

        .info-message {
            padding: 10px;
            margin-bottom: 20px;
            color: #856404;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 4px;
            text-align: center;
        }
    </style>

    @if(session()->has('message'))
        <div class="info-message">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto py-8 px-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Manage Users</h2>
                <a href="{{ route('users.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md flex items-center transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add User
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-50">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-blue-800">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-blue-800">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-blue-800">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-blue-800">Role</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-blue-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()">
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium"
                                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>