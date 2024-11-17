{{-- resources/views/category_items.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $category->name }} Items
        </h2>
    </x-slot>

    <style>
        /* Page Layout */
        .container {
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Category Title */
        .category-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #4A5568;
            margin-bottom: 20px;
        }

        /* Grid for items */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        /* Item Card Styling */
        .item-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Item Card Content */
        .item-card-content {
            padding: 15px;
            text-align: center;
        }

        .item-card-title {
            font-size: 18px;
            font-weight: bold;
            color: #2D3748;
            margin-bottom: 10px;
        }

        .item-card-description {
            font-size: 14px;
            color: #4A5568;
            margin-bottom: 15px;
        }

        .view-detail-btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #4299E1;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.2s ease-in-out;
        }

        .view-detail-btn:hover {
            background-color: #3182CE;
        }
    </style>

    <div class="container">
        <h1 class="category-title">{{ $category->name }} Items</h1>

        <div class="items-grid">
            @foreach($items as $item)
                <div class="item-card">
                    <div class="item-card-content">
                        <h3 class="item-card-title">{{ $item->title }}</h3>
                        <p class="item-card-description">{{ Str::limit($item->description, 100) }}</p>
                        <a href="{{ route('items.show', ['id' => $item->id]) }}" class="view-detail-btn">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
