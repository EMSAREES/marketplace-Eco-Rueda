<div>
    @if($orders->count())
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <!-- ENCABEZADO ORDEN -->
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
                        <!-- PRODUCTOS -->
                        <h3 class="font-bold text-eco-dark mb-4">
                            <i class="fas fa-box text-eco-green"></i> Productos
                        </h3>
                        <div class="space-y-3 mb-6">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center p-3 bg-eco-sand rounded-lg">
                                    <div>
                                        <p class="font-bold text-eco-dark">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-600">Cantidad: <strong>{{ $item->quantity }}</strong></p>
                                    </div>
                                    <p class="font-bold text-eco-green">${{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- DIRECCIÓN DE ENVÍO -->
                        <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded mb-6">
                            <p class="text-sm font-bold text-blue-900 mb-2">
                                <i class="fas fa-truck"></i> Envío a:
                            </p>
                            <p class="text-sm text-blue-700">
                                {{ $order->shipping_name }}<br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}
                            </p>
                        </div>

                        <!-- RESUMEN FINANCIERO -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg border-l-4 border-eco-green mb-6">
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

                        <!-- ACCIONES -->
                        <div class="flex gap-3 justify-end">
                            <a href="{{ route('products.show', $item->product->id) }}" class="bg-eco-green text-white px-4 py-2 rounded hover:bg-opacity-90 transition text-sm font-semibold">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-12">
            {{ $orders->appends(['tab' => 'orders'])->links('pagination::tailwind') }}
        </div>
    @else
        <!-- SIN COMPRAS -->
        <div class="text-center py-16">
            <i class="fas fa-shopping-bag text-8xl text-eco-green opacity-20 mb-4 block"></i>
            <h2 class="text-2xl font-bold text-eco-dark mb-4">No tienes compras aún</h2>
            <p class="text-gray-600 mb-8">¡Comienza a explorar nuestras sillas sostenibles!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-eco-green text-white px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition">
                <i class="fas fa-arrow-left"></i> Ver Catálogo
            </a>
        </div>
    @endif
</div>
