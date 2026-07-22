<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #c9a227;
        }
        .header img {
            max-width: 200px;
        }
        .content {
            padding: 30px 0;
            white-space: pre-line;
        }
        .footer {
            border-top: 1px solid #eee;
            padding-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('assets/paradise/img/logo.png') }}" alt="Alexandar Palace Hotel">
    </div>
    
    <div class="content">
        {!! nl2br(e($body)) !!}
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Alexandar Palace Hotel. All rights reserved.</p>
    </div>
</body>
</html>
