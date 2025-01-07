<x-app-layout>
    <style>
        .faq-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .btn-primary {
            background-color: #4299e1;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #3182ce;
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.4);
        }

        .form-control.is-invalid {
            border-color: #e53e3e;
        }

        .invalid-feedback {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>

    <div class="faq-container">
        <h1>Create FAQ</h1>
        <form action="{{ route('faqs.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" name="question" id="question" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea name="answer" id="answer" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</x-app-layout>