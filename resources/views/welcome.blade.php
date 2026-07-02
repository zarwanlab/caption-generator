<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Instagram Caption Generator') }}</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Inter, system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc, #eef6ff);
            color: #0f172a;
        }
        .card {
            max-width: 40rem;
            padding: 2rem;
            border-radius: 1.5rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            box-shadow: 0 24px 60px -28px rgba(13, 71, 161, 0.24);
            text-align: center;
        }
        a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.9rem 1.4rem;
            border-radius: 999px;
            background: #0d47a1;
            color: white;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Instagram Caption Generator</h1>
        <p>This project now runs as a single-page Laravel app with raw HTML, CSS, and JavaScript.</p>
        <a href="/">Open the tool</a>
    </div>
</body>
</html>
