<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Trashed Entries</title>
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
                color: var(--text-primary);
            }

            .trashed-entries-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                gap: 1.5rem;
            }

            .trashed-entry-card {
                background-color: #fef3f2;
                border-radius: 0.75rem;
                padding: 1.25rem;
                display: flex;
                flex-direction: column;
                border: 1px solid #fde6e6;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .trashed-entry-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .trashed-entry-title {
                font-size: 1.125rem;
                font-weight: 600;
                color: #7f1d1d;
                margin-bottom: 0.75rem;
            }

            .trashed-entry-details {
                font-size: 0.875rem;
                color: #9f1239;
                margin-bottom: 1rem;
            }

            .trashed-entry-actions {
                display: grid;
                grid-template-columns: 1fr 1fr;
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

            .btn-restore {
                background-color: var(--success-color);
                color: white;
            }

            .btn-restore:hover {
                background-color: #15803d;
            }

            .btn-permanent-delete {
                background-color: var(--danger-color);
                color: white;
            }

            .btn-permanent-delete:hover {
                background-color: #dc2626;
            }

            .no-trashed-entries {
                text-align: center;
                color: var(--text-secondary);
                font-size: 1rem;
                margin-top: 2rem;
            }

            @media (max-width: 768px) {
                main {
                    padding: 1rem;
                }

                .trashed-entries-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>

    <body>
        <main>
            <h1 class="page-title">Trashed Entries</h1>

            @if($trashedEntries->count() > 0)
                <div class="trashed-entries-grid">
                    @foreach($trashedEntries as $entry)
                        <div class="trashed-entry-card">
                            <h2 class="trashed-entry-title">{{ $entry->title }}</h2>

                            @if($entry->description)
                                <p class="trashed-entry-details">{{ Str::limit($entry->description, 100) }}</p>
                            @endif

                            <div class="trashed-entry-actions">

                                <form method="POST" action="{{ route('entries.restore', $entry->id) }}"
                                    style="display: contents;">
                                    @csrf
                                    <button type="submit" class="btn btn-restore">Restore</button>
                                </form>
                                <form method="POST" action="{{ route('entries.delete', $entry->id) }}"
                                    style="display: contents;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-permanent-delete">Delete Permanently</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="no-trashed-entries">No entries in the trash.</p>
            @endif
        </main>
    </body>

    </html>
</x-app-layout>