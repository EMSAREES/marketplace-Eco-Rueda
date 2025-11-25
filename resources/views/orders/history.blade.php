<!-- resources/views/orders/history.blade.php -->
@extends('layouts.app')

@section('title', 'Mis Compras')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-eco-dark mb-2">
        <i class="fas fa-history text-eco-green"></i> Mis Compras
    </h1>
    <p class="text-gray-600 mb-12">Historial de tus órdenes y transacciones</p>

    @if($orders->count())
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <!-- ENCABEZADO -->
                    <div class="bg-gradient-to-r from-eco-green to-eco-lime p-6 text-white">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm opacity-80">Orden #</p>
                                <p class="text-xl font-bold">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-80">Fecha</p>
                                <p class="text-lg font-bold">{{ $order->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-80">Total</p>
                                <p class="text-2xl font-bold text-eco-lime">${{ number_format($order->total * 1.16, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-80">Estado</p>
                                <span class="inline-block mt-1 px-4 py-1 rounded-full text-sm font-bold
                                    @if($order->status === 'completed') bg-green-500
                                    @elseif($order->status === 'shipped') bg-blue-500
                                    @elseif($order->status === 'paid') bg-yellow-500
                                    @elseif($order->status === 'cancelled') bg-red-500
                                    @else bg-gray-500
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENIDO ORDEN -->
                    <div class="p-6">
                        <!-- INFORMACIÓN DE ENVÍO -->
                        <div class="mb-6 p-4 bg-eco-sand rounded-lg">
                            <h3 class="font-bold text-eco-dark mb-3">
                                <i class="fas fa-map-marker-alt text-eco-green"></i> Dirección de Envío
                            </h3>
                            <p class="text-sm text-gray-700">
                                {{ $order->shipping_name }}<br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                                {{ $order->shipping_country }}<br>
                                <strong>Tel:</strong> {{ $order->shipping_phone }}
                            </p>
                        </div>

                        <!-- ITEMS DE LA ORDEN -->
                        <div class="mb-6">
                            <h3 class="font-bold text-eco-dark mb-4">
                                <i class="fas fa-box text-eco-green"></i> Productos
                            </h3>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between items-center p-4 bg-eco-sand rounded-lg">
                                        <div>
                                            <p class="font-bold text-eco-dark">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-600">Vendedor: {{ $item->vendor->name }}</p>
                                            <p class="text-sm text-gray-700">Cantidad: <strong>{{ $item->quantity }}</strong></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-eco-green">${{ number_format($item->subtotal, 2) }}</p>
                                            <p class="text-xs text-gray-600">${{ number_format($item->price, 2) }} c/u</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- RESUMEN FINANCIERO -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg border-l-4 border-eco-green">
                            <div>
                                <p class="text-xs text-gray-600">Subtotal</p>
                                <p class="text-lg font-bold text-eco-dark">${{ number_format($order->total, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Impuestos (16%)</p>
                                <p class="text-lg font-bold text-eco-dark">${{ number_format($order->total * 0.16, 2) }}</p>
                            </div>
                            <div class="md:text-right">
                                <p class="text-xs text-gray-600">Total Pagado</p>
                                <p class="text-xl font-bold text-eco-green">${{ number_format($order->total * 1.16, 2) }}</p>
                            </div>
                        </div>

                        <!-- INFORMACIÓN DE PAGO -->
                        @if($order->payment)
                            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-bold text-blue-900">
                                            <i class="fas fa-credit-card text-blue-500"></i> Pago Procesado
                                        </p>
                                        <p class="text-xs text-blue-700">
                                            ID Transacción: {{ $order->payment->stripe_payment_id ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <span class="px-4 py-2 bg-green-500 text-white rounded font-bold text-sm">
                                        {{ ucfirst($order->payment->status) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- ACCIONES -->
                    <div class="bg-eco-sand p-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Realizado el {{ $order->created_at->format('d \d\e M \d\e Y \a \l\a\s H:i') }}
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('orders.show', $order->id) }}" class="bg-eco-green text-white px-4 py-2 rounded hover:bg-opacity-90 transition text-sm font-semibold">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                            @if($order->status !== 'cancelled')
                                <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition text-sm font-semibold">
                                    <i class="fas fa-download"></i> Descargar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-12">
            {{ $orders->links() }}
        </div>
    @else
        <!-- SIN ÓRDENES -->
        <div class="text-center py-16">
            <i class="fas fa-shopping-bag text-8xl text-eco-green opacity-20 mb-4 block"></i>
            <h2 class="text-2xl font-bold text-eco-dark mb-4">No tienes compras aún</h2>
            <p class="text-gray-600 mb-8">¡Comienza a explorar nuestras sillas sostenibles!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-eco-green text-white px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition">
                <i class="fas fa-arrow-left"></i> Ir al Catálogo
            </a>
        </div>
    @endif
</div>

@endsection
