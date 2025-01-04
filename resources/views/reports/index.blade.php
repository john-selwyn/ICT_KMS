<div class="container">
    <h1>Reports Dashboard</h1>
    <div>
        <h3>Summary</h3>
        <ul>
            <li>Approved Entries: {{ $approvedCount }}</li>
            <li>Pending Entries: {{ $pendingCount }}</li>
        </ul>
    </div>
    <div>
        <h3>Top Categories</h3>
        <ul>
            @foreach($topCategories as $category)
                <li>Category ID: {{ $category->categories }}, Total: {{ $category->total }}</li>
            @endforeach
        </ul>
    </div>
    <form method="POST" action="{{ route('reports.export') }}">
        @csrf
        <label for="format">Export Format:</label>
        <select name="format" id="format">
            <option value="xlsx">Excel</option>
            <option value="pdf">PDF</option>
        </select>
        <button type="submit" class="btn btn-primary">Export</button>
    </form>
</div>