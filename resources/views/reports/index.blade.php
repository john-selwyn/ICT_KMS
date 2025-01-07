<x-app-layout>
    <style>
        /* Container styling */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header styling */
        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            font-weight: 600;
            text-align: center;
        }

        h3 {
            color: #444;
            font-size: 1.5rem;
            margin: 2rem 0 1rem;
            font-weight: 500;
        }

        /* Chart containers */
        .container>div {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Canvas containers */
        canvas {
            max-height: 400px;
            width: 100%;
            margin: 1rem 0;
        }

        /* Export button styling */
        .btn-primary {
            background-color: #4361ee;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #3547d3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            h3 {
                font-size: 1.25rem;
            }

            canvas {
                max-height: 300px;
            }
        }
    </style>

    <div class="container">
        <h1>Category Report</h1>

        <!-- Category Chart -->
        <div>
            <h3>Entries by Category</h3>
            <canvas id="categoryChart"></canvas>
        </div>

        <!-- Popularity Chart -->
        <div>
            <h3>Most Popular Entries</h3>
            <canvas id="popularEntriesChart"></canvas>
        </div>

        <!-- Export Button -->
        <form action="{{ route('reports.export') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-primary">Export Report</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Category Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: @json($categoryData->pluck('category.name')),
                    datasets: [{
                        label: 'Entries',
                        data: @json($categoryData->pluck('count')),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    }]
                }
            });

            // Popularity Chart
            const popularityCtx = document.getElementById('popularEntriesChart').getContext('2d');
            new Chart(popularityCtx, {
                type: 'bar',
                data: {
                    labels: @json($popularEntries->pluck('title')),
                    datasets: [{
                        label: 'Views',
                        data: @json($popularEntries->pluck('views')),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Views' }
                        },
                        x: {
                            title: { display: true, text: 'Entries' }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>