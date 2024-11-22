<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enhanced Dashboard</title>
        <style>
            /* Reset and base styles */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                background-color: #f4f7fa;
                padding: 20px;
                color: #333;
            }

            h1 {
                text-align: center;
                font-size: 24px;
                margin-bottom: 30px;
                color: #802424;
            }

            /* Dashboard Cards */
            .dashboard {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }

            .card {
                width: 220px;
                height: 130px;
                background-color: #072169;
                border-radius: 12px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                transition: transform 0.3s ease-in-out;
            }

            .card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
            }

            .card-icon {
                font-size: 36px;
                margin-bottom: 12px;
            }

            .card-title {
                font-size: 16px;
                color: #f4f4f4;
            }

            .card-number {
                font-size: 22px;
                font-weight: bold;
                color: #fff;
            }

            /* Color Variants */
            .card.blue { background-color: #3b82f6; }
            .card.green { background-color: #10b981; }
            .card.red { background-color: #ef4444; }
            .card.orange { background-color: #f59e0b; }

            /* Latest Entries */
            .entries-section {
                margin-top: 50px;
            }

            .entries-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }

            .entry-card {
                background-color: #ffffff;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s ease-in-out;
            }

            .entry-card:hover {
                transform: scale(1.03);
            }

            .entry-card img {
                width: 100%;
                height: 150px;
                object-fit: cover;
            }

            .entry-card-content {
                padding: 15px;
            }

            .entry-card h2 {
                font-size: 18px;
                margin-bottom: 5px;
                color: #333;
            }

            .entry-card p {
                font-size: 14px;
                color: #555;
                margin-bottom: 10px;
            }

            .entry-card a {
                padding: 8px 12px;
                background-color: #3b82f6;
                color: white;
                border-radius: 5px;
                font-size: 14px;
                text-decoration: none;
            }

            .dashboard-stats {
    display: flex;
    gap: 20px;
}

.stat {
    padding: 20px;
    background-color: #f8fafc;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat h3 {
    font-size: 1.25rem;
    margin-bottom: 8px;
}

.stat p {
    font-size: 2rem;
    font-weight: bold;
}

        </style>
    </head>
    <body>

        <h1>Categories </h1>

        <div class="dashboard">
            @foreach ($categories as $category)
                <a href="{{ route('category.items', ['category' => $category->id]) }}">
                    <div class="card blue">
                        <div class="card-icon">{{ $category->icon }}</div>
                        <div class="card-number">{{ $category->entries_count }}</div>
                        <div class="card-title">{{ $category->name }}</div>
                    </div>
                </a>
            @endforeach
        </div>
        
        
        

       

    </body>
    </html>
</x-app-layout>
