<h1>Entries Report</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
            <tr>
                <td>{{ $entry->id }}</td>
                <td>{{ $entry->title }}</td>
                <td>{{ $entry->description }}</td>
                <td>{{ $entry->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>