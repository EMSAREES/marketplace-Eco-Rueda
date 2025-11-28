<!-- resources/views/vendor/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Panel de Vendedor - Eco-Rueda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- ENCABEZADO -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-eco-dark mb-2">
            <i class="fas fa-store text-eco-green"></i> Panel de Vendedor
        </h1>
        <p class="text-gray-600">Gestiona tus productos, órdenes y ventas</p>
    </div>

    <!-- ESTADÍSTICAS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <!-- Total Productos -->
        <div class="bg-gradient-to-br from-eco-green to-eco-lime text-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-80">Total Productos</p>
                    <p class="text-4xl font-bold">{{ auth()->user()->products->count() }}</p>
                </div>
                <i class="fas fa-chair text-4xl opacity-20"></i>
            </div>
        </div>

        <!-- Total Órdenes -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-80">Órdenes Recibidas</p>
                    <p class="text-4xl font-bold">{{ auth()->user()->orderItems()->distinct('order_id')->count() }}</p>
                </div>
                <i class="fas fa-box text-4xl opacity-20"></i>
            </div>
        </div>

        <!-- Órdenes Pagadas -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-80">Órdenes Pagadas</p>
                    <p class="text-4xl font-bold">{{ auth()->user()->orderItems()->whereHas('order', fn($q) => $q->where('status', 'paid'))->distinct('order_id')->count() }}</p>
                </div>
                <i class="fas fa-credit-card text-4xl opacity-20"></i>
            </div>
        </div>

        <!-- Ingresos -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm opacity-80">Ingresos Totales</p>
                    <p class="text-3xl font-bold">
                        ${{ number_format(auth()->user()->orderItems()->sum('subtotal'), 2) }}
                    </p>
                </div>
                <i class="fas fa-dollar-sign text-4xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- NAVEGACIÓN TABS -->
    <div class="mb-8 flex gap-4 border-b-2 border-eco-sand">
        <button onclick="showTab('productos')" id="btn-tab-productos" class="px-6 py-3 font-bold text-eco-green border-b-4 border-eco-green">
            <i class="fas fa-chair"></i> Mis Productos
        </button>
        <button onclick="showTab('ordenes')" id="btn-tab-ordenes" class="px-6 py-3 font-bold text-gray-600 hover:text-eco-green transition">
            <i class="fas fa-box"></i> Órdenes Recibidas
        </button>
    </div>

    <!-- TAB 1: PRODUCTOS -->
    <div id="tab-productos" class="tab-content">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-eco-dark">Mis Productos</h2>
            <a href="{{ route('vendor.products.create') }}" class="bg-eco-green text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition font-bold">
                <i class="fas fa-plus"></i> Agregar Producto
            </a>
        </div>

        @if(auth()->user()->products->count())
            <div class="space-y-4">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="flex gap-6 p-6">
                            <!-- IMAGEN -->
                            <div class="w-32 h-32 bg-eco-sand rounded-lg flex items-center justify-center flex-shrink-0">
                                @if($product->getFeaturedImage())
                                    <img src="{{ $product->getFeaturedImage()->getUrl() }}" alt="{{ $product->name }}">
                                @else
                                    <i class="fas fa-chair text-4xl text-eco-green opacity-30"></i>
                                @endif
                            </div>

                            <!-- INFO -->
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-eco-dark mb-2">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Precio</p>
                                        <p class="font-bold text-eco-green">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Stock</p>
                                        <p class="font-bold">
                                            <span class="@if($product->stock > 0) text-green-600 @else text-red-600 @endif">
                                                {{ $product->stock }} unidades
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Material</p>
                                        <p class="font-bold text-eco-dark">{{ $product->material }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Imágenes</p>
                                        <p class="font-bold text-eco-dark">{{ $product->images->count() }}</p>
                                    </div>
                                </div>

                                @if(!$product->is_active)
                                    <span class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-bold mb-3">
                                        <i class="fas fa-eye-slash"></i> Inactivo
                                    </span>
                                @endif
                            </div>

                            <!-- ACCIONES -->
                            <div class="flex flex-col gap-2 justify-center">
                                <a href="{{ route('vendor.products.edit', $product->id) }}" class="bg-eco-green text-white px-4 py-2 rounded hover:bg-opacity-90 transition text-sm font-bold">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button id="deleteproducto"
                                    class="btn-delete-product w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-sm font-bold"
                                    data-id="{{ $product->id }}"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-eco-sand rounded-lg">
                <i class="fas fa-box-open text-6xl text-eco-green opacity-30 mb-4 block"></i>
                <p class="text-gray-600 mb-6">No tienes productos aún</p>
                <a href="{{ route('vendor.products.create') }}" class="inline-block bg-eco-green text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition font-bold">
                    <i class="fas fa-plus"></i> Agregar Mi Primer Producto
                </a>
            </div>
        @endif
    </div>

    <!-- TAB 2: ÓRDENES -->
    <div id="tab-ordenes" class="tab-content hidden">
        <h2 class="text-2xl font-bold text-eco-dark mb-8">Órdenes Recibidas</h2>

        @php
            $vendorOrders = $orders;
        @endphp

        @if($vendorOrders->count())
            <div class="space-y-4">
                @foreach($vendorOrders as $orderId => $items)
                    @php
                        $order = $items->first()->order;
                        $total = $items->sum('subtotal');
                    @endphp
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="bg-gradient-to-r from-eco-green to-eco-lime text-white p-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm opacity-80">Orden #{{ $order->id }}</p>
                                    <p class="text-xl font-bold">{{ $order->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm opacity-80">Cliente</p>
                                    <p class="font-bold">{{ $order->customer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm opacity-80">Total</p>
                                    <p class="text-xl font-bold text-eco-lime">${{ number_format($total, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm opacity-80">Estado</p>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-bold mt-1
                                        @if($order->status === 'completed') bg-green-500
                                        @elseif($order->status === 'paid') bg-yellow-500
                                        @elseif($order->status === 'cancelled') bg-red-500
                                        @else bg-gray-500
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h4 class="font-bold text-eco-dark mb-4">Productos en esta Orden:</h4>
                            <div class="space-y-3 mb-6">
                                @foreach($items as $item)
                                    <div class="flex justify-between items-center p-3 bg-eco-sand rounded">
                                        <div>
                                            <p class="font-bold text-eco-dark"> {{ $item->product?->name ?? 'Producto no disponible' }}
</p>
                                            <p class="text-xs text-gray-600">Cantidad: {{ $item->quantity }}</p>
                                        </div>
                                        <p class="font-bold text-eco-green">${{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Dirección de Envío -->
                            <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded mb-4">
                                <p class="text-sm font-bold text-blue-900 mb-2">
                                    <i class="fas fa-map-marker-alt"></i> Enviar a:
                                </p>
                                <p class="text-sm text-blue-700">
                                    {{ $order->shipping_name }}<br>
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}
                                </p>
                            </div>

                            <!-- Acciones -->
                            <div class="flex gap-3">
                                <a href="tel:{{ $order->shipping_phone }}" class="flex-1 bg-green-500 text-white py-2 rounded hover:bg-green-600 transition text-center font-semibold">
                                    <i class="fas fa-phone"></i> Llamar
                                </a>
                                <a href="https://wa.me/52{{ str_replace([' ', '-', '(', ')'], '', $order->shipping_phone) }}" target="_blank" class="flex-1 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition text-center font-semibold">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                @if($order->status !== 'completed')
                                   {{-- <form action="{{ route('vendor.orders.update-status', $order->id) }}" method="POST" class="flex-1">
                                        @csrf
                                         <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 border-2 border-eco-green rounded text-sm">
                                            <option value="">Cambiar Estado</option>
                                            <option value="shipped">Enviado</option>
                                            <option value="completed">Completado</option>
                                        </select>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-eco-sand rounded-lg">
                <i class="fas fa-inbox text-6xl text-eco-green opacity-30 mb-4 block"></i>
                <p class="text-gray-600">No tienes órdenes aún</p>
            </div>
        @endif
    </div>
</div>

<script>
    function showTab(tabName) {
        // Ocultar todos los tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Remover estilos activos de botones
        document.querySelectorAll('[id^="btn-tab-"]').forEach(btn => {
            btn.classList.remove('border-b-4', 'border-eco-green', 'text-eco-green');
            btn.classList.add('text-gray-600', 'hover:text-eco-green');
        });

        // Mostrar tab seleccionado
        document.getElementById('tab-' + tabName).classList.remove('hidden');
        document.getElementById('btn-tab-' + tabName).classList.add('border-b-4', 'border-eco-green', 'text-eco-green');
    }

    $('.btn-delete-product').click(function() {
            if (!confirm('¿Estás seguro de eliminar este producto?')) return;

            let proId = $(this).data('id');

            $.ajax({
                url: '{{ route("vendor.products.destroy", ":id") }}'.replace(':id', proId),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == true) {
                        window.location.href = "{{ route('vendor.dashboard') }}";
                    }
                },
                error: function(xhr) {
                    alert('Ocurrió un error al eliminar el producto');
                }
            });
    });
</script>

@endsection
