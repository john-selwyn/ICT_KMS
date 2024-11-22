<x-app-layout>
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            /* Modern CSS Reset */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
    
            /* Main Container */
            .container {
                max-width: 800px;
                margin: 2rem auto;
                padding: 2rem;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
    
            /* Form Styles */
            form {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }
    
            /* Label Styles */
            label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 600;
                color: #374151;
                font-size: 0.875rem;
            }
    
            /* Input Styles */
            input[type="text"],
            input[type="url"],
            textarea {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #d1d5db;
                border-radius: 4px;
                font-size: 1rem;
                transition: border-color 0.2s;
            }
    
            input[type="text"]:focus,
            input[type="url"]:focus,
            textarea:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
    
            /* Textarea Specific Styles */
            textarea {
                min-height: 120px;
                resize: vertical;
            }
    
            /* File Input Styles */
            input[type="file"] {
                display: block;
                width: 100%;
                padding: 0.75rem;
                border: 2px dashed #d1d5db;
                border-radius: 4px;
                background-color: #f9fafb;
                cursor: pointer;
            }
    
            input[type="file"]:hover {
                border-color: #3b82f6;
            }
    
            /* Button Styles */
            button[type="submit"] {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background-color: #3b82f6;
                color: white;
                border: none;
                border-radius: 4px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.2s;
            }
    
            button[type="submit"]:hover {
                background-color: #2563eb;
            }
    
            /* Form Group Styles */
            .form-group {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
    
            /* Error States */
            input:invalid,
            textarea:invalid {
                border-color: #ef4444;
            }
    
            /* Responsive Design */
            @media (max-width: 640px) {
                .container {
                    margin: 1rem;
                    padding: 1rem;
                }
            }
        </style>
    </head>
    <body>
    
            <div class="container">
                <form method="POST" action="{{ route('entriess.update', $entry->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
    
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $entry->title) }}" required>
                    </div>
    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description">{{ old('description', $entry->description) }}</textarea>
                    </div>
    
                    <div class="form-group">
                        <label for="attachment">Attachment</label>
                        
                        @if($entry->attachment)
                            <div class="current-file">
                                Current file: <a href="{{ asset('storage/' . $entry->attachment) }}" target="_blank">
                                    {{ basename($entry->attachment) }}
                                </a>
                            </div>
                        @endif
                        
                        <div class="file-input-wrapper">
                            <input type="file" name="attachment" id="attachment">
                            <p class="file-note">Select a new file to replace the current one</p>
                        </div>
                    </div>
    
                    <div class="form-group">
                        <label for="youtube_url">YouTube URL</label>
                        <input 
                            type="url" 
                            name="youtube_url" 
                            id="youtube_url" 
                            placeholder="https://youtube.com/..." 
                            value="{{ old('youtube_url', $entry->youtube_url ?? '') }}"
                        >
                    </div>
    
                    <button type="submit">Update Entry</button>
                </form>
            </div>
        </x-app-layout>
    </body>
    </html>

