<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approve Entries') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Approve Entries</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            /* General Styles */
            body {
                font-family: Arial, sans-serif;
                background-color: #f8fafc;
                color: #333;
                margin: 0;
                padding: 20px;
            }

            main {
                max-width: 90%;
                margin: 20px auto;
                padding: 20px;
                background-color: #ffffff;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            h1 {
                font-size: 1.5rem;
                color: #333;
                margin-bottom: 20px;
                text-align: center;
            }

            .success-message {
                padding: 10px;
                margin-bottom: 20px;
                color: #155724;
                background-color: #d4edda;
                border: 1px solid #c3e6cb;
                border-radius: 4px;
                text-align: center;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                border-radius: 6px;
                overflow: hidden;
            }

            th, td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #e1e7ec;
            }

            th {
                background-color: #f1f5f9;
                color: #333;
                font-weight: 600;
            }

            td {
                background-color: #ffffff;
            }

            .action-buttons a, .action-buttons form button {
                text-decoration: none;
                color: #fff;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 0.875rem;
                margin-right: 5px;
                display: inline-block;
                cursor: pointer;
            }

            .edit-button {
                background-color: #4c51bf;
            }

            .delete-button {
                background-color: #f56565;
            }

            .no-attachment, .no-category {
                font-style: italic;
                color: #6b7280;
            }
        </style>
    </head>
    <body>
        <main>
            <h1>Approve Entries</h1>

            @if(session()->has('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Attachment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entries as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            <td>{{ $entry->title }}</td>
                            <td>{{ $entry->description }}</td>
                            <td>{{ $entry->category->name ?? 'No Category' }}</td>
                            <td>
                                @if($entry->attachment)
                                    <a href="{{ asset('storage/' . $entry->attachment) }}" target="_blank" class="attachment-link">View Attachment</a>
                                @else
                                    <span class="no-attachment">No Attachment</span>
                                @endif
                            </td>
                            <td class="action-buttons">
                                <a href="{{ route('entries.edit', ['entries' => $entry]) }}" class="edit-button">Edit</a>
                                <form method="POST" action="{{ route('entries.delete', ['entries' => $entry]) }}" style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </body>
    </html>
</x-app-layout>
