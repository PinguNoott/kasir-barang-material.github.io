<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            color: #343a40;
            text-align: center;
            overflow: hidden; /* Prevent horizontal scroll */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .page {
            width: 80%;
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .page img {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }
        .h1404 {
            color: #dc3545;
            font-weight: bold;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .description {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .link {
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .link:hover {
            text-decoration: underline;
        }
        .icon {
            position: absolute;
            bottom: 70px; /* Position above the "Go back to Home" link */
            font-size: 48px;
            color: #6c757d;
            white-space: nowrap; /* Prevent icon from breaking to new line */
            animation: slide 4s linear infinite;
        }
        @keyframes slide {
            0% {
                transform: translateX(100vw); /* Start from outside the viewport on the right */
            }
            100% {
                transform: translateX(-100vw); /* Move to outside the viewport on the left */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page">
            <h1 class="h1404">404</h1>
            <p class="description">Oops! It looks like this page is not available. Perhaps it has been moved or removed.</p>
            <a href="<?=base_url('home/')?>" class="link">Go back to Home</a>
            <div class="icon">
                🛒
            </div>
        </div>
    </div>
</body>
</html>