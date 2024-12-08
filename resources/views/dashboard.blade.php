<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="dashboard-container">
        <!-- Search Bar -->
        <div class="search-container">
            <div class="search-wrapper">
                <input type="search" class="search-input" placeholder="Search knowledge system...">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <!-- Total Categories -->
            <a href="{{ route('categories.index') }}" class="stat-card">
                <div>
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Total Categories</p>
                            <p class="stat-value">{{ $categoryCount }}</p>
                        </div>
                        <div class="stat-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Total Users -->
            <a href="{{ route('users.index') }}" class="stat-card">
                <div>
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Total Users</p>
                            <p class="stat-value">{{ $userCount }}</p>
                        </div>
                        <div class="stat-icon green">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Total Entries -->
            <a href="{{ route('entries.approves') }}" class="stat-card">
                <div>
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Total Entries</p>
                            <p class="stat-value">{{ $approve_entriesCount }}</p>
                        </div>
                        <div class="stat-icon purple">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

            </a>

            <!-- Pending Entries -->
            <a href="{{ route('entries.pending') }}" class="stat-card">
                <div>
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Pending Entries</p>
                            <p class="stat-value">{{ $pending_entriesCount }}</p>
                        </div>
                        <div class="stat-icon orange">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <!-- Recent Activity -->
        <div class="activity-card">
            <h3 class="activity-title">Recents Activity</h3>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <p class="activity-text">New entry added to Database Management</p>
                </div>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <p class="activity-text">Category "Network Security" updated</p>
                </div>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <p class="activity-text">New user registration approved</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* General Styles */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
        }

        /* Search Bar */
        .search-container {
            margin-bottom: 24px;
            display: flex;
            justify-content: flex-end;
        }

        .search-wrapper {
            position: relative;
            width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 10px 40px 10px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            border-color: #3b82f6;
        }

        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9ca3af;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            animation: fadeIn 0.5s ease-out;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info {
            flex-grow: 1;
        }

        .stat-label {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
        }

        .stat-icon {
            padding: 12px;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
        }

        /* Icon Colors */
        .blue {
            background: #eff6ff;
            color: #3b82f6;
        }

        .green {
            background: #ecfdf5;
            color: #10b981;
        }

        .purple {
            background: #f5f3ff;
            color: #8b5cf6;
        }

        .orange {
            background: #fff7ed;
            color: #f97316;
        }

        /* Activity Card */
        .activity-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .activity-title {
            font-size: 18px;
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 16px;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3b82f6;
        }

        .activity-text {
            font-size: 14px;
            color: #6b7280;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 16px;
            }

            .stats-grid {
                gap: 16px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-value {
                font-size: 20px;
            }

            .search-wrapper {
                width: 100%;
            }
        }
    </style>
</x-app-layout>