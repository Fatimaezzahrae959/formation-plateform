<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — FormationPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg: #0d0f14;
            --sidebar: #111318;
            --card: #181b22;
            --border: #252830;
            --accent: #6c63ff;
            --accent2: #00d4ff;
            --success: #00e5a0;
            --danger: #ff4560;
            --warning: #ffb800;
            --text: #e8eaf0;
            --muted: #6b7280;
            --navbar-h: 64px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-h);
            background: var(--sidebar);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 100;
        }

        .navbar-brand {
            font-family: 'Space Mono', monospace;
            font-size: 18px;
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand span {
            color: var(--accent2);
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 50px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
        }

        .user-role {
            font-size: 11px;
            color: var(--muted);
        }

        .btn-logout {
            padding: 8px 16px;
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: var(--danger);
            color: white;
        }

        /* MAIN */
        .main {
            margin-top: var(--navbar-h);
            padding: 30px;
        }

        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
        }

        .stat-link {
            font-size: 12px;
            color: var(--muted);
            text-decoration: none;
        }

        /* SECTION */
        .section-title {
            font-family: 'Space Mono', monospace;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 20px;
            background: linear-gradient(var(--accent), var(--accent2));
            border-radius: 4px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            font-size: 14px;
        }

        thead {
            background: linear-gradient(135deg, #1a1d26, #22263a);
        }

        th {
            padding: 13px 16px;
            text-align: left;
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        tbody tr:hover {
            background: rgba(108, 99, 255, 0.05);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* BADGE */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(0, 229, 160, 0.1);
            color: var(--success);
        }

        .badge-danger {
            background: rgba(255, 69, 96, 0.12);
            color: var(--danger);
        }

        .badge-warning {
            background: rgba(255, 184, 0, 0.12);
            color: var(--warning);
        }

        /* WELCOME CARD */
        .welcome-card {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 14px;
            padding: 28px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-card h2 {
            font-family: 'Space Mono', monospace;
            font-size: 20px;
            color: white;
            margin-bottom: 6px;
        }

        .welcome-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .welcome-avatar {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: white;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <i class="fas fa-graduation-cap"></i>
            Formation<span>Pro</span>
        </a>
        <div class="navbar-right">
            @auth
                <div class="user-info">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ auth()->user()->role }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="main">
        @yield('content')
    </div>

</body>

</html>