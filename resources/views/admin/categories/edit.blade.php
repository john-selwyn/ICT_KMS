<x-app-layout>
    <br>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <style>
        /* Modern CSS Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 2rem;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .category-id {
            color: #7f8c8d;
            font-size: 1rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
            font-size: 1.1rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }

        .update-btn {
            background-color: #3498db;
            color: white;
        }

        .update-btn:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }

        .cancel-btn {
            background-color: #95a5a6;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #7f8c8d;
            transform: translateY(-1px);
        }

        /* Messages */
        .message {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .success-message {
            background-color: #2ecc71;
            color: white;
        }

        .error-message {
            background-color: #e74c3c;
            color: white;
        }

        .field-error {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .container {
                padding: 1.5rem;
            }

            h1 {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Category</h1>
            <span class="category-id">ID: {{ $category->id }}</span>
        </div>

        @if(session('success'))
            <div class="message success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="message error-message">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Category Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $category->name) }}" 
                    required
                    placeholder="Enter category name"
                >
                @error('name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <a href="{{ route('categories.index') }}" class="btn cancel-btn">Cancel</a>
                <button type="submit" class="btn update-btn">Update Category</button>
            </div>
        </form>
    </div>

    <script>
        // Optional: Add client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const nameInput = document.getElementById('name');
            if (nameInput.value.trim() === '') {
                e.preventDefault();
                nameInput.style.borderColor = '#e74c3c';
                
                // Remove existing error message if any
                const existingError = document.querySelector('.field-error');
                if (existingError) {
                    existingError.remove();
                }

                // Add new error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error';
                errorDiv.textContent = 'Category name is required';
                nameInput.parentNode.appendChild(errorDiv);
            }
        });

        // Clear error styling on input
        document.getElementById('name').addEventListener('input', function() {
            this.style.borderColor = '#e2e8f0';
            const errorMessage = document.querySelector('.field-error');
            if (errorMessage) {
                errorMessage.remove();
            }
        });

        // Optional: Auto-dismiss success/error messages
        const messages = document.querySelectorAll('.message');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }, 3000);
        });
    </script>
</body>
</html>

</x-app-layout>