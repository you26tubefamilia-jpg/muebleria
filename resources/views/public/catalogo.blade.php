<!DOCTYPE html>
<html lang="es">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MX9385TS');</script>
<!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Muebles — Muebles Panamá</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
    <style>
        .page-header { background: linear-gradient(135deg, var(--bg) 0%, var(--primary-soft) 100%); padding: 120px 48px 60px; text-align: center; }
        .page-header h1 { font-size: 40px; font-weight: 800; color: var(--text); margin-bottom: 12px; letter-spacing: -0.02em; }
        .page-header p { font-size: 16px; color: var(--text2); max-width: 600px; margin: 0 auto; }
        
        .catalog-container { max-width: 1300px; margin: 0 auto; padding: 40px 48px; display: flex; gap: 40px; }
        .sidebar-filters { width: 260px; flex-shrink: 0; }
        .filter-box { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 24px; position: sticky; top: 100px; }
        .filter-title { font-size: 16px; font-weight: 700; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border); color: var(--text); }
        .cat-list { list-style: none; }
        .cat-list li { margin-bottom: 10px; }
        .cat-list a { display: flex; align-items: center; justify-content: space-between; font-size: 14px; color: var(--text2); transition: color .2s; }
        .cat-list a:hover { color: var(--primary); }
        .cat-list a.active { color: var(--primary); font-weight: 700; }
        
        .catalog-main { flex: 1; }
        
        @media(max-width: 850px) {
            .catalog-container { flex-direction: column; }
            .sidebar-filters { width: 100%; }
            .filter-box { position: static; }
        }
    </style>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MX9385TS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    {{-- NAVBAR --}}
    <nav class="nav scrolled" id="navbar">
        <div class="nav-brand">
            <div class="nav-logo"><i class="fas fa-couch"></i></div>
            Muebles Panamá
        </div>
        <div class="nav-links">
            <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('catalogo') }}" class="active">Catálogo Completo</a>
        </div>
        <div class="nav-actions">
            @guest
                <a href="{{ route('login') }}" class="active"><i class="fas fa-user"></i> <span class="action-text">Iniciar Sesión</span></a>
            @else
                @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'vendedor')
                    <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-th-large"></i> <span class="action-text">Panel Admin</span></a>
                @else
                    <a href="{{ route('mi-cuenta') }}" class="active"><i class="fas fa-user"></i> <span class="action-text">Mi Cuenta</span></a>
                @endif
            @endguest
        </div>
    </nav>

    <header class="page-header">
        <h1>Explora Nuestro Catálogo</h1>
        <p>Desde recámaras confortables hasta comedores para recibir a toda la familia. Descubre la calidad que nos caracteriza.</p>
    </header>

    <div class="catalog-container">
        <!-- Filters Sidebar -->
        <aside class="sidebar-filters">
            <div class="filter-box">
                <div class="filter-title">Categorías</div>
                <ul class="cat-list">
                    <li><a href="{{ route('catalogo') }}" class="{{ !request('categoria') ? 'active' : '' }}">Todas las Categorías</a></li>
                    @foreach($categorias as $cat)
                    <li>
                        <a href="{{ route('catalogo', ['categoria' => $cat->id]) }}" class="{{ request('categoria') == $cat->id ? 'active' : '' }}">
                            {{ $cat->nombre }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                
                <div class="filter-title" style="margin-top: 30px;">Opciones Especiales</div>
                <ul class="cat-list">
                    <li><a href="#"><i class="fas fa-fire"></i> Lo más vendido</a></li>
                    <li><a href="#"><i class="fas fa-percent"></i> En Oferta</a></li>
                </ul>
            </div>
        </aside>

        <!-- Product Grid -->
        <main class="catalog-main">
            @if($productos->count() > 0)
                <div class="prod-grid">
                    @foreach($productos as $prod)
                    <div class="prod-card">
                        <div class="img-wrap">
                            @if($prod->imagen_principal)
                            <img src="{{ $prod->imagen_url }}" alt="{{ $prod->nombre }}">
                            @endif
                            @if($prod->precio_oferta)
                                <div class="prod-badge badge-sale">Oferta Especial</div>
                            @endif
                        </div>
                        <div class="prod-body">
                            <div class="prod-cat">{{ $prod->categoria->nombre ?? '' }}</div>
                            <h3>{{ $prod->nombre }}</h3>
                            <div class="prod-footer">
                                <div>
                                    <span class="prod-price">${{ number_format($prod->precio_final, 2) }}</span>
                                    @if($prod->precio_oferta)
                                        <span class="prod-price-old">${{ number_format($prod->precio, 2) }}</span>
                                    @endif
                                </div>
                                <a href="https://wa.me/50760000000?text={{ urlencode('Hola, me interesa el producto ' . $prod->nombre . ' (ID: ' . $prod->id . '). Quisiera realizar la compra.') }}" target="_blank" class="prod-btn" style="background-color:#25D366; color:white; border:none;" title="Comprar por WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="margin-top:40px; display:flex; justify-content:center;">
                    {{ $productos->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div style="text-align:center; padding: 60px 20px; background:var(--card); border-radius:var(--r); border:1px dashed var(--border);">
                    <i class="fas fa-search" style="font-size:40px; color:var(--border); margin-bottom:16px;"></i>
                    <h3>No se encontraron productos</h3>
                    <p style="color:var(--text2); margin-top:8px;">Intenta explorar otras categorías</p>
                </div>
            @endif
        </main>
    </div>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-bar">
            <span>&copy; {{ date('Y') }} Muebles Panamá. Todos los derechos reservados.</span>
            <span>Orgullosamente Panameños <i class="fas fa-flag" style="color:var(--accent);margin-left:4px"></i></span>
        </div>
    </footer>

</body>
</html>

