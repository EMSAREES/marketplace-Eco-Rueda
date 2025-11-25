<!-- resources/views/cart/index.blade.php -->
@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- BREADCRUMB -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-eco-dark mb-2">
            <i class="fas fa-shopping-cart text-eco-green"></i> Tu Carrito
        </h1>
        <a href="{{ route('products.index') }}" class="text-eco-green hover:text-eco-lime transition">
            <i class="fas fa-arrow-left"></i> Seguir Comprando
        </a>
    </div>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- ITEMS DEL CARRITO -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- ENCABEZADO -->
                    <div class="bg-eco-green text-white p-4 font-bold grid grid-cols-12 gap-4">
                        <div class="col-span-4">Producto</div>
                        <div class="col-span-2 text-center">Precio</div>
                        <div class="col-span-2 text-center">Cantidad</div>
                        <div class="col-span-2 text-center">Subtotal</div>
                        <div class="col-span-2 text-center">Acción</div>
                    </div>

                    <!-- ITEMS -->
                    @php
                        $total = 0;
                        $items = session('cart', []);
                    @endphp

                    @foreach($items as $productId => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <div class="border-b border-eco-sand p-4 grid grid-cols-12 gap-4 items-center hover:bg-eco-sand transition">
                            <!-- Producto -->
                            <div class="col-span-4">
                                <div class="flex gap-3">
                                    @if(isset($item['image']))
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <div class="w-16 h-16 bg-eco-sand rounded flex items-center justify-center">
                                            <i class="fas fa-chair text-eco-green text-2xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-eco-dark">{{ $item['name'] }}</p>
                                        <p class="text-xs text-gray-600">{{ $item['material'] ?? 'Material' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Precio -->
                            <div class="col-span-2 text-center">
                                <p class="font-bold text-eco-green">${{ number_format($item['price'], 2) }}</p>
                            </div>

                            <!-- Cantidad -->
                            <div class="col-span-2">
                                <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    <button type="submit" name="action" value="decrease" class="px-2 py-1 bg-eco-sand rounded text-eco-green hover:bg-eco-lime hover:text-eco-dark transition">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                    <input type="number" value="{{ $item['quantity'] }}" readonly class="w-10 text-center border border-eco-green rounded">
                                    <button type="submit" name="action" value="increase" class="px-2 py-1 bg-eco-sand rounded text-eco-green hover:bg-eco-lime hover:text-eco-dark transition">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Subtotal -->
                            <div class="col-span-2 text-center">
                                <p class="font-bold text-eco-dark">${{ number_format($subtotal, 2) }}</p>
                            </div>

                            <!-- Eliminar -->
                            <div class="col-span-2 text-center">
                                <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- BOTÓN VACIAR CARRITO -->
                @if(count($items) > 0)
                    <div class="mt-4 flex justify-end">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 transition font-semibold text-sm">
                                <i class="fas fa-trash-alt"></i> Vaciar Carrito
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- RESUMEN DE ORDEN -->
            <div class="h-fit">
                <div class="bg-eco-green text-white rounded-lg shadow-lg p-8 space-y-6">
                    <h2 class="text-2xl font-bold">Resumen de Orden</h2>

                    <!-- Detalles -->
                    <div class="space-y-4 border-t border-eco-lime border-opacity-30 pt-4">
                        <div class="flex justify-between items-center">
                            <span>Subtotal</span>
                            <span class="font-bold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Envío (Estimado)</span>
                            <span class="font-bold">Gratis</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Impuestos (16%)</span>
                            <span class="font-bold">${{ number_format($total * 0.16, 2) }}</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-eco-lime border-opacity-30 pt-4">
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-bold">Total</span>
                            <span class="text-2xl font-bold text-eco-lime">
                                ${{ number_format($total * 1.16, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Botón Checkout -->
                    @auth
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-eco-lime text-eco-dark py-3 rounded-lg font-bold text-center hover:bg-opacity-90 transition">
                            <i class="fas fa-lock"></i> Proceder al Pago
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-eco-lime text-eco-dark py-3 rounded-lg font-bold text-center hover:bg-opacity-90 transition">
                            <i class="fas fa-sign-in-alt"></i> Inicia Sesión para Comprar
                        </a>
                    @endauth

                    <!-- Métodos de Pago -->
                    <div class="bg-white bg-opacity-10 rounded p-4">
                        <p class="text-sm mb-3 font-semibold">Métodos de Pago Disponibles:</p>
                        <div class="flex gap-2">
                            <i class="fab fa-cc-stripe text-2xl"></i>
                            <i class="fab fa-cc-visa text-2xl"></i>
                            <i class="fab fa-cc-mastercard text-2xl"></i>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="bg-white bg-opacity-10 rounded p-3 text-xs">
                        <p><i class="fas fa-info-circle"></i> Recibirás un email de confirmación después del pago</p>
                    </div>
                </div>

                <!-- BENEFICIOS -->
                <div class="mt-6 space-y-3">
                    <div class="bg-eco-lime bg-opacity-20 rounded p-4">
                        <p class="text-sm text-eco-green font-semibold">
                            <i class="fas fa-shield-alt"></i> Compra Segura
                        </p>
                    </div>
                    <div class="bg-eco-lime bg-opacity-20 rounded p-4">
                        <p class="text-sm text-eco-green font-semibold">
                            <i class="fas fa-truck"></i> Envío a Toda México
                        </p>
                    </div>
                    <div class="bg-eco-lime bg-opacity-20 rounded p-4">
                        <p class="text-sm text-eco-green font-semibold">
                            <i class="fas fa-recycle"></i> Empaques Reciclados
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- CARRITO VACÍO -->
        <div class="text-center py-16">
            <i class="fas fa-shopping-cart text-8xl text-eco-green opacity-20 mb-4 block"></i>
            <h2 class="text-2xl font-bold text-eco-dark mb-4">Tu carrito está vacío</h2>
            <p class="text-gray-600 mb-8">Explora nuestras sillas sostenibles y agrega algunas a tu carrito</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-eco-green text-white px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition">
                <i class="fas fa-arrow-left"></i> Ver Catálogo
            </a>
        </div>
    @endif
</div>

@endsection
