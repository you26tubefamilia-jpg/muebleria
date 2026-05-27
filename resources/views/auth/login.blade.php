<x-guest-layout>
    
    <div class="auth-form-title">Bienvenido de vuelta</div>
    <div class="auth-form-subtitle">Ingresa tus credenciales para acceder a tu cuenta.</div>

    <!-- Session Status -->
    @if(session('status'))
        <div style="background:rgba(74,222,128,.1); color:#166534; padding:12px; border-radius:8px; margin-bottom:20px; font-size:14px; font-weight:600;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="ejemplo@correo.com">
            @error('email')
                <div style="color:var(--danger); font-size:13px; margin-top:6px; font-weight:600;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <div style="color:var(--danger); font-size:13px; margin-top:6px; font-weight:600;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="auth-links">
            <label for="remember_me" class="checkbox-group">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Recordarme</span>
            </label>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <button type="submit" class="btn-auth">Iniciar Sesión <i class="fas fa-arrow-right" style="margin-left:6px;"></i></button>
    </form>
    
    <div class="auth-footer">
        ¿Aún no tienes cuenta? <a href="{{ route('register') }}" style="color:var(--primary); font-weight:700;">Regístrate aquí</a>
    </div>

</x-guest-layout>
