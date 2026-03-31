<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg: #f0f4ff;
            --card: #ffffff;
            --text: #333;
            --primary: #4facfe;
        }

        body.dark {
            --bg: #121212;
            --card: #1e1e1e;
            --text: #fff;
        }

        body {
            height: 100vh;
            background: var(--bg);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.3s;
            font-family: Arial;
        }

        .auth-container {
            background: var(--card);
            padding: 30px;
            border-radius: 20px;
            width: 430px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--text);
        }

        .input-group {
            position: relative;
            margin: 10px 0;
        }

        .input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: gray;
        }

        .input-group input {
            width: 88%;
            padding: 10px 10px 10px 30px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #007bff;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: bold;
        }

        .toggle-dark {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 20px;
        }

        .error {
            color: red;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="toggle-dark" onclick="toggleDark()">
        <i class="fas fa-moon"></i>
    </div>

    <div class="auth-container">
        @yield('content')
    </div>

    <script>
        function toggleDark() {
            document.body.classList.toggle('dark');
        }
    </script>

</body>

</html>