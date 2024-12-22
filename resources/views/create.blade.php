<x-app-layout>
    <div class="container">
        <div class="form-card">
            <h1>Create New Entry</h1>

            @if($errors->any())
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('entries.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="category">Csategory</label>
                    <select id="category" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                

                

                <div class="form-group">
                    <label>Attachments</label>
                    <div id="fileInputsContainer">
                        <div class="upload-zone">
                            <input type="file" name="attachments[]" class="file-input" accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <button type="button" id="addFileButton" class="btn-secondary">Add Another File</button>
                </div>

                <div class="form-group">
                    <label for="youtube_url">YouTube URL</label>
                    <input type="url" name="youtube_url" id="youtube_url" placeholder="https://youtube.com/..." value="{{ old('youtube_url', $entries->youtube_url ?? '') }}">
                </div>

                <button type="submit">Create Entry</button>
            </form>
        </div>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            background-color: #0f2c59;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #0a1f3d;
        }

        .error-list {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            list-style-type: none;
        }

        .error-list li {
            color: #dc2626;
            margin-bottom: 5px;
        }

        .upload-zone {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 5px;
        }

        .upload-zone:hover {
            border-color: #0f2c59;
            background-color: #f8f9fa;
        }

        .upload-icon {
            margin-bottom: 10px;
            color: #666;
        }

        .upload-text {
            color: #666;
            margin-bottom: 10px;
        }

        #fileInput {
            display: none;
        }

        .file-info {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .form-card {
                padding: 20px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInputsContainer = document.getElementById('fileInputsContainer'); // Container for file inputs
            const addFileButton = document.getElementById('addFileButton'); // Button to add more file inputs

            // Event listener for "Add Another File" button
            addFileButton.addEventListener('click', function () {
                const newFileInput = document.createElement('div'); // Create a new div for the file input
                newFileInput.classList.add('upload-zone'); // Add a class for styling
                newFileInput.innerHTML = `
                    <input type="file" name="attachments[]" class="file-input" accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png">
                    <button type="button" class="btn-remove" onclick="removeFileInput(this)">Remove</button>
                `;
                fileInputsContainer.appendChild(newFileInput); // Append the new input to the container
            });
        });

        // Function to handle removing a file input field
        function removeFileInput(button) {
            button.parentElement.remove(); // Remove the parent div of the "Remove" button
        }
    </script>
</x-app-layout>
