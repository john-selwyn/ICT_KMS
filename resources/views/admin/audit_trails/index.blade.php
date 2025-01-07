<x-app-layout>
    <style>
        .sort-btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sort-btn:hover {
            background-color: #e5e7eb;
        }

        .sort-btn.active {
            background-color: #dbeafe;
            border-color: #93c5fd;
            color: #1d4ed8;
        }

        .sort-icon {
            margin-left: 6px;
            transition: transform 0.2s ease;
        }

        .sort-btn.desc .sort-icon {
            transform: rotate(180deg);
        }

        .sort-table tbody tr {
            opacity: 1;
            transition: opacity 0.2s ease;
        }

        .sort-table.sorting tbody tr {
            opacity: 0.5;
        }
    </style>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <div class="p-4 bg-white dark:bg-gray-900 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Audit Trail
                </h2>
                <button class="sort-btn" id="dateSort">
                    <span>Sort by Date</span>
                    <svg class="sort-icon w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            <table class="sort-table w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Action</th>
                        <th class="px-6 py-3">Performed By</th>
                        <th class="px-6 py-3">Affected User</th>
                        <th class="px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditTrails as $auditTrail)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 {{ $loop->even ? 'bg-gray-50 dark:bg-gray-700' : '' }}"
                            data-date="{{ $auditTrail->created_at }}">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $auditTrail->action }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $auditTrail->performed_by_user_name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $auditTrail->affected_user_name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $auditTrail->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('.sort-table');
            const sortBtn = document.getElementById('dateSort');
            let isAsc = true;

            sortBtn.addEventListener('click', function() {
                // Toggle sort direction
                isAsc = !isAsc;
                
                // Update button appearance
                this.classList.toggle('desc', !isAsc);
                this.classList.add('active');
                
                // Add sorting class for animation
                table.classList.add('sorting');
                
                // Sort the rows
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                rows.sort((a, b) => {
                    const aValue = new Date(a.dataset.date);
                    const bValue = new Date(b.dataset.date);
                    return isAsc ? aValue - bValue : bValue - aValue;
                });
                
                // Clear and re-append rows
                rows.forEach(row => tbody.appendChild(row));
                
                // Remove sorting class after animation
                setTimeout(() => {
                    table.classList.remove('sorting');
                }, 200);
            });
        });
    </script>
</x-app-layout>