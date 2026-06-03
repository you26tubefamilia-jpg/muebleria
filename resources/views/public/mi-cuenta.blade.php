<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta — Muebles Panamá</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
    <style>
        .account-wrapper { max-width: 1200px; margin: 120px auto 60px; padding: 0 48px; }
        .account-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px; }
        .account-header h1 { font-size: 32px; font-weight: 800; color: var(--text); }
        .account-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 40px; }
        
        .profile-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 30px; box-shadow: var(--shadow-sm); }
        .profile-avatar { width: 80px; height: 80px; background: var(--primary-soft); color: var(--primary); font-size: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-bottom: 20px; }
        .profile-info { margin-bottom: 24px; }
        .profile-info h3 { font-size: 20px; font-weight: 700; color: var(--text); }
        .profile-info p { color: var(--text2); font-size: 14px; margin-top: 4px; }
        
        .orders-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 30px; box-shadow: var(--shadow-sm); }
        .orders-card h2 { font-size: 20px; font-weight: 800; border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 20px; }
        
        .order-list { display: flex; flex-direction: column; gap: 16px; }
        .order-item { border: 1px solid var(--border); border-radius: 8px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; transition: all .2s; }
        .order-item:hover { border-color: var(--primary-soft); box-shadow: 0 4px 12px rgba(16,52,166,.05); }
        .order-info h4 { font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 4px; }
        .order-info p { font-size: 13px; color: var(--text2); }
        .order-status { text-align: right; }
        .order-price { font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 6px; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-pendiente { background: rgba(251,191,36,.12); color: #b45309; }
        .badge-completado { background: rgba(74,222,128,.12); color: #166534; }
        .badge-cancelado { background: rgba(248,113,113,.12); color: #991b1b; }
        
        @media(max-width: 768px) { .account-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <nav class="nav scrolled" id="navbar">
        <div class="nav-brand"><div class="nav-logo"><i class="fas fa-couch"></i></div> Muebles Panamá</div>
        <div class="nav-links">
            <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('catalogo') }}">Catálogo Completo</a>
        </div>
        <div class="nav-actions">
            <a href="{{ route('mi-cuenta') }}" class="active"><i class="fas fa-user"></i> <span class="action-text">Mi Cuenta</span></a>
        </div>
    </nav>

    <div class="account-wrapper">
        @if(session('success'))
            <div style="background: rgba(74,222,128,.1); color: #166534; padding: 16px; border-radius:8px; margin-bottom:24px; font-weight: bold; border: 1px solid rgba(74,222,128,.2);">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="account-header">
            <h1>Hola, {{ auth()->user()->name }}</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-outline" style="color:var(--danger); border-color:var(--danger);"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
            </form>
        </div>

        <div class="account-grid">
            <!-- Perfil -->
            <div>
                <div class="profile-card">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-info">
                        <h3>{{ auth()->user()->name }}</h3>
                        <p><i class="fas fa-envelope" style="margin-right:6px"></i> {{ auth()->user()->email }}</p>
                        <p style="margin-top:8px"><span class="badge badge-completado">Cliente Verificado</span></p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn-outline" style="width:100%; text-align:center;">Configuración de Perfil</a>
                </div>
            </div>

            <!-- Pedidos -->
            <div>
                <div class="orders-card">
                    <h2>Mis Pedidos Recientes</h2>
                    
                    @if($pedidos->count() > 0)
                        <div class="order-list">
                            @foreach($pedidos as $pedido)
                            <div class="order-item">
                                <div class="order-info">
                                    <h4>{{ $pedido->numero_pedido }}</h4>
                                    <p>{{ $pedido->created_at->format('d M, Y') }} • Envío a: {{ Str::limit($pedido->direccion_envio, 30) }}</p>
                                </div>
                                <div class="order-status">
                                    <div class="order-price">${{ number_format($pedido->total, 2) }}</div>
                                    <span class="badge badge-{{ strtolower($pedido->estado) }}">{{ $pedido->estado }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align:center; padding:40px 0; color:var(--text2);">
                            <i class="fas fa-box-open" style="font-size:48px; color:var(--border); margin-bottom:16px;"></i>
                            <p>Aún no has realizado ninguna compra.</p>
                            <a href="{{ route('catalogo') }}" class="btn-primary" style="margin-top:20px;">Ver Catálogo</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>
</html>
