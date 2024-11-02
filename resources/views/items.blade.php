<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Items in Category: ') . $category }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3>Items in {{ $category }} Category</h3>

                @if ($items->isEmpty())
                    <p>No items found in this category.</p>
                @else
                    <ul>
                        @foreach ($items as $item)
                            <li>{{ $item->title }} - {{ $item->description }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
