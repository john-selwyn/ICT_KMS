<x-app-layout>
   

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <style>
        

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Header Styles */
        h1 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
            font-weight: 600;
        }

        /* Create Button */
        .create-btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 2rem;
            transition: background-color 0.3s ease;
        }

        .create-btn:hover {
            background-color: #2980b9;
        }

        /* Success Message */
        .success-message {
            background-color: #2ecc71;
            color: white;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background-color: white;
        }

        thead {
            background-color: #f8f9fa;
        }

        th {
            text-align: left;
            padding: 1rem;
            border-bottom: 2px solid #dee2e6;
            color: #2c3e50;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .edit-btn {
            background-color: #f39c12;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover {
            background-color: #d68910;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            td, th {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Categories</h1>
        
        <a href="{{ route('categories.create') }}" class="create-btn">Create New Category</a>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="edit-btn">Edit</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Optional: Add confirmation for delete action
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('Are you sure you want to delete this category?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>

</x-app-layout>