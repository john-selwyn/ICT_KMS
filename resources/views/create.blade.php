<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Entry</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f7f9fc;
                margin: 0;
                padding: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .container {
                background-color: white;
                border-radius: 8px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                padding: 40px;
                max-width: 600px;
                width: 100%;
            }

            h1 {
                text-align: center;
                margin-bottom: 20px;
                font-size: 24px;
                color: #333;
            }

            form {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            input, textarea, select {
                width: 100%;
                padding: 12px;
                border: 1px solid #ddd;
                border-radius: 6px;
                font-size: 16px;
            }

            textarea {
                resize: vertical;
            }

            .button {
                padding: 12px;
                background-color: #007bff;
                color: white;
                font-size: 16px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                width: 100%;
                text-align: center;
            }

            .button:hover {
                background-color: #0056b3;
            }

            .button:disabled {
                background-color: #cccccc;
                cursor: not-allowed;
            }

            .error-messages {
                color: red;
                list-style-type: none;
                padding: 0;
                margin-bottom: 15px;
            }

            /* File Upload Styles */
            .file-upload-container {
                border: 2px dashed #ddd;
                padding: 20px;
                border-radius: 6px;
                text-align: center;
                position: relative;
                transition: border-color 0.3s ease;
            }

            .file-upload-container.dragover {
                border-color: #007bff;
                background-color: rgba(0, 123, 255, 0.05);
            }

            .file-input-wrapper {
                position: relative;
                overflow: hidden;
                display: inline-block;
            }

            .file-input-wrapper input[type="file"] {
                position: absolute;
                left: 0;
                top: 0;
                opacity: 0;
                cursor: pointer;
                width: 100%;
                height: 100%;
            }

            .file-upload-button {
                display: inline-block;
                padding: 8px 16px;
                background-color: #007bff;
                color: white;
                border-radius: 4px;
                cursor: pointer;
                margin-bottom: 10px;
            }

            /* Loader Styles */
            .loader-container {
                display: none;
                position: relative;
                margin-top: 15px;
            }

            .loader-bar {
                height: 4px;
                background-color: #f0f0f0;
                border-radius: 2px;
                overflow: hidden;
            }

            .loader-progress {
                height: 100%;
                width: 0;
                background-color: #007bff;
                transition: width 0.3s ease;
            }

            .loader-text {
                text-align: center;
                margin-top: 8px;
                font-size: 14px;
                color: #666;
            }

            /* File Preview Styles */
            .file-preview {
                display: none;
                margin-top: 15px;
                padding: 10px;
                background-color: #f8f9fa;
                border-radius: 4px;
            }

            .file-preview-content {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .file-preview-icon {
                width: 40px;
                height: 40px;
                background-color: #e9ecef;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .file-preview-info {
                flex-grow: 1;
            }

            .file-preview-name {
                font-weight: bold;
                margin-bottom: 4px;
            }

            .file-preview-size {
                font-size: 12px;
                color: #666;
            }

            .file-preview-remove {
                color: #dc3545;
                cursor: pointer;
                padding: 4px 8px;
                border: none;
                background: none;
                font-size: 14px;
            }

            @media (max-width: 768px) {
                .container {
                    padding: 20px;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Create New Entry</h1>

            @if($errors->any())
                <ul class="error-messages">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('entries.store') }}" enctype="multipart/form-data" id="entryForm">
                @csrf
                <input type="text" name="title" placeholder="Entry Title" required>
                
                <textarea name="description" placeholder="Description" rows="4" required></textarea>
                
                <select name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <div class="file-upload-container" id="dropZone">
                    <div class="file-input-wrapper">
                        <div class="file-upload-button">Choose File</div>
                        <input type="file" name="attachment" id="fileInput" accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx">
                    </div>
                    <div class="upload-text">or drag and drop file here</div>
                    
                    <!-- File Preview -->
                    <div class="file-preview" id="filePreview">
                        <div class="file-preview-content">
                            <div class="file-preview-icon">📎</div>
                            <div class="file-preview-info">
                                <div class="file-preview-name"></div>
                                <div class="file-preview-size"></div>
                            </div>
                            <button type="button" class="file-preview-remove">✕</button>
                        </div>
                    </div>

                    <!-- Loader -->
                    <div class="loader-container" id="loaderContainer">
                        <div class="loader-bar">
                            <div class="loader-progress"></div>
                        </div>
                        <div class="loader-text">Uploading... <span class="upload-percentage">0%</span></div>
                    </div>
                </div>
                
                <button class="button" type="submit" id="submitButton">Submit</button>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropZone = document.getElementById('dropZone');
                const fileInput = document.getElementById('fileInput');
                const filePreview = document.getElementById('filePreview');
                const loaderContainer = document.getElementById('loaderContainer');
                const loaderProgress = document.querySelector('.loader-progress');
                const uploadPercentage = document.querySelector('.upload-percentage');
                const submitButton = document.getElementById('submitButton');
                const form = document.getElementById('entryForm');
    
                // Drag and drop handlers remain the same...
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });
    
                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
    
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, highlight, false);
                });
    
                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, unhighlight, false);
                });
    
                function highlight(e) {
                    dropZone.classList.add('dragover');
                }
    
                function unhighlight(e) {
                    dropZone.classList.remove('dragover');
                }
    
                dropZone.addEventListener('drop', handleDrop, false);
    
                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;
                    handleFiles(files);
                }
    
                fileInput.addEventListener('change', function(e) {
                    handleFiles(this.files);
                });
    
                function handleFiles(files) {
                    if (files.length > 0) {
                        const file = files[0];
                        updateFilePreview(file);
                        filePreview.style.display = 'block';
                    }
                }
    
                function updateFilePreview(file) {
                    const nameElement = filePreview.querySelector('.file-preview-name');
                    const sizeElement = filePreview.querySelector('.file-preview-size');
                    
                    nameElement.textContent = file.name;
                    sizeElement.textContent = formatFileSize(file.size);
                }
    
                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }
    
                // Remove file handler
                document.querySelector('.file-preview-remove').addEventListener('click', function() {
                    fileInput.value = '';
                    filePreview.style.display = 'none';
                    loaderContainer.style.display = 'none';
                    loaderProgress.style.width = '0%';
                    uploadPercentage.textContent = '0%';
                });
    
                // Updated form submission with real progress tracking
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    // Show loader only if there's a file
                    if (fileInput.files.length > 0) {
                        submitButton.disabled = true;
                        loaderContainer.style.display = 'block';
                        
                        try {
                            // Create FormData object
                            const formData = new FormData(form);
                            
                            // Create and configure XMLHttpRequest
                            const xhr = new XMLHttpRequest();
                            
                            // Setup upload progress handler
                            xhr.upload.onprogress = function(event) {
                                if (event.lengthComputable) {
                                    const percentComplete = (event.loaded / event.total) * 100;
                                    const progress = Math.round(percentComplete);
                                    loaderProgress.style.width = progress + '%';
                                    uploadPercentage.textContent = progress + '%';
                                }
                            };
    
                            // Setup completion handler
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    try {
                                        const response = JSON.parse(xhr.responseText);
                                        // Redirect using the URL in the response
                                        if (response.redirect) {
                                            window.location.href = response.redirect;
                                        } else {
                                            alert("Redirect URL not found.");
                                        }
                                    } catch (e) {
                                        console.error("Could not parse JSON response:", e);
                                        handleError("Upload failed: Invalid server response.");
                                    }
                                } else {
                                    handleError("Upload failed: " + xhr.statusText);
                                }
                            };

    
                            // Setup error handler
                            xhr.onerror = function() {
                                handleError('Upload failed: Network error');
                            };
    
                            // Initialize request
                            xhr.open('POST', form.action, true);
                            
                            // Set CSRF token
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                            
                            // Send the form data
                            xhr.send(formData);
    
                        } catch (error) {
                            handleError('Upload failed: ' + error.message);
                        }
                    } else {
                        // If no file, submit form normally
                        form.submit();
                    }
                });
    
                // Error handler
                function handleError(message) {
                    submitButton.disabled = false;
                    loaderContainer.style.display = 'none';
                    alert(message);
                }
    
                
            });
        </script>
    </body>
    </html>
</x-app-layout>