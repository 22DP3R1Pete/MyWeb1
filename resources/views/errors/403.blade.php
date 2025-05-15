<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Access Denied</title>
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            background-color: #f9fafb;
            color: #1f2937;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .error-container {
            text-align: center;
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            max-width: 32rem;
            width: 100%;
        }
        
        .error-code {
            font-size: 5rem;
            font-weight: bold;
            color: #ef4444;
            margin: 0;
        }
        
        .error-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 1rem 0;
        }
        
        .error-message {
            color: #6b7280;
            margin-bottom: 2rem;
        }
        
        .back-button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        
        .back-button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Access Denied</h2>
        <p class="error-message">{{ $exception->getMessage() ?: 'Sorry, you do not have permission to access this page.' }}</p>
        <a href="{{ route('dashboard') }}" class="back-button">Return to Dashboard</a>
    </div>
</body>
</html> 