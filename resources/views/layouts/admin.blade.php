<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') — Mueblería</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-primary: #0f0f14;
            --bg-secondary: #1a1a24;
            --bg-card: #22222e;
            --bg-hover: #2a2a38;
            --accent: #c8956c;
            --accent-light: #e0b08e;
            --accent-glow: rgba(200,149,108,.25);
            --text-primary: #f0ede8;
            --text-secondary: #9a9aae;
            --text-muted: #6b6b80;
            --border: #2e2e3e;
            --success: #4ade80;
            --warning: #fbbf24;
            --danger: #f87171;
            --info: #60a5fa;
            --sidebar-w: 260px;
            --radius: 12px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-secondary);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s;
        }
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--accent), #a06838);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #fff;
        }
        .sidebar-brand h2 {
            font-size: 18px; font-weight: 700;
            background: linear-gradient(135deg, var(--accent-light), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .sidebar-brand small { display: block; font-size: 11px; color: var(--text-muted); font-weight: 400; }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-section { margin-bottom: 20px; }
        .nav-section-title {
            font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px;
            color: var(--text-muted); padding: 0 8px; margin-bottom: 8px; font-weight: 600;
        }
        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 8px;
            color: var(--text-secondary); text-decoration: none;
            font-size: 14px; font-weight: 500;
            transition: all .2s;
        }
        .nav-link:hover { background: var(--bg-hover); color: var(--text-primary); }
        .nav-link.active {
            background: linear-gradient(135deg, rgba(200,149,108,.15), rgba(200,149,108,.05));
            color: var(--accent-light);
            border: 1px solid rgba(200,149,108,.2);
        }
        .nav-link i { width: 20px; text-align: center; font-size: 15px; }
        .nav-badge {
            margin-left: auto; background: var(--accent);
            color: #fff; font-size: 11px; font-weight: 600;
            padding: 2px 8px; border-radius: 10px;
        }

        /* ── Main ── */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1; min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .topbar {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar h1 { font-size: 20px; font-weight: 700; }
        .topbar-actions { display: flex; gap: 12px; align-items: center; }
        .page-content { padding: 28px 32px; flex: 1; }

        /* ── Cards ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 { font-size: 16px; font-weight: 600; }
        .card-body { padding: 20px; }

        /* ── Stat Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px; margin-bottom: 28px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            display: flex; align-items: flex-start; gap: 16px;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,.3);
        }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-icon.amber { background: rgba(200,149,108,.15); color: var(--accent); }
        .stat-icon.green { background: rgba(74,222,128,.12); color: var(--success); }
        .stat-icon.blue  { background: rgba(96,165,250,.12); color: var(--info); }
        .stat-icon.red   { background: rgba(248,113,113,.12); color: var(--danger); }
        .stat-info h4 { font-size: 13px; color: var(--text-secondary); font-weight: 500; }
        .stat-info .stat-value { font-size: 26px; font-weight: 800; margin-top: 4px; }
        .stat-info .stat-sub { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ── Tables ── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            text-align: left; padding: 12px 16px;
            font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
            color: var(--text-muted); font-weight: 600;
            border-bottom: 1px solid var(--border);
        }
        tbody td {
            padding: 12px 16px; font-size: 14px;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
        }
        tbody tr { transition: background .15s; }
        tbody tr:hover { background: var(--bg-hover); }
        tbody tr:last-child td { border-bottom: none; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer;
            transition: all .2s; font-family: inherit;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #a06838);
            color: #fff;
        }
        .btn-primary:hover {
            box-shadow: 0 4px 16px var(--accent-glow);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: var(--bg-hover); color: var(--text-primary);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { background: var(--border); }
        .btn-danger { background: rgba(248,113,113,.12); color: var(--danger); border: 1px solid rgba(248,113,113,.2); }
        .btn-danger:hover { background: rgba(248,113,113,.25); }
        .btn-success { background: rgba(74,222,128,.12); color: var(--success); border: 1px solid rgba(74,222,128,.2); }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-icon { padding: 8px; width: 36px; height: 36px; justify-content: center; }

        /* ── Forms ── */
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block; font-size: 13px; font-weight: 600;
            color: var(--text-secondary); margin-bottom: 6px;
        }
        .form-control {
            width: 100%; padding: 10px 14px;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 14px; font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        .form-control::placeholder { color: var(--text-muted); }
        select.form-control { appearance: none; cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 90px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-check {
            display: flex; align-items: center; gap: 8px;
            font-size: 14px; color: var(--text-secondary); cursor: pointer;
        }
        .form-check input[type="checkbox"] {
            width: 18px; height: 18px; accent-color: var(--accent);
        }

        /* ── Badges ── */
        .badge {
            display: inline-block; padding: 4px 10px;
            border-radius: 6px; font-size: 12px; font-weight: 600;
        }
        .badge-success { background: rgba(74,222,128,.12); color: var(--success); }
        .badge-warning { background: rgba(251,191,36,.12); color: var(--warning); }
        .badge-danger  { background: rgba(248,113,113,.12); color: var(--danger); }
        .badge-info    { background: rgba(96,165,250,.12); color: var(--info); }
        .badge-default { background: var(--bg-hover); color: var(--text-secondary); }

        /* ── Alerts ── */
        .alert {
            padding: 14px 18px; border-radius: 8px;
            margin-bottom: 20px; font-size: 14px;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: rgba(74,222,128,.1); border: 1px solid rgba(74,222,128,.2); color: var(--success); }
        .alert-danger  { background: rgba(248,113,113,.1); border: 1px solid rgba(248,113,113,.2); color: var(--danger); }
        .alert-warning { background: rgba(251,191,36,.1); border: 1px solid rgba(251,191,36,.2); color: var(--warning); }

        /* ── Pagination ── */
        .pagination-wrapper { display: flex; justify-content: center; margin-top: 20px; }
        .pagination { display: flex; gap: 4px; list-style: none; }
        .pagination li a, .pagination li span {
            display: flex; align-items: center; justify-content: center;
            min-width: 36px; height: 36px; padding: 0 10px;
            border-radius: 8px; font-size: 13px; font-weight: 500;
            text-decoration: none; color: var(--text-secondary);
            background: var(--bg-card); border: 1px solid var(--border);
            transition: all .2s;
        }
        .pagination li a:hover { background: var(--bg-hover); color: var(--text-primary); }
        .pagination li.active span { background: var(--accent); color: #fff; border-color: var(--accent); }
        .pagination li.disabled span { opacity: .4; cursor: not-allowed; }

        /* ── Search Bar ── */
        .search-bar {
            display: flex; gap: 10px; margin-bottom: 20px;
            flex-wrap: wrap; align-items: center;
        }
        .search-bar .form-control { max-width: 300px; }

        /* ── Empty State ── */
        .empty-state {
            text-align: center; padding: 48px 20px;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 48px; margin-bottom: 16px; color: var(--border); }
        .empty-state h4 { font-size: 18px; margin-bottom: 8px; color: var(--text-secondary); }

        /* ── Price ── */
        .price { font-weight: 700; color: var(--accent-light); }
        .price-old {
            text-decoration: line-through; color: var(--text-muted);
            font-size: 12px; margin-left: 6px; font-weight: 400;
        }

        /* ── Mobile Toggle ── */
        .sidebar-toggle { display: none; background: none; border: none; color: var(--text-primary); font-size: 22px; cursor: pointer; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); z-index: 1000; }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 990; opacity: 0; transition: opacity .3s; }
            .sidebar-overlay.show { display: block; opacity: 1; }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .sidebar-close { display: block !important; background: none; border: none; color: var(--text-muted); font-size: 20px; cursor: pointer; margin-left: auto; }
            .form-row { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
            .page-content { padding: 16px; }
            .topbar { padding: 12px 16px; }
        }
    </style>
</head>
<body>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="fas fa-couch"></i></div>
            <div>
                <h2>Mueblería</h2>
                <small>Panel de Administración</small>
            </div>
            <button class="sidebar-close" style="display:none;" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Principal</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-section-title">Catálogo</div>
                <a href="{{ route('admin.categorias.index') }}" class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categorías
                </a>
                <a href="{{ route('admin.productos.index') }}" class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i> Productos
                </a>
                <a href="{{ route('admin.proveedores.index') }}" class="nav-link {{ request()->routeIs('admin.proveedores.*') ? 'active' : '' }}">
                    <i class="fas fa-truck"></i> Proveedores
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-section-title">Ventas</div>
                <a href="{{ route('admin.clientes.index') }}" class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Clientes
                </a>
                <a href="{{ route('admin.pedidos.index') }}" class="nav-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Pedidos
                </a>
                <a href="{{ route('admin.ventas.index') }}" class="nav-link {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}">
                    <i class="fas fa-cash-register"></i> Ventas
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-section-title">Tienda</div>
                <a href="{{ route('inicio') }}" class="nav-link" target="_blank">
                    <i class="fas fa-store"></i> Ver Tienda
                </a>
            </div>
            
            <div class="nav-section" style="margin-top:20px; border-top:1px solid var(--border); padding-top:20px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link" style="width:100%; text-align:left; background:transparent; border:none; cursor:pointer; color:var(--danger)">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>@yield('title', 'Dashboard')</h1>
            </div>
            <div class="topbar-actions">
                @yield('actions')
            </div>
        </header>

        <main class="page-content">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <div><i class="fas fa-exclamation-triangle"></i>
                        <ul style="margin:4px 0 0 16px;list-style:disc">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
            document.body.style.overflow = document.getElementById('sidebar').classList.contains('open') ? 'hidden' : '';
        }
    </script>
</body>
</html>
