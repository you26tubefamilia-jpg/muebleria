<!DOCTYPE html>
<html lang="es">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2TGTMX6JXG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2TGTMX6JXG');
</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MX9385TS');</script>
<!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito — Muebles Panamá</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
    <style>
        .cart-wrapper { max-width: 1200px; margin: 120px auto 60px; padding: 0 48px; display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
        .cart-items { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; box-shadow: var(--shadow-sm); }
        .cart-item { display: flex; align-items: center; gap: 20px; padding: 20px; border-bottom: 1px solid var(--border); }
        .cart-item:last-child { border-bottom: none; }
        .cart-img { width: 100px; height: 100px; border-radius: 12px; object-fit: cover; background: var(--warm); }
        .cart-details { flex: 1; }
        .cart-details h4 { font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .cart-price { font-size: 18px; font-weight: 800; color: var(--primary); }
        .btn-remove { background: none; border: none; color: var(--danger); font-size: 16px; cursor: pointer; padding: 8px; }
        .btn-remove:hover { color: #b91c1c; }
        
        .cart-summary { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 30px; box-shadow: var(--shadow-sm); position: sticky; top: 100px; }
        .cart-summary h3 { font-size: 20px; font-weight: 800; border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 20px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; color: var(--text2); }
        .summary-row.total { font-size: 22px; font-weight: 800; color: var(--primary); border-top: 1px solid var(--border); padding-top: 16px; margin-top: 16px; margin-bottom: 24px; }
        
        .checkout-form label { display: block; font-size: 14px; font-weight: 600; color: var(--text2); margin-bottom: 8px; margin-top: 16px; }
        .checkout-form input, .checkout-form select { width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 14px; }
        .checkout-form input:focus, .checkout-form select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-soft); }
        
        .btn-checkout { display: block; width: 100%; text-align: center; padding: 16px; background: var(--primary); color: #fff; border: none; border-radius: 12px; font-size: 16px; font-weight: 800; margin-top: 24px; cursor: pointer; transition: all .2s; }
        .btn-checkout:hover { background: #0d2a86; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16,52,166,.2); }
        
        .empty-cart { text-align: center; padding: 60px 20px; color: var(--text2); }
        .empty-cart i { font-size: 60px; color: var(--border); margin-bottom: 20px; }
        .empty-cart h3 { font-size: 24px; color: var(--text); margin-bottom: 12px; }
        
        @media(max-width: 900px) { .cart-wrapper { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MX9385TS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <nav class="nav scrolled" id="navbar">
        <div class="nav-brand"><div class="nav-logo"><i class="fas fa-couch"></i></div> Muebles Panamá</div>
        <div class="nav-links">
            <a href="{{ route('inicio') }}">Inicio</a>
            <a href="{{ route('catalogo') }}">Catálogo Completo</a>
        </div>
        <div class="nav-actions">
            <a href="{{ route('carrito') }}" class="active"><i class="fas fa-shopping-cart"></i></a>
            @auth
                <a href="{{ route('mi-cuenta') }}" class="active"><i class="fas fa-user"></i> <span class="action-text">Mi Cuenta</span></a>
            @else
                <a href="{{ route('login') }}" class="active"><i class="fas fa-user"></i> <span class="action-text">Iniciar Sesión</span></a>
            @endauth
        </div>
    </nav>

    <div class="cart-wrapper">
        <div class="cart-items">
            @if(session('success'))
                <div style="background: rgba(74,222,128,.1); color: #166534; padding: 16px; text-align: center; font-weight: bold; border-bottom: 1px solid rgba(74,222,128,.2);">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: rgba(248,113,113,.1); color: #991b1b; padding: 16px; text-align: center; font-weight: bold; border-bottom: 1px solid rgba(248,113,113,.2);">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(count($cart) > 0)
                @foreach($cart as $index => $item)
                <div class="cart-item">
                    @if(isset($item['imagen']))
                        <img src="{{ \Illuminate\Support\Str::startsWith($item['imagen'], ['http://', 'https://']) ? $item['imagen'] : asset('storage/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="cart-img">
                    @else
                        <div class="cart-img" style="display:flex;align-items:center;justify-content:center;color:#ccc;"><i class="fas fa-image" style="font-size:30px;"></i></div>
                    @endif
                    <div class="cart-details">
                        <h4>{{ $item['nombre'] }}</h4>
                        <div class="cart-price">${{ number_format($item['precio'], 2) }}</div>
                    </div>
                    <form action="{{ route('carrito.remove', $index) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-remove" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
                @endforeach
            @else
                <div class="empty-cart">
                    <i class="fas fa-shopping-basket"></i>
                    <h3>Tu carrito está vacío</h3>
                    <p>Agrega algunos muebles increíbles a tu carrito.</p>
                    <a href="{{ route('catalogo') }}" class="btn-primary" style="margin-top:20px; display:inline-block;">Ir al Catálogo</a>
                </div>
            @endif
        </div>

        @if(count($cart) > 0)
        <div class="cart-summary">
            <h3>Resumen de Compra</h3>
            @php $subtotal = collect($cart)->sum('precio'); @endphp
            <div class="summary-row">
                <span>Subtotal ({{ count($cart) }} items)</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Envío estimado</span>
                <span>A convenir</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>

            @auth
                <form action="{{ route('carrito.checkout') }}" method="POST" class="checkout-form">
                    @csrf
                    <label>Dirección de Envío Completa</label>
                    <input type="text" name="direccion" required placeholder="Provincia, Distrito, Corregimiento, Calle...">
                    
                    <label>Método de Pago Preferido</label>
                    <select name="metodo_pago" required>
                        <option value="yappy">Yappy (6000-0000)</option>
                        <option value="ach">Transferencia ACH (Banco General)</option>
                        <option value="tarjeta">Tarjeta de Crédito (al entregar)</option>
                        <option value="efectivo">Efectivo (al entregar)</option>
                    </select>

                    <button type="submit" class="btn-checkout">Confirmar Pedido</button>
                </form>
            @else
                <div style="background:var(--warm); padding:20px; border-radius:12px; text-align:center;">
                    <p style="margin-bottom:12px; color:var(--text2); font-size:14px;">Debes iniciar sesión para finalizar tu pedido.</p>
                    <a href="{{ route('login') }}" class="btn-primary" style="width:100%;">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" style="display:block; margin-top:12px; font-size:13px; font-weight:700; color:var(--primary);">Crear una cuenta</a>
                </div>
            @endauth
        </div>
        @endif
    </div>

</body>
</html>


