<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">Add New User</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name">Name</label>
                <input type="text" name="name" class="w-full border p-2" required>
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" class="w-full border p-2" required>
            </div>

            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="w-full border p-2" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border p-2" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>

</x-app-layout>