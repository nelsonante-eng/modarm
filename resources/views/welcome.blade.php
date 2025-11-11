<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RM Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('/images/bg-clothes.jpg') center/cover no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(2px);
        }

        .navbar {
            position: absolute;
            top: 20px;
            right: 40px;
            display: flex;
            gap: 12px;
        }

        .navbar a {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding: 6px 16px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ff5a1f;
            border-color: #ff5a1f;
        }

        .logo {
            position: relative;
            z-index: 1;
            background-color: #e74c3c;
            color: white;
            font-size: 80px;
            font-weight: bold;
            padding: 50px 80px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            animation: fadeIn 1.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="navbar">
        <a href="{{ route('login') }}">Log in</a>
        <a href="{{ route('register') }}">Register</a>
    </div>

    <div class="logo">RM</div>
</body>
</html>
