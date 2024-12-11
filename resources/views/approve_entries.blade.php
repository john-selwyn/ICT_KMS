<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Approve Entries</title>
        <style>
            :root {
                --primary-color: #4f46e5;
                --danger-color: #ef4444;
                --success-color: #22c55e;
                --background-color: #f8fafc;
                --card-background: #ffffff;
                --text-primary: #1f2937;
                --text-secondary: #6b7280;
                --border-color: #e5e7eb;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background-color: var(--background-color);
                color: var(--text-primary);
                line-height: 1.5;
                margin: 0;
                padding: 0;
            }

            main {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }

            .page-title {
                font-size: 1.875rem;
                font-weight: 600;
                text-align: center;
                margin-bottom: 2rem;
            }

            .success-alert {
                background-color: #dcfce7;
                color: #166534;
                padding: 1rem;
                border-radius: 0.5rem;
                margin-bottom: 2rem;
                text-align: center;
            }

            .search-container {
                margin-bottom: 2rem;
            }

            .search-form {
                display: flex;
                gap: 1rem;
                max-width: 800px;
                margin: 0 auto;
            }

            .search-input {
                flex: 1;
                padding: 0.75rem 1rem;
                border: 1px solid var(--border-color);
                border-radius: 0.5rem;
                font-size: 0.875rem;
                outline: none;
            }

            .search-input:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
            }

            .search-button {
                padding: 0.75rem 1.5rem;
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 0.5rem;
                cursor: pointer;
                font-weight: 500;
                transition: background-color 0.2s;
            }

            .search-button:hover {
                background-color: #4338ca;
            }

            .filter-select {
                padding: 0.75rem 1rem;
                border: 1px solid var(--border-color);
                border-radius: 0.5rem;
                font-size: 0.875rem;
                outline: none;
                background-color: white;
                color: var(--text-primary);
                cursor: pointer;
                min-width: 150px;
            }

            .filter-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
            }

            .entries-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                gap: 1.5rem;
                margin: 0 auto;
            }

            .entry-card {
                background-color: white;
                border-radius: 0.75rem;
                padding: 1.25rem;
                display: flex;
                flex-direction: column;
                height: 100%;
                border: 1px solid #e5e7eb;
            }

            .entry-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .entry-title {
                font-size: 1.125rem;
                font-weight: 600;
                margin-bottom: 0.75rem;
                color: #111827;
            }

            .entry-description {
                font-size: 0.875rem;
                color: #6b7280;
                margin-bottom: 0.75rem;
                line-height: 1.5;
            }

            .entry-category {
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0.75rem;
                background-color: #f3f4f6;
                border-radius: 1rem;
                font-size: 0.75rem;
                color: #4b5563;
                max-width: fit-content;
                margin-bottom: 1rem;
                border: 1px solid #e5e7eb;
            }

            .entry-attachment {
                margin-bottom: 1rem;
            }

            .attachment-link {
                color: var(--primary-color);
                text-decoration: none;
                font-size: 0.875rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .no-attachment {
                color: var(--text-secondary);
                font-style: italic;
                font-size: 0.875rem;
            }

            .entry-actions {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.75rem;
                margin-top: auto;
            }

            .btn {
                padding: 0.625rem 1rem;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                text-align: center;
                transition: all 0.2s;
                border: none;
                cursor: pointer;
            }

            .btn-view {
                background-color: #f3f4f6;
                color: var(--text-primary);
            }

            .btn-view:hover {
                background-color: #e5e7eb;
            }

            .btn-edit {
                background-color: var(--primary-color);
                color: white;
            }

            .btn-edit:hover {
                background-color: #4338ca;
            }

            .btn-delete {
                background-color: var(--danger-color);
                color: white;
            }

            .btn-delete:hover {
                background-color: #dc2626;
            }

            @media (max-width: 768px) {
                main {
                    padding: 1rem;
                }

                .entries-grid {
                    grid-template-columns: 1fr;
                }

                .search-form {
                    flex-direction: column;
                }

                .entry-actions {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>

    <body>
        <main>
            <h1 class="page-title">Approve Entries</h1>

            @if(session()->has('success'))
                <div class="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="search-container">
                <form method="GET" action="{{ route('entries.search') }}" class="search-form">
                    <input type="text" name="search" placeholder="Search entries..." value="{{ request('search') }}"
                        class="search-input">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>

            <div class="entries-grid">
                @foreach($entries as $entry)
                    <div class="entry-card">
                        <h2 class="entry-title">{{ $entry->title }}</h2>
                        <p class="entry-description">{{ $entry->description }}</p>

                        <div class="entry-category">
                            {{ $entry->category->name ?? 'No Category' }}
                        </div>

                        <div class="entry-attachment">
                            @if($entry->approve_attachments)
                                @foreach($entry->approve_attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank"
                                        class="attachment-link">
                                        View Attachment
                                    </a>
                                    <br>
                                @endforeach
                            @else
                                <span class="no-attachment">No Attachment</span>
                            @endif

                        </div>

                        <div class="entry-actions">
                            <a href="{{ route('entries.show', $entry->id) }}" class="btn btn-view">View</a>
                            <a href="{{ route('entries.edit', $entry->id) }}" class="btn btn-edit">Edit</a>
                            <form method="POST" action="{{ route('entries.trash', $entry->id) }}"
                                style="display: contents;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Move To Trash</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </body>

    </html>
</x-app-layout>