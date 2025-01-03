<x-app-layout>
    <div class="container">
        <div class="form-card">
            <h1>Edit Entry</h1>

            @if($errors->any())
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('pending.entries.update', $entry->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $entry->title) }}"
                        placeholder="Enter title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter description"
                        required>{{ old('description', $entry->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="categories">Categories</label>
                    <select id="categories" name="categories[]" multiple required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $entry->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <small>Select one or more categories</small>
                </div>


                <div class="form-group">
                    <label>Attachments</label>
                    <div id="fileInputsContainer">
                        @foreach ($attachments as $attachment)
                            <div class="upload-zone">
                                <input type="file" name="attachments[]" class="file-input"
                                    accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png" />

                                <!-- Hidden input for existing attachment ID to retain it in the database -->
                                <input type="hidden" name="existing_attachments[]" value="{{ $attachment->id }}" />

                                <div>
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                        {{ $attachment->file_path }}
                                    </a>
                                </div>

                                <!-- Remove button (X) to delete the attachment -->
                                <button type="button" class="btn-remove"
                                    onclick="removeAttachment({{ $attachment->id }}, this)">X</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="addFileButton" class="btn-secondary">Add Another File</button>
                </div>


                <div class="form-group">
                    <label for="youtube_url">YouTube URL</label>
                    <input type="url" name="youtube_url" id="youtube_url" placeholder="https://youtube.com/..."
                        value="{{ old('youtube_url', $entry->youtube_url ?? '') }}">
                </div>

                <button type="submit">Update Entry</button>
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

        input,
        select,
        textarea {
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
            const fileInputsContainer = document.getElementById('fileInputsContainer');
            const addFileButton = document.getElementById('addFileButton');

            // Add an event listener to the "Add Another File" button
            addFileButton.addEventListener('click', function () {
                const newFileInput = document.createElement('div');
                newFileInput.classList.add('upload-zone');
                newFileInput.innerHTML = `
            <input type="file" name="attachments[]" class="file-input" accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png">
            <button type="button" class="btn-remove" onclick="removeFileInput(this)">Remove</button>
        `;
                fileInputsContainer.appendChild(newFileInput);
            });
        });

        // Function to remove file input
        function removeFileInput(button) {
            button.parentElement.remove();
        }

        // Function to remove attachment and mark it for deletion
        function removeAttachment(attachmentId, button) {
            // This will add the attachment to the list of files to be removed
            const removedInput = document.createElement('input');
            removedInput.setAttribute('type', 'hidden');
            removedInput.setAttribute('name', 'removed_attachments[]');  // Array to track removed files
            removedInput.setAttribute('value', attachmentId);

            // Append the hidden input to the form
            document.querySelector('form').appendChild(removedInput);

            // Remove the file display and remove button from the UI
            button.closest('.upload-zone').remove();
        }

    </script>
</x-app-layout>