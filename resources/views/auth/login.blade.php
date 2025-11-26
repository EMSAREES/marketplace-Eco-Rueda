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

                <!-- TABS: VENDEDOR / CLIENTE -->
                <div class="flex gap-2 mb-8 border-b-2 border-gray-300">
                    <button onclick="showLoginTab('customer')" id="tab-customer" class="flex-1 py-3 font-bold text-eco-green border-b-4 border-eco-green">
                        <i class="fas fa-shopping-bag"></i> Comprador
                    </button>
                    <button onclick="showLoginTab('vendor')" id="tab-vendor" class="flex-1 py-3 font-bold text-gray-600 hover:text-eco-green transition">
                        <i class="fas fa-store"></i> Vendedor
                    </button>
                </div>

                <!-- ==================== TAB 1: VENDEDOR (Email + Password) ==================== -->
                <div id="tab-vendor-content" class="tab-login-content hidden">
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

                        <!-- INFO VENDEDOR -->
                        <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                            <p class="text-xs text-blue-700">
                                <i class="fas fa-info-circle"></i>
                                <strong>Vendedor:</strong> Inicia sesión con tu email y contraseña
                            </p>
                        </div>

                        <!-- BOTÓN INICIAR SESIÓN -->
                        <button type="submit" class="w-full bg-gradient-to-r from-eco-green to-eco-lime text-white font-bold py-3 rounded-lg hover:shadow-lg transition duration-300 text-lg">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </button>
                    </form>
                </div>

                <!-- ==================== TAB 2: COMPRADOR (Google) ==================== -->
                <div id="tab-customer-content" class="tab-login-content ">
                    <div class="space-y-5">
                        <!-- INFO COMPRADOR -->
                        <div class="p-4 bg-eco-lime bg-opacity-20 border-l-4 border-eco-lime rounded">
                            <p class="text-sm text-eco-green font-semibold">
                                <i class="fas fa-info-circle"></i>
                                <strong>Comprador:</strong> Inicia sesión seguro con tu cuenta de Google
                            </p>
                        </div>

                        <!-- BOTÓN GOOGLE -->
                        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-300 hover:border-eco-green hover:shadow-lg text-eco-dark font-bold py-3 rounded-lg transition duration-300">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Continuar con Google
                        </a>

                        <!-- BENEFICIOS -->
                        <div class="space-y-3 mt-6">
                            <div class="flex items-center gap-2 p-3 bg-eco-sand rounded">
                                <i class="fas fa-shield-alt text-eco-green"></i>
                                <span class="text-sm text-eco-dark"><strong>Seguro:</strong> Autenticación Google</span>
                            </div>
                            <div class="flex items-center gap-2 p-3 bg-eco-sand rounded">
                                <i class="fas fa-lock text-eco-green"></i>
                                <span class="text-sm text-eco-dark"><strong>Privado:</strong> No compartimos datos</span>
                            </div>
                            <div class="flex items-center gap-2 p-3 bg-eco-sand rounded">
                                <i class="fas fa-zap text-eco-green"></i>
                                <span class="text-sm text-eco-dark"><strong>Rápido:</strong> Sin contraseña</span>
                            </div>
                        </div>
                    </div>
                </div>
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

    function showLoginTab(tabName) {
        // Ocultar todos los tabs
        document.querySelectorAll('.tab-login-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Remover estilos activos
        document.querySelectorAll('#tab-customer, #tab-vendor').forEach(btn => {
            btn.classList.remove('border-b-4', 'border-eco-green', 'text-eco-green');
            btn.classList.add('text-gray-600');
        });

        // Mostrar tab seleccionado
        document.getElementById('tab-' + tabName + '-content').classList.remove('hidden');
        document.getElementById('tab-' + tabName).classList.add('border-b-4', 'border-eco-green', 'text-eco-green');
        document.getElementById('tab-' + tabName).classList.remove('text-gray-600');
    }
</script>

@endsection
