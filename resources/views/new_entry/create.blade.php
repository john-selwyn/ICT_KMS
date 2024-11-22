<!-- resources/views/new_entry/create.blade.php -->
<x-app-layout>
    <!-- resources/views/entries/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Entry</title>
    <script>
        function addContent(type) {
            const container = document.getElementById('contents');
            const contentDiv = document.createElement('div');
            contentDiv.classList.add('content-item');

            if (type === 'text') {
                contentDiv.innerHTML = `
                    <label>Text Content:</label>
                    <input type="text" name="contents[][text]" required>
                    <input type="hidden" name="contents[][type]" value="text">
                `;
            } else if (type === 'image' || type === 'attachment') {
                contentDiv.innerHTML = `
                    <label>${type === 'image' ? 'Image' : 'Attachment'}:</label>
                    <input type="file" name="contents[][file]" accept="${type === 'image' ? 'image/*' : '*'}" required>
                    <input type="hidden" name="contents[][type]" value="${type}">
                `;
            }

            container.appendChild(contentDiv);
        }
    </script>
</head>
<body>
    <h1>Create Entry</h1>

    @if(session()->has('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('new_entry.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Title" required>
        
        <div id="content-wrapper">
            <!-- Content fields will be added here dynamically -->
        </div>
    
        <button type="button" onclick="addText()">Add Text</button>
        <button type="button" onclick="addImage()">Add Image</button>
        <button type="button" onclick="addAttachment()">Add Attachment</button>
    
        <button type="submit">Submit</button>
    </form>
    
    <script>
        function addText() {
            const wrapper = document.getElementById('content-wrapper');
            const div = document.createElement('div');
            div.innerHTML = `
                <input type="hidden" name="contents[][type]" value="text">
                <input type="text" name="contents[][text]" placeholder="Enter text content">
            `;
            wrapper.appendChild(div);
        }
    
        function addImage() {
            const wrapper = document.getElementById('content-wrapper');
            const div = document.createElement('div');
            div.innerHTML = `
                <input type="hidden" name="contents[][type]" value="image">
                <input type="file" name="contents[][file]" accept="image/*">
            `;
            wrapper.appendChild(div);
        }
    
        function addAttachment() {
            const wrapper = document.getElementById('content-wrapper');
            const div = document.createElement('div');
            div.innerHTML = `
                <input type="hidden" name="contents[][type]" value="attachment">
                <input type="file" name="contents[][file]" accept=".pdf,.doc,.docx">
            `;
            wrapper.appendChild(div);
        }
    </script>
    
</body>
</html>

</x-app-layout>
