<!DOCTYPE html>
<html>

<head>
  <style>
    .entry-detail {
      max-width: 800px;
      margin: 2rem auto;
      padding: 2.5rem;
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .entry-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .entry-icon {
      background: #f0f7ff;
      padding: 1rem;
      border-radius: 12px;
      color: #3b82f6;
    }

    .entry-title {
      font-size: 2rem;
      color: #1a1a1a;
      margin-bottom: 0.5rem;
      font-weight: 600;
      line-height: 1.2;
    }

    .entry-meta {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }

    .entry-category {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: #f3f4f6;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      color: #4b5563;
      font-size: 0.9rem;
      transition: all 0.2s;
    }

    .entry-category:hover {
      background: #e5e7eb;
    }

    .entry-date {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      color: #6b7280;
      font-size: 0.9rem;
    }

    .entry-description {
      font-size: 1.1rem;
      line-height: 1.7;
      color: #4b5563;
      margin-bottom: 2.5rem;
      padding-bottom: 2rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .entry-attachments {
      display: flex;
      gap: 1rem;
      margin-bottom: 2.5rem;
    }

    .attachment-link {
      display: inline-flex;
      align-items: center;
      gap: 0.75rem;
      background: #3b82f6;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.2s;
      font-weight: 500;
    }

    .attachment-link:hover {
      background: #2563eb;
      transform: translateY(-1px);
    }

    .attachment-icon {
      width: 20px;
      height: 20px;
    }

    .btn-back {
      display: inline-flex;
      align-items: center;
      gap: 0.75rem;
      background: #f3f4f6;
      color: #374151;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.2s;
      font-weight: 500;
    }

    .btn-back:hover {
      background: #e5e7eb;
    }

    .video-container {
      position: relative;
      padding-bottom: 56.25%;
      height: 0;
      overflow: hidden;
      max-width: 100%;
      margin-bottom: 2.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .video-container iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 12px;
    }

    @media (max-width: 768px) {
      .entry-detail {
        margin: 1rem;
        padding: 1.5rem;
      }

      .entry-title {
        font-size: 1.75rem;
      }

      .entry-description {
        font-size: 1rem;
      }

      .entry-attachments {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <x-app-layout>
    <div class="entry-detail">
      <div class="entry-header">
        <div class="entry-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
        </div>
        <div>
          <h1 class="entry-title">{{ $entry->title }}</h1>
          <div class="entry-meta">
            <span class="entry-category">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
              </svg>
              {{ $entry->category->name ?? 'No Category' }}
            </span>
            <span class="entry-date">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              {{ $entry->created_at->format('M d, Y') }}
            </span>
          </div>
        </div>
      </div>

      <p class="entry-description">{{ $entry->description }}</p>

      <div class="entry-attachments">
        @if($entry->approve_attachments->isNotEmpty())
      @foreach ($entry->approve_attachments as $attachment)
      <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="attachment-link">
      <svg class="attachment-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
      <polyline points="7 10 12 15 17 10"></polyline>
      <line x1="12" y1="15" x2="12" y2="3"></line>
      </svg>
      <p>{{ $attachment->original_name }}</p>

      </a>
    @endforeach
    @else
    <p>No attachments available.</p>
  @endif
        <!--
        <a href="{{ route('entries.approves') }}" class="btn-back">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          Back to Entries
        </a>
         -->
      </div>

      @if(!empty($entry->youtube_url))
        <div class="entry-youtube">
        @php
        $url = trim($entry->youtube_url);

        function getYoutubeId($url)
        {
        if (strpos($url, 'youtu.be/') !== false) {
        return substr(parse_url($url, PHP_URL_PATH), 1);
        }
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        return $params['v'] ?? null;
        }

        $videoId = getYoutubeId($url);
    @endphp

        @if($videoId)
      <div class="video-container">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>
        </iframe>
      </div>
    @endif
        </div>
    @endif
      <a href="{{ route('entries.approves') }}" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back to Entries
      </a>
    </div>
  </x-app-layout>
</body>

</html>