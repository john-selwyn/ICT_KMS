<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
    }

    .page-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }

    .add-button {
        background-color: #4f46e5;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
        border: none;
        transition: background-color 0.2s;
    }

    .add-button:hover {
        background-color: #4338ca;
    }

    .main-content {
        padding: 3rem 0;
    }

    .container {
        max-width: 80rem;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .success-message {
        background-color: #ecfdf5;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }

    .success-text {
        color: #065f46;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .table-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-header {
        background-color: #f9fafb;
        text-align: left;
        padding: 0.75rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
    }

    .table-cell {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .category-badge {
        background-color: #dbeafe;
        color: #1e40af;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .attachment-link {
        color: #4f46e5;
        text-decoration: none;
    }

    .attachment-link:hover {
        color: #4338ca;
    }

    .no-attachment {
        color: #9ca3af;
    }

    .view-button,
.approve-button,
.delete-button {
    display: inline-block;
    background-color: #6366f1;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    line-height: 1.2;
}

.approve-button {
    background-color: #10b981;
}

.delete-button {
    background-color: #ef4444;
}
    /* Optional hover effects */
    .view-button:hover,
    .approve-button:hover,
    .delete-button:hover {
        opacity: 0.9;
    }
</style>

<x-app-layout>
    <div class="header-container">
        <h2 class="page-title">{{ __('Pending Entries') }}</h2>
        <a href="{{ route('entries.create') }}" class="add-button">Add New Entry</a>
    </div>

    <div class="main-content">
        <div class="container">
            @if(session()->has('success'))
                <div class="success-message">
                    <p class="success-text">{{ session('success') }}</p>
                </div>
            @endif

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="table-header">ID</th>
                            <th class="table-header">Title</th>
                            <th class="table-header">Description</th>
                            <th class="table-header">Category</th>
                            <th class="table-header">Attachment</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                            <tr>
                                <td class="table-cell">{{ $entry->id }}</td>
                                <td class="table-cell">{{ $entry->title }}</td>
                                <td class="table-cell">
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $entry->description }}
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="category-badge">
                                        {{ $entry->category->name ?? 'No Category' }}
                                    </span>
                                </td>
                                <td class="table-cell">
                                    @if($entry->attachment)
                                        <a href="#" class="attachment-link">{{ $entry->attachment }}</a>
                                    @else
                                        <span class="no-attachment">No attachment</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('show.pending', ['entry' => $entry->id]) }}" 
                                           class="view-button">Review</a>
                                        
                                        <form action="{{ route('entries.approve', $entry->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('post')
                                            <button type="submit" class="approve-button">Approve</button>
                                        </form>
                                
                                        <form method="POST" action="{{ route('entries.delete', ['entries' => $entry]) }}" style="display: inline;">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="delete-button" 
                                                    onclick="return confirm('Are you sure you want to delete this entry?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>