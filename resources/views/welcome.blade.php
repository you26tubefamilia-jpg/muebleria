<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mueblería Panamá — Estilo y Tradición</title>
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
            Mueblería Panamá
        </div>
        <div class="nav-links">
            <a href="{{ route('inicio') }}" class="active">Inicio</a>
            <a href="{{ route('catalogo') }}">Colección</a>
            <a href="#destacados">Destacados</a>
            <a href="#juego">Privilegios</a>
        </div>
        <div class="nav-actions">
            @php $cartCount = count(session()->get('cart', [])); @endphp
            <a href="{{ route('carrito') }}" style="position:relative;" aria-label="Carrito">
                <i class="fas fa-shopping-bag"></i>
                @if($cartCount > 0)
                    <span style="position:absolute; top:-5px; right:-8px; background:var(--accent); color:#fff; font-size:10px; border-radius:50%; width:16px; height:16px; display:flex; align-items:center; justify-content:center; font-weight:bold;">{{ $cartCount }}</span>
                @endif
            </a>
            
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
                    <img src="{{ asset('storage/' . $showcase->imagen_principal) }}" alt="{{ $showcase->nombre }}">
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
                    <img src="{{ asset('storage/' . $prod->imagen_principal) }}" alt="{{ $prod->nombre }}">
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
                        <a href="{{ route('catalogo') }}" class="prod-btn"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- JUEGO: RULETA --}}
    <section class="game-section reveal" id="juego">
        <div class="game-box">
            <div class="game-info">
                <h3><i class="fas fa-ticket-alt"></i> Beneficios VIP</h3>
                <p>Experimente el privilegio de pertenecer a nuestro círculo exclusivo. Gire para revelar su beneficio de cortesía en su próxima adquisición.</p>
                <div class="game-result" id="gameResult">Aguardando...</div>
            </div>
            <div class="roulette-container">
                <div class="roulette-pointer"></div>
                <button class="roulette-btn" id="spinBtn">GIRAR</button>
                <div class="roulette-wheel" id="wheel">
                    <div class="slice slice-1"><span>10% OFF</span></div>
                    <div class="slice slice-2"><span>Envío VIP</span></div>
                    <div class="slice slice-3"><span>5% OFF</span></div>
                    <div class="slice slice-4"><span>Cortesía</span></div>
                </div>
            </div>
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
                <h3><i class="fas fa-gem"></i> Mueblería Panamá</h3>
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
                <a href="#juego">Privilegios VIP</a>
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
            <span>&copy; {{ date('Y') }} Mueblería Panamá. Excelencia en Diseño.</span>
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

    // Roulette Game Logic
    const wheel = document.getElementById('wheel');
    const spinBtn = document.getElementById('spinBtn');
    const resultText = document.getElementById('gameResult');
    let currentRotation = 0;
    let isSpinning = false;
    
    const prizes = [
        { name: "Beneficio VIP: 10% OFF (Código: LUX10)", degree: 0 },
        { name: "Beneficio VIP: Envío Premium (Código: FREELUX)", degree: 90 },
        { name: "Beneficio VIP: 5% OFF (Código: LUX5)", degree: 180 },
        { name: "Beneficio VIP: Regalo de Cortesía (Código: LUXGIFT)", degree: 270 }
    ];

    spinBtn.addEventListener('click', () => {
        if(isSpinning) return;
        isSpinning = true;
        resultText.innerText = "Revelando su beneficio...";
        
        // Random spin between 5 to 10 full rotations
        const spins = Math.floor(Math.random() * 5) + 5;
        const randomDegree = Math.floor(Math.random() * 360);
        const totalDegree = (spins * 360) + randomDegree;
        
        currentRotation += totalDegree;
        wheel.style.transform = `rotate(${currentRotation}deg)`;
        
        setTimeout(() => {
            isSpinning = false;
            const actualDeg = currentRotation % 360;
            let index = 0;
            if(actualDeg >= 0 && actualDeg < 90) index = 3;
            else if(actualDeg >= 90 && actualDeg < 180) index = 2;
            else if(actualDeg >= 180 && actualDeg < 270) index = 1;
            else index = 0;

            resultText.innerText = prizes[index].name;
            
            setTimeout(() => { resultText.style.transform = "scale(1.05)"; }, 100);
            setTimeout(() => { resultText.style.transform = "scale(1)"; }, 300);
        }, 4000); // Wait 4 seconds for the longer spin CSS transition
    });
    </script>
</body>
</html>
