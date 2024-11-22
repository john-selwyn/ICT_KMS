<x-app-layout>




    <div class="container">
        <h1 class="mt-4">Entries</h1>

        <!-- Loop through each entry -->
        @foreach ($entries as $entry)
            <div class="entry mt-5 p-4 border rounded">
                <h2>{{ $entry->title }}</h2>

                <!-- Loop through each content item associated with this entry -->
                <div class="contents mt-3">
                    @foreach ($entry->contents as $content)
                        <div class="content-item mb-3">
                            @if ($content->content_type === 'text')
                                <!-- Display text content -->
                                <p>{{ $content->content_text }}</p>
                            @elseif ($content->content_type === 'image')
                                <!-- Display image content -->
                                <img src="{{ asset('storage/' . $content->content_url) }}" alt="Image Content" style="max-width: 200px;">
                            @elseif ($content->content_type === 'attachment')
                                <!-- Display attachment as a downloadable link -->
                                <a href="{{ asset('storage/' . $content->content_url) }}" target="_blank" class="btn btn-primary">Download Attachment</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>