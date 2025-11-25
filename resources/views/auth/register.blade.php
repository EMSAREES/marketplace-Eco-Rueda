<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('title', 'Registrarse - Eco-Rueda')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-eco-green to-eco-lime py-12 px-4">
    <div class="max-w-2xl w-full">
        <!-- CARD REGISTRO -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- HEADER DECORATIVO -->
            <div class="bg-gradient-to-r from-eco-green to-eco-lime p-8 text-white text-center">
                <i class="fas fa-ring text-5xl mb-3 block"></i>
                <h1 class="text-3xl font-bold">Eco-Rueda</h1>
                <p class="text-sm opacity-90 mt-2">Únete a nuestra comunidad sostenible</p>
            </div>

            <!-- CONTENIDO REGISTRO -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-eco-dark mb-2">Crea tu Cuenta</h2>
                <p class="text-gray-600 text-sm mb-8">Completa el formulario para registrarte</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- ROW 1: NOMBRE Y EMAIL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NOMBRE -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-eco-dark mb-2">
                                <i class="fas fa-user"></i> Nombre Completo
                            </label>
                            <input id="name" type="text" name="name" required autofocus
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('name') border-red-500 @enderror"
                                placeholder="Tu nombre completo">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-eco-dark mb-2">
                                <i class="fas fa-envelope"></i> Correo Electrónico
                            </label>
                            <input id="email" type="email" name="email" required
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('email') border-red-500 @enderror"
                                placeholder="tu@correo.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- ROW 2: TELÉFONO Y CIUDAD -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- TELÉFONO -->
                        <div>
                            <label for="phone" class="block text-sm font-bold text-eco-dark mb-2">
                                <i class="fas fa-phone"></i> Teléfono (Opcional)
                            </label>
                            <input id="phone" type="tel" name="phone"
                                value="{{ old('phone') }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition"
                                placeholder="(000) 000-0000">
                        </div>

                        <!-- CIUDAD -->
                        <div>
                            <label for="city" class="block text-sm font-bold text-eco-dark mb-2">
                                <i class="fas fa-city"></i> Ciudad (Opcional)
                            </label>
                            <input id="city" type="text" name="city"
                                value="{{ old('city') }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition"
                                placeholder="Tu ciudad">
                        </div>
                    </div>

                    <!-- ROW 3: ESTADO Y PAÍS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- ESTADO -->
                        <div>
                            <label for="state" class="block text-sm font-bold text-eco-dark mb-2">
                                <i class="fas fa-map"></i> Estado (Opcional)
                            </label>
                            <input id="state" type="text" name="state"
                                value="{{ old('state') }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition"
                                placeholder="Tu estado">
                        </div>

                        <!-- PAÍS -->
                        <div>
                            <label for="country" class="block text-sm font-bold text-eco-dark mb-2">
                                <i class="fas fa-globe"></i> País (Opcional)
                            </label>
                            <input id="country" type="text" name="country"
                                value="{{ old('country', 'México') }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition"
                                placeholder="Tu país">
                        </div>
                    </div>

                    <!-- CONTRASEÑA -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-eco-dark mb-2">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('password') border-red-500 @enderror"
                                placeholder="Mínimo 8 caracteres">
                            <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-3 text-eco-green hover:text-eco-lime">
                                <i id="toggleIcon1" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CONFIRMAR CONTRASEÑA -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-eco-dark mb-2">
                            <i class="fas fa-lock"></i> Confirmar Contraseña
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition"
                                placeholder="Repite tu contraseña">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-3 text-eco-green hover:text-eco-lime">
                                <i id="toggleIcon2" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- TIPO DE CUENTA -->
                    <div>
                        <label class="block text-sm font-bold text-eco-dark mb-3">
                            <i class="fas fa-user-tag"></i> ¿Qué tipo de cuenta deseas?
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- COMPRADOR -->
                            <label class="flex items-start gap-3 p-4 border-2 border-eco-green rounded-lg cursor-pointer hover:bg-eco-sand transition has-[:checked]:bg-eco-lime has-[:checked]:bg-opacity-20 has-[:checked]:border-eco-lime">
                                <input type="radio" name="role" value="customer" checked class="mt-1 w-4 h-4 text-eco-green">
                                <div>
                                    <p class="font-bold text-eco-dark">Comprador</p>
                                    <p class="text-xs text-gray-600">Compra sillas y muebles sostenibles</p>
                                </div>
                            </label>

                            <!-- VENDEDOR -->
                            <label class="flex items-start gap-3 p-4 border-2 border-eco-green rounded-lg cursor-pointer hover:bg-eco-sand transition has-[:checked]:bg-eco-lime has-[:checked]:bg-opacity-20 has-[:checked]:border-eco-lime">
                                <input type="radio" name="role" value="vendor" class="mt-1 w-4 h-4 text-eco-green">
                                <div>
                                    <p class="font-bold text-eco-dark">Vendedor</p>
                                    <p class="text-xs text-gray-600">Vende tus creaciones recicladas</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- TÉRMINOS -->
                    <label class="flex items-start gap-2 p-4 bg-eco-sand rounded-lg cursor-pointer">
                        <input type="checkbox" name="terms" required class="mt-1 w-4 h-4 text-eco-green">
                        <span class="text-sm text-gray-600">
                            Acepto los <a href="#" class="text-eco-green font-bold hover:text-eco-lime">términos y condiciones</a>
                            y la <a href="#" class="text-eco-green font-bold hover:text-eco-lime">política de privacidad</a>
                        </span>
                    </label>

                    <!-- BOTÓN REGISTRARSE -->
                    <button type="submit" class="w-full bg-gradient-to-r from-eco-green to-eco-lime text-white font-bold py-3 rounded-lg hover:shadow-lg transition duration-300 text-lg">
                        <i class="fas fa-user-plus"></i> Crear Cuenta
                    </button>
                </form>

                <!-- DIVISOR -->
                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-gray-300"></div>
                    <span class="text-gray-400 text-sm">O regístrate con</span>
                    <div class="flex-1 h-px bg-gray-300"></div>
                </div>

                <!-- BOTÓN GOOGLE -->
                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-300 hover:border-eco-green hover:shadow-lg text-eco-dark font-bold py-3 rounded-lg transition duration-300">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Registrarse con Google
                </a>

                <!-- LINK LOGIN -->
                <p class="text-center text-gray-600 text-sm mt-8">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="text-eco-green hover:text-eco-lime font-bold transition">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const toggleIcon = document.getElementById('toggleIcon' + (fieldId === 'password' ? '1' : '2'));

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
