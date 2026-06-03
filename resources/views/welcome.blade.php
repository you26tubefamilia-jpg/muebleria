<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muebles Panamá — Estilo y Tradición</title>
    <meta name="description" content="Muebles de calidad en Panamá. Encuentra recámaras, comedores y salas con los mejores acabados y diseño premium.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="nav" id="navbar">
        <div class="nav-brand">
            <div class="nav-logo"><i class="fas fa-gem"></i></div>
            Muebles Panamá
        </div>
        <div class="nav-links">
            <a href="{{ route('inicio') }}" class="active">Inicio</a>
            <a href="{{ route('catalogo') }}">Colección</a>
            <a href="#destacados">Destacados</a>
        </div>
        <div class="nav-actions">
            @guest
                <a href="{{ route('login') }}" class="active" aria-label="Iniciar Sesión"><i class="fas fa-user"></i> <span class="action-text"></span></a>
            @else
                @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'vendedor')
                    <a href="{{ route('admin.dashboard') }}" class="active" aria-label="Panel"><i class="fas fa-th-large"></i> <span class="action-text"></span></a>
                @else
                    <a href="{{ route('mi-cuenta') }}" class="active" aria-label="Mi Cuenta"><i class="fas fa-user"></i> <span class="action-text"></span></a>
                @endif
            @endguest
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-text">
                <div class="hero-pill"><i class="fas fa-crown"></i> Colección Exclusiva 2026</div>
                <h1>El arte del buen <span class="accent-text">vivir</span></h1>
                <p class="hero-desc">Descubre nuestra exclusiva selección de mobiliario. Piezas maestras diseñadas para transformar tu hogar en un santuario de elegancia y confort incomparable.</p>
                <div class="hero-btns">
                    <a href="{{ route('catalogo') }}" class="btn-primary">Ver Colección</a>
                    <a href="#destacados" class="btn-outline">Saber Más</a>
                </div>
            </div>

            @php $showcase = $productosDestacados->first(); @endphp
            @if($showcase && $showcase->imagen_principal)
            <div class="hero-visual">
                <div class="hero-img-wrap">
                    <img src="{{ $showcase->imagen_url }}" alt="{{ $showcase->nombre }}">
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- CATEGORIAS --}}
    <section class="section" id="categorias">
        <div class="section-head reveal">
            <div>
                <h2>Nuestras Colecciones</h2>
                <p>Curaduría de diseño para cada espacio de tu hogar.</p>
            </div>
            <a href="{{ route('catalogo') }}" class="btn-outline" style="padding:12px 24px">Explorar todo</a>
        </div>
        @php $catIcons = ['Camas'=>'fa-bed','Cocina'=>'fa-kitchen-set','Comedores'=>'fa-utensils','Gaveteros'=>'fa-box-archive','Puertas'=>'fa-door-open']; @endphp
        <div class="cat-grid reveal">
            @foreach($categorias as $cat)
            <div class="cat-card" onclick="window.location.href='{{ route('catalogo') }}?categoria={{ $cat->id }}'">
                <div class="cat-icon"><i class="fas {{ $catIcons[$cat->nombre] ?? 'fa-cube' }}"></i></div>
                <h3>{{ $cat->nombre }}</h3>
                <span>{{ $cat->productos_count }} diseños</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- DESTACADOS --}}
    <section class="section" id="destacados">
        <div class="section-head reveal">
            <div>
                <h2>Piezas Destacadas</h2>
                <p>Nuestra selección más exquisita y codiciada.</p>
            </div>
        </div>
        <div class="prod-grid reveal">
            @foreach($productosDestacados as $prod)
            <div class="prod-card">
                <div class="img-wrap">
                    @if($prod->imagen_principal)
                    <img src="{{ $prod->imagen_url }}" alt="{{ $prod->nombre }}">
                    @endif
                    <div class="prod-badge badge-star">Premium</div>
                </div>
                <div class="prod-body">
                    <div class="prod-cat">{{ $prod->categoria->nombre ?? '' }}</div>
                    <h3>{{ $prod->nombre }}</h3>
                    <div class="prod-footer">
                        <div class="prod-price">
                            <span class="prod-price-label">Precio Exclusivo</span>
                            ${{ number_format($prod->precio_final, 2) }}
                        </div>
                        <a href="https://wa.me/50760000000?text={{ urlencode('Hola, me interesa el producto ' . $prod->nombre . ' (ID: ' . $prod->id . '). Quisiera realizar la compra.') }}" target="_blank" class="prod-btn" style="background-color:#25D366; color:white; border:none;" title="Comprar por WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>


    {{-- FEATURES PANAMA --}}
    <div class="features reveal">
        <div class="feat">
            <div class="feat-icon"><i class="fas fa-truck-fast"></i></div>
            <div>
                <h4>Logística Premium</h4>
                <p>Entregas puntuales y cuidadosas en todo Panamá, asegurando la integridad de sus piezas.</p>
            </div>
        </div>
        <div class="feat">
            <div class="feat-icon"><i class="fas fa-tree"></i></div>
            <div>
                <h4>Materiales Nobles</h4>
                <p>Maderas selectas tratadas especialmente para perdurar en el clima de nuestro país.</p>
            </div>
        </div>
        <div class="feat">
            <div class="feat-icon"><i class="fas fa-shield-alt"></i></div>
            <div>
                <h4>Garantía de Autor</h4>
                <p>Cada pieza está respaldada por nuestro compromiso inquebrantable con la calidad.</p>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <h3><i class="fas fa-gem"></i> Muebles Panamá</h3>
                <p>Elevando el estándar del diseño de interiores en Panamá. Más de una década creando espacios que inspiran y perduran.</p>
                <div class="footer-socials">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Navegación</h4>
                <a href="{{ route('inicio') }}">Inicio</a>
                <a href="{{ route('catalogo') }}">Colección</a>
                <a href="#destacados">Destacados</a>
            </div>
            <div class="footer-col">
                <h4>Atención Exclusiva</h4>
                <a href="#"><i class="fas fa-phone" style="margin-right:8px;"></i> +507 200-0000</a>
                <a href="#"><i class="fab fa-whatsapp" style="margin-right:8px;"></i> +507 6000-0000</a>
                <a href="#"><i class="fas fa-envelope" style="margin-right:8px;"></i> concierge@muebleriapanama.com</a>
                <a href="#"><i class="fas fa-map-marker-alt" style="margin-right:8px;"></i> Showroom en Vía España</a>
            </div>
        </div>
        <div class="footer-bar">
            <span>&copy; {{ date('Y') }} Muebles Panamá. Excelencia en Diseño.</span>
            <span>Hecho con distinción en Panamá</span>
        </div>
    </footer>

    <script>
    // Navbar scroll
    const nav = document.getElementById('navbar');
    window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 50));

    // Scroll reveal
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target)} });
    }, {threshold:.1, rootMargin:'0px 0px -30px 0px'});
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

    </script>
</body>
</html>
