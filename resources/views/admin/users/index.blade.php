<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header with DepEd styling -->
        <div class="bg-gradient-to-r from-blue-800 to-blue-600 py-6 px-4 shadow-lg">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('path-to-deped-binan-logo.png') }}" alt="DepEd Biñan Logo" class="h-16 w-auto">
                    <h1 class="text-2xl font-bold text-white">User Management System</h1>
                </div>
                <span class="text-yellow-300 font-semibold">DepEd Biñan Division</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto py-8 px-4">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
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
                                <th class="px-6 py-3 text-left text-sm font-semibold text-blue-800">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm space-x-3">
                                        <a href="{{ route('users.edit', $user) }}" 
                                           class="text-blue-600 hover:text-blue-800 font-medium">
                                            Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 font-medium"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>