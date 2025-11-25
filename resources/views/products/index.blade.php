<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')
<!-- HERO SECTION -->
<section class="relative h-96 bg-gradient-to-r from-eco-green to-eco-lime overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <i class="fas fa-recycle absolute text-8xl top-10 left-10"></i>
        <i class="fas fa-leaf absolute text-8xl bottom-10 right-10"></i>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
        <div class="text-white">
            <h1 class="text-5xl font-bold mb-4">Nuestras Sillas Sostenibles</h1>
            <p class="text-xl mb-6 opacity-90">Muebles únicos hechos con materiales 100% reciclados</p>
            <div class="flex gap-4">
                <a href="#catalogo" class="bg-white text-eco-green px-6 py-3 rounded-lg font-bold hover:bg-eco-sand transition">
                    Ver Catálogo ↓
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FILTROS Y BÚSQUEDA -->
<section class="bg-white py-8 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('products.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Búsqueda -->
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-4 text-eco-green"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Buscar sillas..."
                        class="w-full pl-10 pr-4 py-2 border-2 border-eco-green rounded-lg">
                </div>

                <!-- Material -->
                <select name="material"
                    class="w-full px-4 py-2 border-2 border-eco-green rounded-lg">
                    <option value="all">Todos los Materiales</option>
                    <option value="Llantas de Auto" {{ request('material') == 'Llantas de Auto' ? 'selected' : '' }}>Llantas de Auto</option>
                    <option value="Costales Reciclados" {{ request('material') == 'Costales Reciclados' ? 'selected' : '' }}>Costales Reciclados</option>
                    <option value="Madera Recuperada" {{ request('material') == 'Madera Recuperada' ? 'selected' : '' }}>Madera Recuperada</option>
                    <option value="Plástico Reciclado" {{ request('material') == 'Plástico Reciclado' ? 'selected' : '' }}>Plástico Reciclado</option>
                </select>

                <!-- Precio -->
                <select name="price"
                    class="w-full px-4 py-2 border-2 border-eco-green rounded-lg">
                    <option value="all">Todos los Precios</option>
                    <option value="lt50"     {{ request('price') == 'lt50' ? 'selected' : '' }}>Menos de $50</option>
                    <option value="50-100"   {{ request('price') == '50-100' ? 'selected' : '' }}>$50 - $100</option>
                    <option value="100-200"  {{ request('price') == '100-200' ? 'selected' : '' }}>$100 - $200</option>
                    <option value="gt200"    {{ request('price') == 'gt200' ? 'selected' : '' }}>Más de $200</option>
                </select>

            </div>

            <button type="submit"
                class="mt-4 bg-eco-green text-white px-6 py-2 rounded-lg font-bold">
                Aplicar Filtros
            </button>

        </form>
    </div>
</section>


<!-- CATÁLOGO DE PRODUCTOS -->
<section id="catalogo" class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-12 text-center text-eco-green">Nuestras Creaciones</h2>

        @if($products->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 group">
                        <!-- IMAGEN PRODUCTO -->
                        <div class="relative h-80 bg-eco-sand overflow-hidden">
                            @if($product->getFeaturedImage())
                                <img src="{{ $product->getFeaturedImage()->getUrl() }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-eco-green text-6xl">
                                    <i class="fas fa-chair"></i>
                                </div>
                            @endif

                            <!-- BADGE MATERIAL -->
                            <div class="absolute top-4 right-4 bg-eco-lime text-eco-dark px-3 py-1 rounded-full text-xs font-bold">
                                <i class="fas fa-leaf"></i> {{ $product->material }}
                            </div>

                            <!-- BADGE STOCK -->
                            @if($product->stock > 0)
                                <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    En Stock ({{ $product->stock }})
                                </div>
                            @else
                                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    Agotado
                                </div>
                            @endif
                        </div>

                        <!-- INFO PRODUCTO -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-eco-dark mb-2 line-clamp-2">{{ $product->name }}</h3>

                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-eco-green"><i class="fas fa-palette"></i></span>
                                <span class="text-sm text-gray-600">{{ $product->color ?? 'Natural' }}</span>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                            <!-- VENDEDOR -->
                            <div class="mb-4 pb-4 border-b border-eco-sand">
                                <p class="text-xs text-eco-green font-semibold">
                                    <i class="fas fa-store"></i> {{ $product->vendor->name }}
                                </p>
                            </div>

                            <!-- PRECIO -->
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-2xl font-bold text-eco-green">${{ number_format($product->price, 2) }}</span>
                            </div>

                            <!-- BOTONES -->
                            <div class="flex gap-3">
                                <a href="{{ route('products.show', $product->id) }}"
                                    class="flex-1 bg-eco-green text-white py-2 rounded-lg hover:bg-opacity-90 transition text-center font-semibold">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                                @if($product->stock > 0)
                                    <form action="{{-- {{ route('cart.add', $product->id) }} --}}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-eco-lime text-eco-dark py-2 rounded-lg hover:bg-opacity-90 transition font-semibold">
                                            <i class="fas fa-shopping-cart"></i> Agregar
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="flex-1 bg-gray-400 text-white py-2 rounded-lg cursor-not-allowed opacity-60 font-semibold">
                                        Agotado
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- PAGINACIÓN -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-box text-6xl text-eco-green opacity-30 mb-4"></i>
                <p class="text-xl text-gray-600">No hay productos disponibles en este momento</p>
            </div>
        @endif
    </div>
</section>

<!-- INFORMACIÓN SOSTENIBLE -->
<section class="bg-eco-green text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-12 text-center">¿Por Qué Eco-Rueda?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <i class="fas fa-recycle text-5xl text-eco-lime mb-4"></i>
                <h3 class="text-xl font-bold mb-2">100% Reciclado</h3>
                <p class="text-sm opacity-90">Todos nuestros muebles están hechos con materiales reciclados de alta calidad</p>
            </div>
            <div class="text-center">
                <i class="fas fa-leaf text-5xl text-eco-lime mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Sostenible</h3>
                <p class="text-sm opacity-90">Reducimos desperdicios y contribuimos a un planeta más verde</p>
            </div>
            <div class="text-center">
                <i class="fas fa-hammer text-5xl text-eco-lime mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Artesanal</h3>
                <p class="text-sm opacity-90">Cada silla es única y hecha con cuidado y detalle</p>
            </div>
        </div>
    </div>
</section>

@endsection
