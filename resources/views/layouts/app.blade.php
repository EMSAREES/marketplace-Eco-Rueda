<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Eco-Rueda - Muebles Reciclados') | Eco-Rueda</title>

    <!-- Tailwind sin warning -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'eco-green': '#2d5016',
                        'eco-lime': '#7ec850',
                        'eco-dark': '#1a1a1a',
                        'eco-sand': '#f5f1e8'
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-eco-sand text-eco-dark">
    <!-- NAVBAR -->
    <nav class="bg-eco-green text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- LOGO -->
                <div class="flex items-center gap-2">
                    <i class="fas fa-ring text-eco-lime text-3xl"></i>
                    <span class="text-2xl font-bold">Eco-Rueda</span>
                </div>

                <!-- MENU DESKTOP -->
                <div class="hidden md:flex gap-8 items-center">
                    <a href="{{ route('products.index') }}" class="hover:text-eco-lime transition">
                        <i class="fas fa-chair"></i> Catálogo
                    </a>
                    <a href="#" class="hover:text-eco-lime transition">
                        <i class="fas fa-leaf"></i> Sobre Nosotros
                    </a>
                    <a href="#" class="hover:text-eco-lime transition">
                        <i class="fas fa-recycle"></i> Nuestro Proceso
                    </a>
                </div>

                <!-- DERECHA -->
                <div class="flex items-center gap-4">
                    <!-- Carrito -->
                    <a href="#" class="relative hover:text-eco-lime transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if(session('cart'))
                            <span class="absolute -top-2 -right-3 bg-eco-lime text-eco-dark text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- Usuario -->
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 hover:text-eco-lime transition">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            </button>
                            <div class="absolute right-0 w-48 bg-white text-eco-dark rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition duration-300 py-2">
                                @if(auth()->user()->isVendor())
                                    <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 hover:bg-eco-lime hover:text-white transition">
                                        <i class="fas fa-store"></i> Panel Vendedor
                                    </a>
                                @endif
                                <a href="#" class="block px-4 py-2 hover:bg-eco-lime hover:text-white transition">
                                    <i class="fas fa-cog"></i> Perfil
                                </a>
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-eco-lime hover:text-white transition">
                                        <i class="fas fa-sign-out-alt"></i> Salir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-eco-lime text-eco-dark px-4 py-2 rounded-lg hover:bg-opacity-90 transition font-semibold">
                            Ingresar
                        </a>
                    @endauth
                </div>

                <!-- MOBILE -->
                <div class="md:hidden">
                    <button class="text-2xl" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- MENU MOBILE -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-eco-lime border-opacity-30">
                <a href="#" class="block py-2 text-sm hover:text-eco-lime">Catálogo</a>
                <a href="#" class="block py-2 text-sm hover:text-eco-lime">Sobre Nosotros</a>
                <a href="#" class="block py-2 text-sm hover:text-eco-lime">Nuestro Proceso</a>
            </div>
        </div>
    </nav>

    <!-- ALERTAS -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                <p class="font-bold">¡Error!</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-eco-lime bg-opacity-20 border-l-4 border-eco-lime text-eco-green p-4 mb-4 rounded">
                <p class="font-bold"><i class="fas fa-check"></i> {{ session('success') }}</p>
            </div>
        @endif
    </div>

    <!-- CONTENIDO -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-eco-dark text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <hr class="border-eco-green mb-8">
            <div class="text-center text-gray-400 text-sm">
                <p>&copy; 2024 Eco-Rueda. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- jQuery (ANTES de tu código que usa $) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    </script>

    @stack('scripts')
    @yield('customJs')
</body>
</html>
