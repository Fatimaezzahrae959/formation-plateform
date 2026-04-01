<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — FormationPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg: #07090f;
            --surface: #0d1117;
            --card: #111827;
            --border: #1e2736;
            --accent: #3b82f6;
            --accent2: #06b6d4;
            --danger: #ef4444;
            --text: #f1f5f9;
            --muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Background grid effect */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        /* Glow blob */
        body::after {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.06) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            position: relative;
            z-index: 10;
            animation: fadeUp 0.5s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Brand */
        .auth-brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
            text-decoration: none;
            letter-spacing: -0.3px;
        }

        .brand-dot {
            width: 9px;
            height: 9px;
            background: var(--accent);
            border-radius: 50%;
            box-shadow: 0 0 12px var(--accent);
        }

        .auth-brand-logo em {
            font-style: normal;
            color: var(--accent);
        }

        .auth-brand p {
            color: var(--muted);
            font-size: 13px;
            margin-top: 6px;
        }

        /* Card */
        .auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px;
        }

        .auth-title {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .auth-subtitle {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 24px;
        }

        /* Form */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 14px;
        }

        .input-wrap input {
            width: 100%;
            padding: 11px 13px 11px 38px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-wrap input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .input-wrap input::placeholder {
            color: var(--muted);
        }

        /* Submit button */
        button[type="submit"] {
            width: 100%;
            padding: 11px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button[type="submit"]:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
        }

        /* Links */
        .auth-links {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: var(--muted);
        }

        .auth-links a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        /* Errors */
        .error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .alert-errors {
            background: rgba(239, 68, 68, 0.07);
            border: 1px solid rgba(239, 68, 68, 0.25);
            border-radius: 9px;
            padding: 12px 16px;
            margin-bottom: 18px;
            color: var(--danger);
            font-size: 13px;
        }

        .alert-errors ul {
            padding-left: 16px;
        }

        .alert-errors li {
            margin-bottom: 3px;
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: var(--muted);
            font-size: 12px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
    </style>
</head>

<body>

    <div class="auth-wrapper">

        <div class="auth-brand">
            <a href="/" class="auth-brand-logo">
                <div class="brand-dot"></div>
                Formation<em>Pro</em>
            </a>
            <p>Plateforme de gestion des formations</p>
        </div>

        <div class="auth-card">
            @yield('content')
        </div>

        <div class="auth-links" style="margin-top: 16px;">
            @yield('auth-links')
        </div>

    </div>

</body>

</html>