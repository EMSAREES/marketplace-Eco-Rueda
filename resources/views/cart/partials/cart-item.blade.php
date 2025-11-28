<!-- resources/views/cart/partials/cart-item.blade.php -->

<div id="cart-item-{{ $productId }}" class="border-b border-eco-sand p-4 grid grid-cols-12 gap-4 items-center hover:bg-eco-sand transition">
    <!-- Producto -->
    <div class="col-span-4">
        <div class="flex gap-3">
            @if($product && $product->primaryImage)
                <img src="{{ $product->getFeaturedImage()->getUrl() }}"
                                alt="{{ $product->name }}"
                                class="w-16 h-16 object-cover rounded">
            @else
                <div class="w-16 h-16 bg-eco-sand rounded flex items-center justify-center">
                    <i class="fas fa-chair text-eco-green text-2xl"></i>
                </div>
            @endif

            <div>
                <p class="font-bold text-eco-dark">{{ $item['name'] }}</p>
                <p class="text-xs text-gray-600">{{ $item['material'] ?? 'Material' }}</p>
                @if(isset($item['color']))
                    <p class="text-xs text-gray-500">Color: {{ $item['color'] }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Precio -->
    <div class="col-span-2 text-center">
        <p class="font-bold text-eco-green">${{ number_format($item['price'], 2) }}</p>
    </div>

    <!-- Cantidad -->
    <div class="col-span-2">
        <div class="flex items-center justify-center gap-2">
            <button type="button" onclick="updateQuantity({{ $productId }}, 'decrease')" class="px-2 py-1 bg-eco-sand rounded text-eco-green hover:bg-eco-lime hover:text-eco-dark transition">
                <i class="fas fa-minus text-sm"></i>
            </button>
            <span class="w-10 text-center font-bold border border-eco-green rounded py-1 item-quantity">
                {{ $item['quantity'] }}
            </span>
            <button type="button" onclick="updateQuantity({{ $productId }}, 'increase')" class="px-2 py-1 bg-eco-sand rounded text-eco-green hover:bg-eco-lime hover:text-eco-dark transition">
                <i class="fas fa-plus text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Subtotal -->
    <div class="col-span-2 text-center">
        <p class="font-bold text-eco-dark item-subtotal">${{ number_format($subtotal, 2) }}</p>
    </div>

    <!-- Eliminar -->
    <div class="col-span-2 text-center">
        <button type="button" onclick="removeFromCart({{ $productId }})" class="text-red-500 hover:text-red-700 transition hover:scale-110" title="Eliminar">
            <i class="fas fa-trash text-lg"></i>
        </button>
    </div>
</div>
