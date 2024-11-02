<x-app-layout>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        butt {
            padding: 10px;
            width: 100%;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        butt:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>Edit Entry</h1>

    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
    </ul>

    @endif

    
    <form method="POST" id="entryForm" action="{{route('entries.update', ['entries' => $entries])}}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="text" name="title" placeholder="Entry Title" value="{{$entries->title}}">
        <textarea name="description"  > {{$entries->description}}</textarea>
        <select name="category">
            <option value="Network" {{ $entries->category == 'Network' ? 'selected' : '' }}>Network</option>
            <option value="Hardware" {{ $entries->category == 'Hardware' ? 'selected' : '' }} >Hardware</option>
        </select>
        
        <input type="file" name="attachment" accept="image/*, video/*">
        @if ($entries->attachment)
        <p>Current file: {{ basename($entries->attachment) }}</p>
    @endif
        <button class="butt" type="submit">Update</button>
    </form>

    
</body>
</html>

</x-app-layout>