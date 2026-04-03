<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <a href="{{ route('contacts.index') }}" class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Contacts
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // =============================
            // 1️⃣ DELETE via AJAX
            // =============================
            document.querySelectorAll('.btn.delete').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const table = this.dataset.table;

                    if (confirm('Supprimer cet élément ?')) {
                        fetch(`/ajax/${table}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('tr').remove();
                                    alert('Supprimé avec succès!');
                                } else {
                                    alert('Erreur lors de la suppression');
                                }
                            });
                    }
                });
            });

            // =============================
            // 2️⃣ Toggle Status AJAX
            // =============================
            document.querySelectorAll('.status-toggle').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const table = this.dataset.table;
                    const el = this;

                    fetch(`/ajax/${table}/${id}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // تحديث النص
                                el.innerText = data.new_status_label;

                                // تحديث اللون
                                el.className = el.className
                                    .replace(/badge-(success|danger|warning)/g, '')
                                    .trim();
                                el.classList.add('badge-' + data.new_status_color);

                                // flash message بدون alert
                                showFlash('Status mis à jour : ' + data.new_status_label);
                            } else {
                                showFlash('Erreur lors du changement de status', 'error');
                            }
                        });
                });
            });

            // Flash message function
            function showFlash(message, type = 'success') {
                const existing = document.getElementById('ajax-flash');
                if (existing) existing.remove();

                const div = document.createElement('div');
                div.id = 'ajax-flash';
                div.className = `flash ${type}`;
                div.style.cssText = 'position:fixed; top:80px; right:20px; z-index:9999; min-width:250px;';
                div.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        ${message}
    `;
                document.body.appendChild(div);
                setTimeout(() => div.remove(), 3000);
            }

            // =============================
            // 3️⃣ Live Search
            // =============================
            // =============================
            // 3️⃣ Live Search
            // =============================
            document.querySelectorAll('.live-search').forEach(input => {
                let timeout = null;

                input.addEventListener('keyup', function () {
                    clearTimeout(timeout);
                    const table = this.dataset.table;
                    const query = this.value.trim();
                    const tbody = document.querySelector(`#${table}-table tbody`);
                    if (!tbody) return;

                    // إلا كانت فراغة — reload الصفحة
                    if (query === '') {
                        location.reload();
                        return;
                    }

                    // debounce 300ms
                    timeout = setTimeout(() => {
                        fetch(`/ajax/${table}/search?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                tbody.innerHTML = '';

                                if (data.length === 0) {
                                    const cols = tbody.closest('table').querySelectorAll('th').length;
                                    tbody.innerHTML = `<tr><td colspan="${cols}" style="text-align:center;padding:30px;color:var(--muted);">Aucun résultat</td></tr>`;
                                    return;
                                }

                                data.forEach(item => {
                                    tbody.innerHTML += buildRow(table, item);
                                });

                                // ربط events على الأزرار الجديدة
                                bindAjaxEvents(tbody);
                            });
                    }, 300);
                });
            });

            // ── Build Row حسب كل table ────────────────────────
            function buildRow(table, item) {
                const statusBtn = `
        <button class="status-toggle badge badge-${item.status_color}"
                data-id="${item.id}" data-table="${table}"
                style="cursor:pointer; border:none;">
            ${item.status_label}
        </button>`;

                const editBtn = `<a href="${item.edit_url}" class="btn edit"><i class="fas fa-edit"></i></a>`;
                const deleteBtn = `<button class="btn delete" data-id="${item.id}" data-table="${table}"><i class="fas fa-trash"></i></button>`;
                const actions = `<td class="actions">${editBtn}${deleteBtn}</td>`;

                if (table === 'formations') {
                    return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>-</td>
            <td>${item.category}</td>
            <td>${item.title_fr}</td>
            <td>${item.title_en}</td>
            <td>${item.duration}</td>
            <td>${item.price}</td>
            <td>${item.level}</td>
            <td>${statusBtn}</td>
            ${actions}
        </tr>`;
                }

                if (table === 'sessions') {
                    return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>${item.title_fr}</td>
            <td>${item.title_en}</td>
            <td>${item.formation}</td>
            <td>${item.formateur}</td>
            <td>${item.start_date}</td>
            <td>${item.end_date}</td>
            <td>${item.capacity}</td>
            <td>${item.mode}</td>
            <td>${item.city}</td>
            <td>-</td>
            <td>${statusBtn}</td>
            ${actions}
        </tr>`;
                }

                if (table === 'inscriptions') {
                    return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>${item.reference}</td>
            <td>${item.participant}</td>
            <td>${item.session}</td>
            <td>${statusBtn}</td>
            <td>${item.note}</td>
            <td>${item.confirmed_at}</td>
            <td>${item.cancelled_at}</td>
            ${actions}
        </tr>`;
                }
                if (table === 'blogs') {
                    const statusBtn = `
        <button class="status-toggle badge badge-${item.status_color}"
                data-id="${item.id}" data-table="${table}"
                style="cursor:pointer; border:none;">
            ${item.status_label}
        </button>`;
                    const editBtn = `<a href="${item.edit_url}" class="btn edit"><i class="fas fa-edit"></i></a>`;
                    const deleteBtn = `<button class="btn delete" data-id="${item.id}" data-table="${table}"><i class="fas fa-trash"></i></button>`;

                    return `<tr id="row-${item.id}">
        <td>${item.id}</td>
        <td>-</td>
        <td>${item.title_fr}</td>
        <td>${item.title_en}</td>
        <td>${item.category}</td>
        <td>${item.auteur}</td>
        <td>${statusBtn}</td>
        <td>${item.published_at}</td>
        <td class="actions">${editBtn}${deleteBtn}</td>
    </tr>`;
                }

                if (table === 'users') {
                    const activeBtn = `
        <button class="status-toggle badge badge-${item.status_color}"
                data-id="${item.id}" data-table="users"
                style="cursor:pointer; border:none;">
            ${item.is_active}
        </button>`;
                    const editBtn = `<a href="${item.edit_url}" class="btn edit"><i class="fas fa-edit"></i></a>`;
                    const deleteBtn = `<button class="btn delete" data-id="${item.id}" data-table="users"><i class="fas fa-trash"></i></button>`;

                    return `<tr id="row-${item.id}">
        <td>${item.id}</td>
        <td>${item.name}</td>
        <td>${item.email}</td>
        <td>${item.phone}</td>
        <td>${item.role}</td>
        <td>${item.language}</td>
        <td>${activeBtn}</td>
        <td class="actions">${editBtn}${deleteBtn}</td>
    </tr>`;
                }

                if (table === 'categories') {
                    const editBtn = `<a href="${item.edit_url}" class="btn edit"><i class="fas fa-edit"></i></a>`;
                    const deleteBtn = `<button class="btn delete" data-id="${item.id}" data-table="categories"><i class="fas fa-trash"></i></button>`;

                    return `<tr id="row-${item.id}">
        <td>${item.id}</td>
        <td>${item.name_fr}</td>
        <td>${item.name_en}</td>
        <td>${item.slug_fr}</td>
        <td>${item.slug_en}</td>
        <td class="actions">${editBtn}${deleteBtn}</td>
    </tr>`;
                }

                return '';
            }

            // ── Bind Events على rows جديدة ────────────────────
            function bindAjaxEvents(container) {
                // Delete
                container.querySelectorAll('.btn.delete').forEach(button => {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        const id = this.dataset.id;
                        const table = this.dataset.table;

                        if (confirm('Supprimer cet élément ?')) {
                            fetch(`/ajax/${table}/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        document.getElementById(`row-${id}`)?.remove();
                                        showFlash('Supprimé avec succès!');
                                    }
                                });
                        }
                    });
                });

                // Toggle Status
                container.querySelectorAll('.status-toggle').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const id = this.dataset.id;
                        const table = this.dataset.table;
                        const el = this;

                        fetch(`/ajax/${table}/${id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    el.innerText = data.new_status_label;
                                    el.className = el.className.replace(/badge-(success|danger|warning)/g, '').trim();
                                    el.classList.add('badge-' + data.new_status_color);
                                    showFlash('Status mis à jour : ' + data.new_status_label);
                                }
                            });
                    });
                });
            }
            const statusBtn = `
        <button class="status-toggle badge badge-${item.status_color}"
                data-id="${item.id}" data-table="${table}"
                style="cursor:pointer; border:none;">
            ${item.status_label}
        </button>`;

            const actions = `
        <td class="actions">
            <a href="/admin/${table}/${item.id}/edit" class="btn edit"><i class="fas fa-edit"></i></a>
            <button class="btn delete" data-id="${item.id}" data-table="${table}"><i class="fas fa-trash"></i></button>
        </td>`;

            if (table === 'formations') {
                return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>-</td>
            <td>-</td>
            <td>${item.session_title}</td>
            <td>${item.session_title}</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>${statusBtn}</td>
            ${actions}
        </tr>`;
            }

            if (table === 'sessions') {
                return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>${item.session_title}</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>${statusBtn}</td>
            ${actions}
        </tr>`;
            }

            if (table === 'inscriptions') {
                return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>${item.reference}</td>
            <td>${item.user_name}</td>
            <td>-</td>
            <td>${statusBtn}</td>
            <td>${item.note ?? '-'}</td>
            <td>${item.confirmed_at ?? '-'}</td>
            <td>${item.cancelled_at ?? '-'}</td>
            ${actions}
        </tr>`;
            }

            if (table === 'blogs') {
                return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>-</td>
            <td>${item.session_title}</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>${statusBtn}</td>
            <td>-</td>
            ${actions}
        </tr>`;
            }

            if (table === 'users') {
                return `<tr id="row-${item.id}">
            <td>${item.id}</td>
            <td>${item.user_name}</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>${statusBtn}</td>
            ${actions}
        </tr>`;
            }

            return '';
        }
        );
    </script>

</body>


</html>