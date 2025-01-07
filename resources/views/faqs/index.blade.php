<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FAQs</title>
        <style>
            .faq-container {
                max-width: 1200px;
                margin: 50px auto;
                padding: 0 20px;
            }

            .page-title {
                text-align: center;
                color: #333;
                margin-bottom: 2rem;
                font-size: 1.875rem;
            }

            .create-button-container {
                text-align: right;
                margin-bottom: 1.25rem;
            }

            .create-button {
                background-color: #2563eb;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                text-decoration: none;
                font-weight: 500;
                display: inline-block;
            }

            .create-button:hover {
                background-color: #1d4ed8;
            }

            .faq-item {
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                margin-bottom: 1rem;
                background: white;
            }

            .faq-question {
                width: 100%;
                padding: 1rem;
                text-align: left;
                background: none;
                border: none;
                font-weight: 500;
                color: #2563eb;
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .faq-question::after {
                content: '+';
                font-size: 1.5rem;
                margin-left: 0.5rem;
            }

            .faq-question[aria-expanded="true"]::after {
                content: '-';
            }

            .faq-answer {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
                padding: 0 1rem;
            }

            .faq-answer.active {
                max-height: 500px;
                padding: 1rem;
                border-top: 1px solid #e5e7eb;
            }

            .admin-buttons {
                padding: 1rem;
                display: flex;
                gap: 0.5rem;
                border-top: 1px solid #e5e7eb;
            }

            .edit-button {
                background-color: #f59e0b;
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 0.25rem;
                text-decoration: none;
                font-size: 0.875rem;
            }

            .delete-button {
                background-color: #dc2626;
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 0.25rem;
                border: none;
                font-size: 0.875rem;
                cursor: pointer;
            }

            .edit-button:hover {
                background-color: #d97706;
            }

            .delete-button:hover {
                background-color: #b91c1c;
            }
        </style>
    </head>

    <body>
        <div class="faq-container">
            <h2 class="page-title">Frequently Asked Questions</h2>

            @if(auth()->user()->role === 'admin')
                <div class="create-button-container">
                    <a href="{{ route('faqs.create') }}" class="create-button">Add New FAQ</a>
                </div>
            @endif

            <div class="faq-list">
                @foreach($faqs as $faq)
                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFaq(this)" aria-expanded="false">
                            {{ $faq->question }}
                        </button>
                        <div class="faq-answer">
                            {{ $faq->answer }}
                        </div>
                        @if(auth()->user()->role === 'admin')
                            <div class="admin-buttons">
                                <a href="{{ route('faqs.edit', $faq->id) }}" class="edit-button">Edit</a>
                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            function toggleFaq(button) {
                const answer = button.nextElementSibling;
                const isExpanded = button.getAttribute('aria-expanded') === 'true';

                button.setAttribute('aria-expanded', !isExpanded);
                answer.classList.toggle('active');
            }
        </script>
    </body>

    </html>
</x-app-layout>