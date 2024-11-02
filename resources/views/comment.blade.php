<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .comment-section {
            max-width: 600px;
            margin: 0 auto;
        }
        .comment {
            background-color: white;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            width: 100%;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>Comments</h1>
    <div class="comment-section">
        <div class="comment">
            <p><strong>John Doe:</strong> Great entry! Really helpful.</p>
        </div>
        <form id="commentForm">
            <input type="text" placeholder="Your Name" required>
            <textarea placeholder="Your Comment" required></textarea>
            <button type="submit">Submit Comment</button>
        </form>
    </div>

    <script>
        document.getElementById('commentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Comment Submitted!');
        });
    </script>
</body>
</html>
