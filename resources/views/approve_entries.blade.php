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
    
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
    
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background-color: var(--background-color);
                color: var(--text-primary);
                line-height: 1.5;
            }
    
            main {
                padding: 1.5rem;
                max-width: 1200px;
                margin: 0 auto;
            }
    
            .page-title {
                font-size: 1.875rem;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 1.5rem;
                text-align: center;
            }
    
            .success-alert {
                background-color: #dcfce7;
                color: #166534;
                padding: 1rem;
                border-radius: 0.5rem;
                margin-bottom: 1.5rem;
                text-align: center;
            }
    
            .search-container {
                margin-bottom: 1.5rem;
            }
    
            .search-form {
                display: flex;
                gap: 0.5rem;
                max-width: 600px;
                margin: 0 auto;
            }
    
            .search-input {
                flex: 1;
                padding: 0.75rem;
                border: 1px solid var(--border-color);
                border-radius: 0.5rem;
                font-size: 1rem;
            }
    
            .search-button {
                padding: 0.75rem 1.5rem;
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 0.5rem;
                cursor: pointer;
                transition: background-color 0.2s;
            }
    
            .search-button:hover {
                background-color: #4338ca;
            }
    
            .entries-grid {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }
    
            .entry-card {
                background-color: var(--card-background);
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                padding: 1rem;
                transition: transform 0.2s;
            }
    
            .entry-card:hover {
                transform: translateY(-2px);
            }
    
            .entry-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 0.5rem;
            }
    
            .entry-id {
                font-size: 0.875rem;
                color: var(--text-secondary);
            }
    
            .entry-title {
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 0.5rem;
            }
    
            .entry-description {
                color: var(--text-secondary);
                margin-bottom: 0.5rem;
                word-break: break-word;
            }
    
            .entry-category {
                display: inline-block;
                padding: 0.25rem 0.75rem;
                background-color: #e5e7eb;
                border-radius: 1rem;
                font-size: 0.875rem;
                margin-bottom: 0.5rem;
            }
    
            .entry-attachment {
                margin-bottom: 0.75rem;
            }
    
            .attachment-link {
                color: var(--primary-color);
                text-decoration: none;
                font-size: 0.875rem;
            }
    
            .no-attachment {
                color: var(--text-secondary);
                font-style: italic;
                font-size: 0.875rem;
            }
    
            .entry-actions {
                display: flex;
                gap: 0.5rem;
                margin-top: 1rem;
            }
    
            .btn {
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                text-decoration: none;
                text-align: center;
                transition: background-color 0.2s;
                flex: 1;
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
                border: none;
                cursor: pointer;
            }
    
            .btn-delete:hover {
                background-color: #dc2626;
            }
    
            @media (max-width: 640px) {
                main {
                    padding: 1rem;
                }
    
                .page-title {
                    font-size: 1.5rem;
                }
    
                .search-form {
                    flex-direction: column;
                }
    
                .search-button {
                    width: 100%;
                }
    
                .entries-grid {
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
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search entries..." 
                        value="{{ request('search') }}"
                        class="search-input"
                    >
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>
    
            <div class="entries-grid">
                @foreach($entries as $entry)
                    <div class="entry-card">
                        
                        <!-- 
                        <div class="entry-header">
                            <span class="entry-id">#{{ $entry->id }}</span>
                        </div>

                        -->
                        
                        <h2 class="entry-title">{{ $entry->title }}</h2>
                        <p class="entry-description">{{ $entry->description }}</p>
                        
                        <div class="entry-category">
                            {{ $entry->category->name ?? 'No Category' }}
                        </div>
                        
                        <div class="entry-attachment">
                            @if($entry->attachment)
                                <a href="{{ asset('storage/' . $entry->attachment) }}" target="_blank" class="attachment-link">
                                    View Attachment
                                </a>
                            @else
                                <span class="no-attachment">No Attachment</span>
                            @endif
                        </div>
    
                        <div class="entry-actions">
                            <a href="{{ route('entries.show', ['entry' => $entry->id]) }}" class="btn btn-view">View</a>
                            <a href="{{ route('entriess.edit', ['entry' => $entry->id]) }}" class="btn btn-edit">Edit</a>
                            <form method="POST" action="{{ route('entriesss.delete', ['entry' => $entry->id]) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                            

                            
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </body>
    </html>
    </x-app-layout>