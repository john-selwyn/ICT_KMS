<x-app-layout>
   <br>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
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
        h1 {
            color: #2c3e50;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
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
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        /* Button Styles */
        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .submit-btn {
            background-color: #3498db;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
            flex: 1;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        .cancel-btn {
            background-color: #95a5a6;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
            flex: 1;
        }

        .cancel-btn:hover {
            background-color: #7f8c8d;
        }

        /* Error Styles */
        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        /* Success Message */
        .success-message {
            background-color: #2ecc71;
            color: white;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            text-align: center;
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
                margin-bottom: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Category</h1>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Category Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    required
                    placeholder="Enter category name"
                    value="{{ old('name') }}"
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <a href="{{ route('categories.index') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="submit-btn">Save Category</button>
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
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = 'Category name is required';
                nameInput.parentNode.appendChild(errorDiv);
            }
        });

        // Clear error on input
        document.getElementById('name').addEventListener('input', function() {
            this.style.borderColor = '#e2e8f0';
            const errorMessage = this.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        });
    </script>
</body>
</html>

</x-app-layout>