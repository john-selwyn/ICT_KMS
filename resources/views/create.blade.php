<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Entry</title>
        <style>
            :root {
                --primary-blue: #0f2c59;
                --border-gray: #e5e7eb;
                --text-gray: #6b7280;
                --background-white: #ffffff;
            }

            body {
                background-color: #f8fafc;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }

            .container {
                max-width: 48rem;
                margin: 2rem auto;
                padding: 0 1rem;
            }

            .form-card {
                background-color: var(--background-white);
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                padding: 2rem;
            }

            .page-title {
                color: var(--primary-blue);
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 2rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-label {
                display: block;
                color: #374151;
                font-size: 0.875rem;
                font-weight: 500;
                margin-bottom: 0.5rem;
            }

            .form-input,
            .form-select {
                width: 100%;
                padding: 0.625rem;
                border: 1px solid var(--border-gray);
                border-radius: 0.375rem;
                font-size: 0.875rem;
                color: #1f2937;
                transition: border-color 0.2s;
            }

            .form-input:focus,
            .form-select:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            textarea.form-input {
                min-height: 100px;
                resize: vertical;
            }

            .upload-zone {
                border: 2px dashed var(--border-gray);
                border-radius: 0.375rem;
                padding: 2rem;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s;
            }

            .upload-zone:hover {
                border-color: #3b82f6;
                background-color: #f8fafc;
            }

            .upload-icon {
                margin-bottom: 0.75rem;
                color: var(--text-gray);
            }

            .upload-text {
                color: var(--text-gray);
                font-size: 0.875rem;
            }

            .file-info {
                margin-top: 1rem;
                padding: 0.75rem;
                background-color: #f8fafc;
                border-radius: 0.375rem;
                font-size: 0.875rem;
            }

            .submit-button {
                width: 100%;
                padding: 0.75rem;
                background-color: var(--primary-blue);
                color: white;
                border: none;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .submit-button:hover {
                background-color: #1a365d;
            }

            .error-list {
                background-color: #fee2e2;
                border: 1px solid #fecaca;
                border-radius: 0.375rem;
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .error-list li {
                color: #dc2626;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }

            @media (max-width: 640px) {
                .container {
                    margin: 1rem auto;
                }

                .form-card {
                    padding: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="form-card">
                <h1 class="page-title">Create New Entry</h1>

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
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-input" placeholder="Enter title" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" class="form-input" placeholder="Enter description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category">Category</label>
                        <select id="category" name="category_id" class="form-select">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Attachment</label>
                        <div class="upload-zone" id="dropZone">
                            <div class="upload-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/>
                                </svg>
                            </div>
                            <div class="upload-text">Drag and drop a file here or click to browse</div>
                            <input type="file" name="attachment" id="fileInput" class="hidden" accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.jpg,.jpeg,.png" style="display: none;">
                            <div class="file-info" id="fileInfo" style="display: none;">
                                <div class="file-name"></div>
                                <div class="file-size"></div>
                            </div>

                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="youtube_url">YouTube URL</label>
                        <input type="url" name="youtube_url" id="youtube_url" class="form-control" placeholder="https://youtube.com/..." value="{{ old('youtube_url', $entries->youtube_url ?? '') }}">
                    </div>
                    

                    <button type="submit" class="submit-button">Create Entry</button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropZone = document.getElementById('dropZone');
                const fileInput = document.getElementById('fileInput');
                const fileInfo = document.getElementById('fileInfo');

                dropZone.addEventListener('click', () => fileInput.click());

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.add('dragover');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => {
                        dropZone.classList.remove('dragover');
                    });
                });

                dropZone.addEventListener('drop', handleDrop);
                fileInput.addEventListener('change', handleFileSelect);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    handleFiles(files);
                }

                function handleFileSelect(e) {
                    const files = e.target.files;
                    handleFiles(files);
                }

                function handleFiles(files) {
                    if (files.length > 0) {
                        const file = files[0];
                        showFileInfo(file);
                    }
                }

                function showFileInfo(file) {
                    const nameElement = fileInfo.querySelector('.file-name');
                    const sizeElement = fileInfo.querySelector('.file-size');
                    
                    nameElement.textContent = file.name;
                    sizeElement.textContent = formatFileSize(file.size);
                    fileInfo.style.display = 'block';
                }

                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }
            });
        </script>
    </body>
    </html>
</x-app-layout>