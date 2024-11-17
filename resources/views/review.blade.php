<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Entries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .entry {
            background-color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        button {
            margin-top: 10px;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button.reject {
            background-color: #d9534f;
        }
    </style>
</head>
<body>
    <h1>Approve or Reject Entries</h1>
    <div class="entry">
        <h3>Entry Title: How to Setup Network</h3>
        <p>Description: Step-by-step guide to setting up a network.</p>
        <p>Category: Networking</p>
        <button onclick="approve()">Approve</button>
        <button class="reject" onclick="reject()">Reject</button>
    </div>

    <script>
        function approve() {
            alert('Entry Approved!');
        }

        function reject() {
            alert('Entry Rejected.');
        }
    </script>
</body>
</html>
