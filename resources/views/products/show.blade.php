<!-- resources/views/products/show.blade.php -->
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- BREADCRUMB -->
    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="text-eco-green hover:text-eco-lime transition">
            <i class="fas fa-arrow-left"></i> Volver al Catálogo
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- GALERÍA DE IMÁGENES -->
        <div>
            <!-- Imagen Principal -->
            <div class="mb-6">
                <div class="bg-eco-sand rounded-lg overflow-hidden h-96 md:h-[500px] flex items-center justify-center relative group">
                    <img id="mainImage"
                        src="{{ $product->getFeaturedImage()?->getUrl() ?? 'https://via.placeholder.com/500x500?text=Sin+Imagen' }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Miniaturas -->
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                        <button onclick="changeImage('{{ $image->getUrl() }}')"
                            class="border-2 border-eco-green rounded-lg overflow-hidden hover:border-eco-lime transition h-20">
                            <img src="{{ $image->getUrl() }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- INFORMACIÓN DEL PRODUCTO -->
        <div>
            <!-- Material Badge -->
            <div class="mb-4">
                <span class="inline-block bg-eco-lime text-eco-dark px-4 py-2 rounded-full text-sm font-bold">
                    <i class="fas fa-leaf"></i> {{ $product->material }}
                </span>
            </div>

            <!-- Título -->
            <h1 class="text-4xl font-bold text-eco-dark mb-2">{{ $product->name }}</h1>

            <!-- Vendedor -->
            <div class="flex items-center gap-2 mb-6 pb-6 border-b-2 border-eco-sand">
                <i class="fas fa-store text-eco-green text-xl"></i>
                <p class="text-eco-green font-semibold">{{ $product->vendor->name }}</p>
            </div>

            <!-- Descripción -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-eco-dark mb-3">Descripción</h2>
                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Características -->
            <div class="grid grid-cols-2 gap-4 mb-8 p-4 bg-eco-sand rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Color</p>
                    <p class="font-bold text-eco-dark">{{ $product->color ?? 'Natural' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Material</p>
                    <p class="font-bold text-eco-dark">{{ $product->material }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">En Stock</p>
                    <p class="font-bold text-eco-green">{{ $product->stock }} unidades</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Vendedor</p>
                    <p class="font-bold text-eco-dark">{{ $product->vendor->name }}</p>
                </div>
            </div>

            <!-- PRECIO Y COMPRA -->
            <div class="bg-white border-2 border-eco-green rounded-lg p-8 mb-8">
                <div class="mb-8">
                    <p class="text-gray-600 text-sm mb-2">Precio</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-bold text-eco-green">${{ number_format($product->price, 2) }}</span>
                        <span class="text-gray-500">MXN</span>
                    </div>
                </div>

                <!-- Stock Status -->
                <div class="mb-8">
                    @if($product->stock > 0)
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <p class="text-green-700 font-semibold">
                                <i class="fas fa-check-circle"></i> ¡Disponible! ({{ $product->stock }} en stock)
                            </p>
                        </div>
                    @else
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <p class="text-red-700 font-semibold">
                                <i class="fas fa-times-circle"></i> Producto agotado
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Cantidad y Carrito -->
                @if($product->stock > 0)
                    <form action="{{-- {{ route('cart.add', $product->id) }} --}}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Cantidad</label>
                            <div class="flex items-center border-2 border-eco-green rounded-lg w-fit">
                                <button type="button" onclick="decreaseQty()" class="px-4 py-2 text-eco-green hover:bg-eco-sand">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                    class="w-16 text-center border-0 focus:outline-none">
                                <button type="button" onclick="increaseQty({{ $product->stock }})" class="px-4 py-2 text-eco-green hover:bg-eco-sand">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-eco-lime text-eco-dark py-4 rounded-lg font-bold text-lg hover:bg-opacity-90 transition">
                            <i class="fas fa-shopping-cart"></i> Agregar al Carrito
                        </button>
                    </form>
                @else
                    <button disabled class="w-full bg-gray-400 text-white py-4 rounded-lg font-bold text-lg cursor-not-allowed opacity-60">
                        Producto Agotado
                    </button>
                @endif
            </div>

            <!-- Información Sostenible -->
            <div class="bg-eco-green bg-opacity-10 border-l-4 border-eco-green p-4 rounded">
                <p class="text-eco-green font-bold mb-2">
                    <i class="fas fa-recycle"></i> 100% Producto Reciclado
                </p>
                <p class="text-sm text-gray-700">
                    Esta silla fue creada con materiales reutilizados, contribuyendo a un planeta más sostenible.
                </p>
            </div>
        </div>
    </div>

    <!-- PRODUCTOS RELACIONADOS -->
    @if($product->vendor->products->count() > 1)
        <section class="mt-20 pt-12 border-t-2 border-eco-sand">
            <h2 class="text-3xl font-bold text-eco-dark mb-8">Más del Vendedor</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($product->vendor->products->where('id', '!=', $product->id)->take(3) as $related)
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition">
                        <div class="h-60 bg-eco-sand flex items-center justify-center overflow-hidden">
                            @if($related->getFeaturedImage())
                                <img src="{{ $related->getFeaturedImage()->getUrl() }}"
                                    alt="{{ $related->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-chair text-6xl text-eco-green opacity-30"></i>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-eco-dark mb-2 line-clamp-2">{{ $related->name }}</h3>
                            <p class="text-2xl font-bold text-eco-green mb-3">${{ number_format($related->price, 2) }}</p>
                            <a href="{{ route('products.show', $related->id) }}"
                                class="block text-center bg-eco-green text-white py-2 rounded hover:bg-opacity-90 transition">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function increaseQty(max) {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>

@endsection
