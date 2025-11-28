<!-- resources/views/checkout/success.blade.php -->
@extends('layouts.app')

@section('title', 'Compra Exitosa - Eco-Rueda')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- MENSAJE DE ÉXITO -->
    <div class="text-center mb-12">
        <div class="inline-block bg-green-100 rounded-full p-6 mb-6">
            <i class="fas fa-check-circle text-green-600 text-6xl"></i>
        </div>
        <h1 class="text-4xl font-bold text-eco-dark mb-4">¡Compra Exitosa!</h1>
        <p class="text-xl text-gray-600">Tu orden ha sido procesada correctamente</p>
    </div>

    <!-- INFORMACIÓN DE LA ORDEN -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <!-- ENCABEZADO -->
        <div class="bg-eco-green text-white p-6">
            <h2 class="text-2xl font-bold">Número de Orden: #{{ $order->id }}</h2>
            <p class="text-sm opacity-90 mt-2">{{ $order->created_at->format('d \d\e F \d\e Y \a \l\a\s H:i') }}</p>
        </div>

        <!-- CONTENIDO -->
        <div class="p-8 space-y-8">
            <!-- ESTADO DE PAGO -->
            <div class="p-6 bg-green-50 border-l-4 border-green-500 rounded">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    <div>
                        <p class="font-bold text-green-900">Pago Confirmado</p>
                        <p class="text-sm text-green-700">Tu pago ha sido procesado exitosamente</p>
                    </div>
                </div>
            </div>

            <!-- PRODUCTOS ORDENADOS -->
            <div>
                <h3 class="text-xl font-bold text-eco-dark mb-4">
                    <i class="fas fa-box text-eco-green"></i> Productos Ordenados
                </h3>
                <div class="space-y-3 bg-eco-sand rounded-lg p-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center pb-3 border-b border-gray-300 last:border-b-0">
                            <div>
                                <p class="font-bold text-eco-dark">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-600">
                                    Vendedor: {{ $item->vendor->name }}
                                </p>
                                <p class="text-sm text-gray-700">Cantidad: <strong>{{ $item->quantity }}</strong></p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-eco-green">${{ number_format($item->subtotal, 2) }}</p>
                                <p class="text-xs text-gray-600">${{ number_format($item->price, 2) }} c/u</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- INFORMACIÓN DE ENVÍO -->
            <div>
                <h3 class="text-xl font-bold text-eco-dark mb-4">
                    <i class="fas fa-truck text-eco-green"></i> Información de Envío
                </h3>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <p class="font-bold text-eco-dark mb-2">{{ $order->shipping_name }}</p>
                    <p class="text-gray-700">{{ $order->shipping_address }}</p>
                    <p class="text-gray-700">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                    <p class="text-gray-700">{{ $order->shipping_postal_code }} - {{ $order->shipping_country }}</p>
                    <p class="text-gray-700 mt-2">
                        <strong>Teléfono:</strong> {{ $order->shipping_phone }}
                    </p>
                </div>
            </div>

            <!-- RESUMEN FINANCIERO -->
            <div>
                <h3 class="text-xl font-bold text-eco-dark mb-4">
                    <i class="fas fa-receipt text-eco-green"></i> Resumen de Pago
                </h3>
                <div class="space-y-3 border-t-2 border-b-2 border-eco-green py-4 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-700">Subtotal</span>
                        <span class="font-bold text-eco-dark">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-700">Envío</span>
                        <span class="font-bold text-eco-dark">Gratis</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-700">Impuestos (16%)</span>
                        <span class="font-bold text-eco-dark">${{ number_format($order->total * 0.16, 2) }}</span>
                    </div>
                </div>

                <!-- TOTAL -->
                <div class="bg-eco-lime bg-opacity-20 rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-eco-dark">Total Pagado</span>
                        <span class="text-4xl font-bold text-eco-green">
                            ${{ number_format($order->total * 1.16, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- INFORMACIÓN DE CONTACTO -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-700">
                    <i class="fas fa-envelope text-eco-green"></i>
                    <strong>Confirmación enviada a:</strong> {{ $order->shipping_email }}
                </p>
                <p class="text-sm text-gray-700 mt-2">
                    <i class="fas fa-clock text-eco-green"></i>
                    <strong>Tiempo de entrega:</strong> 3-5 días hábiles
                </p>
            </div>
        </div>
    </div>

    <!-- BOTONES DE ACCIÓN -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <a href="{{ route('orders.show', $order->id) }}" class="block text-center bg-eco-green text-white px-6 py-3 rounded-lg font-bold hover:bg-opacity-90 transition">
            <i class="fas fa-file-invoice"></i> Ver Orden Completa
        </a>
        <a href="{{ route('products.index') }}" class="block text-center bg-eco-lime text-eco-dark px-6 py-3 rounded-lg font-bold hover:bg-opacity-90 transition">
            <i class="fas fa-arrow-left"></i> Seguir Comprando
        </a>
    </div>

    <!-- INFORMACIÓN ADICIONAL -->
    <div class="bg-eco-green text-white rounded-lg shadow-lg p-6 space-y-4">
        <h3 class="text-lg font-bold">¿Qué ocurre ahora?</h3>
        <ul class="space-y-2 text-sm">
            <li class="flex items-center gap-2">
                <i class="fas fa-check-circle text-eco-lime"></i>
                Hemos recibido tu pago
            </li>
            <li class="flex items-center gap-2">
                <i class="fas fa-box text-eco-lime"></i>
                Preparamos tu pedido para envío
            </li>
            <li class="flex items-center gap-2">
                <i class="fas fa-truck text-eco-lime"></i>
                Enviamos a tu dirección
            </li>
            <li class="flex items-center gap-2">
                <i class="fas fa-door-open text-eco-lime"></i>
                Recibes tu compra
            </li>
        </ul>
    </div>
</div>

@endsection
