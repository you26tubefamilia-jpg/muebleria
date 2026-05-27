<x-guest-layout>

    <div class="auth-form-title">Crea tu Cuenta</div>
    <div class="auth-form-subtitle">Regístrate para realizar pedidos y guardar tus favoritos.</div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="input-group">
            <label for="name">Nombre Completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Ej. Juan Pérez">
            @error('name')
                <div style="color:var(--danger); font-size:13px; margin-top:6px; font-weight:600;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="input-group">
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="ejemplo@correo.com">
            @error('email')
                <div style="color:var(--danger); font-size:13px; margin-top:6px; font-weight:600;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            @error('password')
                <div style="color:var(--danger); font-size:13px; margin-top:6px; font-weight:600;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            @error('password_confirmation')
                <div style="color:var(--danger); font-size:13px; margin-top:6px; font-weight:600;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-auth">Registrarme <i class="fas fa-user-plus" style="margin-left:6px;"></i></button>
    </form>
    
    <div class="auth-footer">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color:var(--primary); font-weight:700;">Inicia sesión aquí</a>
    </div>

</x-guest-layout>
