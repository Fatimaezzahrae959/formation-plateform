<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Admin</title>
    <meta name="description" content="{{ isset($model) ? $model->getMetaDesc() : '' }}">
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
            --sidebar-w: 240px;
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
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
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
            letter-spacing: 1px;
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
            color: var(--text);
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
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background: var(--danger);
            color: white;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: var(--navbar-h);
            left: 0;
            width: var(--sidebar-w);
            height: calc(100vh - var(--navbar-h));
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            overflow-y: auto;
            padding: 20px 0;
            z-index: 90;
        }

        .sidebar-section {
            padding: 8px 16px 4px;
            font-size: 10px;
            font-family: 'Space Mono', monospace;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            margin: 2px 0;
        }

        .sidebar a:hover,
        .sidebar a.active {
            color: var(--text);
            background: rgba(108, 99, 255, 0.08);
            border-left-color: var(--accent);
        }

        .sidebar a i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar a:hover i {
            color: var(--accent);
        }

        /* ── MAIN ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            margin-top: var(--navbar-h);
            padding: 30px;
            min-height: calc(100vh - var(--navbar-h));
        }

        /* ── FLASH MESSAGES ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            animation: slideDown 0.4s ease;
            position: relative;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .flash.success {
            background: rgba(0, 229, 160, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .flash.error {
            background: rgba(255, 69, 96, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .flash-close {
            position: absolute;
            right: 14px;
            cursor: pointer;
            opacity: 0.6;
            background: none;
            border: none;
            color: inherit;
            font-size: 16px;
        }

        .flash-close:hover {
            opacity: 1;
        }

        /* ── TITLES ── */
        h2.title {
            font-family: 'Space Mono', monospace;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 24px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2.title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 24px;
            background: linear-gradient(var(--accent), var(--accent2));
            border-radius: 4px;
        }

        /* ── BUTTONS ── */
        a.btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: white;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }

        a.btn-add:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        .actions .btn {
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            margin: 2px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn.edit {
            background: rgba(108, 99, 255, 0.15);
            color: var(--accent);
            border: 1px solid rgba(108, 99, 255, 0.3);
            text-decoration: none;
        }

        .btn.edit:hover {
            background: var(--accent);
            color: white;
        }

        .btn.delete {
            background: rgba(255, 69, 96, 0.12);
            color: var(--danger);
            border: 1px solid rgba(255, 69, 96, 0.3);
        }

        .btn.delete:hover {
            background: var(--danger);
            color: white;
        }

        /* ── TABLE ── */
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            font-size: 14px;
        }

        table thead {
            background: linear-gradient(135deg, #1a1d26, #22263a);
        }

        th {
            padding: 14px 16px;
            text-align: left;
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: rgba(108, 99, 255, 0.05);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── FORM ── */
        .form-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 30px;
            max-width: 700px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 11px 14px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.2s;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        button.submit {
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        button.submit:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        .error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
        }

        .alert-errors {
            background: rgba(255, 69, 96, 0.08);
            border: 1px solid var(--danger);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            color: var(--danger);
            font-size: 13px;
        }

        .alert-errors ul {
            padding-left: 18px;
        }

        .alert-errors li {
            margin-bottom: 4px;
        }

        /* ── BADGES ── */
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

        /* ── PAGINATION ── */
        .pagination {
            display: flex;
            gap: 6px;
            margin-top: 20px;
            justify-content: center;
        }

        .pagination a,
        .pagination span {
            padding: 7px 13px;
            border-radius: 8px;
            font-size: 13px;
            border: 1px solid var(--border);
            color: var(--muted);
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination a:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .pagination .active span {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <i class="fas fa-graduation-cap"></i>
            Formation<span>Pro</span>
        </a>
        {{-- Language Switcher --}}
        <div style="display:flex; align-items:center; gap:6px;">
            <a href="{{ route('lang.switch', 'fr') }}" style="padding:5px 10px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;
              background:{{ app()->getLocale() == 'fr' ? 'var(--accent)' : 'var(--card)' }};
              color:{{ app()->getLocale() == 'fr' ? 'white' : 'var(--muted)' }};
              border:1px solid {{ app()->getLocale() == 'fr' ? 'var(--accent)' : 'var(--border)' }};">
                FR
            </a>
            <a href="{{ route('lang.switch', 'en') }}" style="padding:5px 10px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;
              background:{{ app()->getLocale() == 'en' ? 'var(--accent)' : 'var(--card)' }};
              color:{{ app()->getLocale() == 'en' ? 'white' : 'var(--muted)' }};
              border:1px solid {{ app()->getLocale() == 'en' ? 'var(--accent)' : 'var(--border)' }};">
                EN
            </a>
        </div>
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

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-section">Menu Principal</div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="sidebar-section">Gestion</div>

        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Catégories
        </a>

        <a href="{{ route('formations.index') }}" class="{{ request()->routeIs('formations.*') ? 'active' : '' }}">
            <i class="fas fa-book-open"></i> Formations
        </a>

        <a href="{{ route('sessions.index') }}" class="{{ request()->routeIs('sessions.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Sessions
        </a>

        <a href="{{ route('inscriptions.index') }}" class="{{ request()->routeIs('inscriptions.*') ? 'active' : '' }}">
            <i class="fas fa-user-check"></i> Inscriptions
        </a>

        <div class="sidebar-section">Contenu</div>

        <a href="{{ route('blogs.index') }}" class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">
            <i class="fas fa-rss"></i> Blog
        </a>

        <div class="sidebar-section">Administration</div>

        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Utilisateurs
        </a>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="main-wrapper">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flash success" id="flash-msg">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button class="flash-close" onclick="document.getElementById('flash-msg').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="flash error" id="flash-msg-err">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
                <button class="flash-close" onclick="document.getElementById('flash-msg-err').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Auto-close flash after 4s --}}
    <script>
        setTimeout(() => {
            document.getElementById('flash-msg')?.remove();
            document.getElementById('flash-msg-err')?.remove();
        }, 4000);
    </script>

</body>

</html>