<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .item-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 30px;
            margin: 40px auto;
            max-width: 800px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .item-header {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .item-section {
            padding: 20px;
            background-color: #f0f4f8;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 500;
            color: #555;
        }

        .item-section .label {
            font-weight: bold;
            color: #333;
        }

        .attachment-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #eef2f7;
            margin-top: 20px;
        }

        .attachment-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .attachment-container a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 15px;
        }

        .attachment-container a:hover {
            background-color: #0056b3;
        }

        .no-attachment {
            color: #999;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="item-container">
        <div class="item-header">{{ $item->title }}</div>



        <div class="item-section">
            <span class="label">Description:</span> {{ $item->description }}
        </div>

        <div class="item-section">
            <span class="label">Attachment:</span>
            <div class="attachment-container">
                @if ($item->attachment)
                                @php
                                    $fileExtension = pathinfo($item->attachment, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ Storage::url($item->attachment) }}" alt="Attachment Image">
                                @elseif (in_array($fileExtension, ['pdf', 'doc', 'docx', 'xls', 'xlsx']))
                                    <a href="{{ Storage::url($item->attachment) }}" target="_blank">Download Attachment</a>
                                @else
                                    <a href="{{ Storage::url($item->attachment) }}" target="_blank">View/Download Attachment</a>
                                @endif
                @else
                    <span class="no-attachment">No Attachment</span>
                @endif
            </div>
        </div>
    </div>

</body>

</html>