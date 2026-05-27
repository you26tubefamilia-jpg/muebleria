<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mueblería Panamá — Acceso</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Muebleria Theme -->
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
    
    <style>
        .auth-layout {
            display: flex;
            min-height: 100vh;
            background: var(--bg);
        }
        
        .auth-banner {
            flex: 1;
            display: none;
            background: linear-gradient(135deg, rgba(16,52,166,0.8) 0%, rgba(181,42,58,0.8) 100%), url('{{ asset('storage/productos/comedores/COM-001.jpg') }}') center/cover;
            color: #fff;
            padding: 60px;
            flex-direction: column;
            justify-content: space-between;
        }
        
        @media(min-width: 900px) {
            .auth-banner { display: flex; }
        }
        
        .auth-banner-content h1 {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.1;
        }
        .auth-banner-content p {
            font-size: 18px;
            opacity: 0.9;
            max-width: 400px;
            line-height: 1.6;
        }
        
        .auth-form-container {
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            background: var(--bg2);
            box-shadow: -10px 0 30px rgba(0,0,0,0.05);
        }
        
        .auth-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 40px;
            text-decoration: none;
        }
        .auth-logo i {
            width: 42px;
            height: 42px;
            background: var(--primary);
            color: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .auth-form-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 8px;
        }
        .auth-form-subtitle {
            font-size: 15px;
            color: var(--text2);
            margin-bottom: 30px;
        }
        
        /* Form Overrides */
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text2);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-family: inherit;
            font-size: 15px;
            transition: all .2s;
            background: var(--bg);
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px var(--primary-soft);
        }
        
        .btn-auth {
            display: block;
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all .2s;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(16,52,166,.2);
        }
        .btn-auth:hover {
            background: #0d2a86;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(16,52,166,.3);
        }
        
        .auth-links {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 14px;
        }
        .auth-links a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-links a:hover {
            text-decoration: underline;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text2);
            font-weight: 500;
            cursor: pointer;
        }
        .checkbox-group input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }
        
        .auth-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: var(--text3);
        }
    </style>
</head>
<body>

    <div class="auth-layout">
        <!-- Banner Side -->
        <div class="auth-banner">
            <div>
                <a href="{{ route('inicio') }}" style="color:#fff; text-decoration:none; font-weight:700;"><i class="fas fa-arrow-left"></i> Volver a la Tienda</a>
            </div>
            <div class="auth-banner-content">
                <h1>Tu hogar,<br>tu estilo.</h1>
                <p>Accede a tu cuenta para darle seguimiento a tus pedidos, guardar tus favoritos y realizar compras seguras.</p>
            </div>
            <div>
                <small>&copy; {{ date('Y') }} Mueblería Panamá. Orgullosamente panameños.</small>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="auth-form-container">
            <a href="{{ route('inicio') }}" class="auth-logo">
                <i class="fas fa-couch"></i> Mueblería Panamá
            </a>
            
            {{ $slot }}
            
        </div>
    </div>

</body>
</html>
