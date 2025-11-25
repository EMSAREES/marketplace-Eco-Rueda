<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('title', 'Iniciar Sesión - Eco-Rueda')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-eco-green to-eco-lime py-12 px-4">
    <div class="max-w-md w-full">
        <!-- CARD LOGIN -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- HEADER DECORATIVO -->
            <div class="bg-gradient-to-r from-eco-green to-eco-lime p-8 text-white text-center">
                <i class="fas fa-ring text-5xl mb-3 block"></i>
                <h1 class="text-3xl font-bold">Eco-Rueda</h1>
                <p class="text-sm opacity-90 mt-2">Muebles Sostenibles</p>
            </div>

            <!-- CONTENIDO LOGIN -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-eco-dark mb-2">Bienvenido de Vuelta</h2>
                <p class="text-gray-600 text-sm mb-8">Inicia sesión en tu cuenta para continuar</p>

                <!-- FORM TRADICIONAL -->
                <form method="POST" action="{{ route('auth.authenticate') }}" class="space-y-5">
                    @csrf

                    <!-- EMAIL -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-eco-dark mb-2">
                            <i class="fas fa-envelope"></i> Correo Electrónico
                        </label>
                        <input id="email" type="email" name="email" required autofocus
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('email') border-red-500 @enderror"
                            placeholder="tu@correo.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CONTRASEÑA -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-eco-dark mb-2">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-eco-green hover:text-eco-lime">
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- RECUERDAME -->
                    {{-- <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-eco-green rounded">
                            <span class="text-sm text-gray-600">Recuérdame</span>
                        </label>
                        <a href="#" class="text-xs text-eco-green hover:text-eco-lime transition font-semibold">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div> --}}

                    <!-- BOTÓN INICIAR SESIÓN -->
                    <button type="submit" class="w-full bg-gradient-to-r from-eco-green to-eco-lime text-white font-bold py-3 rounded-lg hover:shadow-lg transition duration-300 text-lg">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </button>
                </form>

                <!-- DIVISOR -->
                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-gray-300"></div>
                    <span class="text-gray-400 text-sm">O continúa con</span>
                    <div class="flex-1 h-px bg-gray-300"></div>
                </div>

                <!-- BOTÓN GOOGLE -->
                <a href="{{-- {{ route('auth.google') }} --}}" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-300 hover:border-eco-green hover:shadow-lg text-eco-dark font-bold py-3 rounded-lg transition duration-300">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Continuar con Google
                </a>

                <!-- LINK REGISTRO -->
                {{-- <p class="text-center text-gray-600 text-sm mt-8">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }} " class="text-eco-green hover:text-eco-lime font-bold transition">
                        Regístrate aquí
                    </a>
                </p> --}}
            </div>
        </div>

        <!-- INFO EXTRA -->
        <div class="mt-8 text-center text-white text-sm">
            <p class="mb-3">
                <i class="fas fa-shield-alt"></i> Compra 100% Segura
            </p>
            <p>
                <i class="fas fa-lock"></i> Tus datos están protegidos con encriptación
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

@endsection
