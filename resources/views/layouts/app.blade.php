<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4facfe;
            --success: #43e97b;
            --danger: #ff4d4d;
            --bg: #f0f4ff;
            --card: #fff;
            --text: #333;
            --table-header: linear-gradient(45deg, #4facfe, #00f2fe);
            --table-row: #f9f9f9;
            --table-row-hover: #e0f7fa;
            --input-bg: #fff;
            --input-border: #ccc;
        }

        body.dark {
            --bg: #121212;
            --card: #1e1e1e;
            --text: #fff;
            --table-header: linear-gradient(45deg, #000000, #2c2b2b);
            --table-row: #1e1e1e;
            --table-row-hover: #333;
            --input-bg: #1e1e1e;
            --input-border: #555;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: var(--bg);
            color: var(--text);
            transition: 0.3s;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .toggle-dark {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 22px;
            z-index: 100;
        }

        h2.title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        a.btn-add {
            display: inline-block;
            margin-bottom: 20px;
            padding: 12px 25px;
            background: linear-gradient(45deg, #43e97b, #38f9d7);
            color: white;
            border-radius: 12px;
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s;
        }

        a.btn-add i {
            margin-right: 8px;
        }

        a.btn-add:hover {
            transform: scale(1.05);
        }

        /* table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            background: var(--card);
            border-radius: 12px;
            overflow: hidden;
        }

        table thead {
            background: var(--table-header);
            color: white;
        }

        th,
        td {
            padding: 18px 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            transition: 0.3s;
        }

        tbody tr {
            background: var(--table-row);
            transition: 0.3s;
        }

        tbody tr:hover {
            background: var(--table-row-hover);
            transform: scale(1.02);
        }

        /* action buttons */
        .actions .btn {
            border: none;
            padding: 10px 18px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 15px;
            margin: 2px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn.edit {
            background: var(--primary);
            color: white;
        }

        .btn.edit:hover {
            background: #007bff;
        }

        .btn.delete {
            background: var(--danger);
            color: white;
        }

        .btn.delete:hover {
            background: #cc0000;
        }

        /* form inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            color: var(--text);
            font-size: 16px;
            transition: 0.3s;
        }

        button.submit {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            background: var(--primary);
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button.submit:hover {
            background: #007bff;
            transform: scale(1.05);
        }

        .success {
            color: var(--success);
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            color: var(--danger);
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="toggle-dark" onclick="document.body.classList.toggle('dark')">
        <i class="fas fa-moon"></i>
    </div>

    <div class="container">
        @yield('content')
    </div>

</body>

</html>