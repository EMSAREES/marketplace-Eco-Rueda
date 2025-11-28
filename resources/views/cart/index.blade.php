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

    <!-- ALERTAS -->
    <div id="alertContainer" class="mb-4"></div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- ================= ITEMS DEL CARRITO ================= -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">

                <!-- ENCABEZADO -->
                <div class="bg-eco-green text-white p-4 font-bold grid grid-cols-12 gap-4 sticky top-0 z-10">
                    <div class="col-span-4">Producto</div>
                    <div class="col-span-2 text-center">Precio</div>
                    <div class="col-span-2 text-center">Cantidad</div>
                    <div class="col-span-2 text-center">Subtotal</div>
                    <div class="col-span-2 text-center">Acción</div>
                </div>

                <!-- ITEMS -->
                <div id="cartItemsContainer">
                    @php $total = 0; @endphp

                    @if($items->count() > 0)
                        @foreach($items as $item)
                            @php
                                $product = $item->product;
                                $subtotal = $item->price * $item->quantity;
                                $total += $subtotal;
                            @endphp

                            @include('cart.partials.cart-item', [
                                'item' => [
                                    'name' => $product->name,
                                    'price' => $item->price,
                                    'quantity' => $item->quantity,
                                    'image' => $product->image_url ?? ''
                                ],
                                'productId' => $product->id,
                                'subtotal' => $subtotal
                            ])
                        @endforeach

                    @else
                        <div id="emptyCartMessage" class="p-8 text-center">
                            <i class="fas fa-shopping-cart text-6xl text-eco-green opacity-20 mb-4 block"></i>
                            <p class="text-gray-600">Tu carrito está vacío</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BOTÓN VACIAR CARRITO -->
            @if($items->count() > 0)
                <div class="mt-4 flex justify-end">
                    <button type="button" id="clearCartBtn" onclick="clearCart()" class="text-red-500 hover:text-red-700 transition font-semibold text-sm">
                        <i class="fas fa-trash-alt"></i> Vaciar Carrito
                    </button>
                </div>
            @endif

        </div>

        <!-- ================= SIDEBAR RESUMEN ================= -->
        <div class="h-fit sticky top-20">
            <div class="bg-eco-green text-white rounded-lg shadow-lg p-8 space-y-6">

                <h2 class="text-2xl font-bold">Resumen de Orden</h2>

                <div class="space-y-4 border-t border-eco-lime border-opacity-30 pt-4">
                    <div class="flex justify-between items-center">
                        <span>Subtotal</span>
                        <span class="font-bold" id="subtotalDisplay">${{ number_format($total, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span>Envío (Estimado)</span>
                        <span class="font-bold">Gratis</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span>Impuestos (16%)</span>
                        <span class="font-bold" id="taxDisplay">${{ number_format($total * 0.16, 2) }}</span>
                    </div>
                </div>

                <div class="border-t border-eco-lime border-opacity-30 pt-4">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-bold">Total</span>
                        <span class="text-2xl font-bold text-eco-lime" id="totalDisplay">
                            ${{ number_format($total * 1.16, 2) }}
                        </span>
                    </div>
                </div>

                @auth
                    <a href="{{ route('checkout.index') }}"
                       class="block w-full bg-eco-lime text-eco-dark py-3 rounded-lg font-bold text-center hover:bg-opacity-90 transition"
                       id="checkoutBtn"
                       @if($items->count() == 0) style="pointer-events:none;opacity:0.5;" @endif>
                        <i class="fas fa-lock"></i> Proceder al Pago
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="block w-full bg-eco-lime text-eco-dark py-3 rounded-lg font-bold text-center hover:bg-opacity-90 transition">
                        <i class="fas fa-sign-in-alt"></i> Inicia Sesión para Comprar
                    </a>
                @endauth

                <div class="bg-white bg-opacity-10 rounded p-4">
                    <p class="text-sm mb-3 font-semibold">Métodos de Pago Disponibles:</p>
                    <div class="flex gap-2">
                        <i class="fab fa-cc-stripe text-2xl"></i>
                        <i class="fab fa-cc-visa text-2xl"></i>
                        <i class="fab fa-cc-mastercard text-2xl"></i>
                    </div>
                </div>

                <div class="bg-white bg-opacity-10 rounded p-3 text-xs">
                    <p><i class="fas fa-info-circle"></i> Recibirás un email de confirmación después del pago</p>
                </div>

            </div>
        </div>

    </div>
</div>


<!-- ==================== JS DE CARRITO ==================== -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    // ================= AGREGAR AL CARRITO =================
    function addToCart(productId) {
        $.ajax({
            url: '{{ route("cart.add", ":id") }}'.replace(':id', productId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateCartUI(response);
                    showAlert(response.message, 'success');
                } else {
                    showAlert(response.message, 'error');
                }
            }
        });
    }

    // ================= CAMBIAR CANTIDAD =================
    function updateQuantity(productId, action) {
        $.ajax({
            url: '{{ route("cart.update", ":id") }}'.replace(':id', productId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: action
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload(); // más seguro actualizar todo
                }
            }
        });
    }

    // ================= REMOVER ITEM =================
    function removeFromCart(productId) {
        if (!confirm('¿Deseas remover este producto del carrito?')) return;

        $.ajax({
            url: '{{ route("cart.remove", ":id") }}'.replace(':id', productId),
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }

    // ================= VACIAR CARRITO =================
    function clearCart() {
        if (!confirm('¿Deseas vaciar todo el carrito?')) return;

        $.ajax({
            url: '{{ route("cart.clear") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }

    // ================ ACTUALIZAR UI =================
    function updateCartUI(data) {
        const subtotal = data.cartTotal;
        $('#subtotalDisplay').text('$' + subtotal.toFixed(2));
        $('#taxDisplay').text('$' + (subtotal * 0.16).toFixed(2));
        $('#totalDisplay').text('$' + (subtotal * 1.16).toFixed(2));
    }

    // ================ ALERTAS ================
    function showAlert(message, type = 'info') {
        const alert = `
            <div class="alert bg-${type === 'success' ? 'green' : 'red'}-200 text-${type === 'success' ? 'green' : 'red'}-800 border-l-4 px-4 py-3 rounded mb-2">
                ${message}
            </div>
        `;
        $('#alertContainer').append(alert);
        setTimeout(() => $('.alert').fadeOut(), 2000);
    }

</script>

@endsection
