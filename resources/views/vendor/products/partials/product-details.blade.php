<!-- PARTIAL 1: INFORMACIÓN BÁSICA -->
<!-- resources/views/vendor/products/partials/basic-info.blade.php -->

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
        <i class="fas fa-info-circle text-eco-green"></i> Información Básica
    </h2>

    <div class="space-y-6">
        <!-- Nombre del Producto -->
        <div>
            <label for="name" class="block text-sm font-bold text-eco-dark mb-2">
                Nombre del Producto <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                required
                value="{{ old('name', $product->name ?? '') }}"
                placeholder="Ej: Silla Moderna Eco - Madera Reciclada"
                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('name') border-red-500 @enderror"
                maxlength="255">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Máximo 255 caracteres</p>
        </div>

        <!-- Descripción -->
        <div>
            <label for="description" class="block text-sm font-bold text-eco-dark mb-2">
                Descripción <span class="text-red-500">*</span>
            </label>
            <textarea
                id="description"
                name="description"
                required
                rows="5"
                placeholder="Describe tu producto detalladamente. Incluye características, materiales, dimensiones, etc."
                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('description') border-red-500 @enderror"
            >{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Sé detallado para que los compradores entiendan bien el producto</p>
        </div>
    </div>
</div>



<!-- PARTIAL 2: DETALLES DEL PRODUCTO -->
<!-- resources/views/vendor/products/partials/product-details.blade.php -->

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
        <i class="fas fa-palette text-eco-green"></i> Detalles del Producto
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Precio -->
        <div>
            <label for="price" class="block text-sm font-bold text-eco-dark mb-2">
                Precio <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-4 top-3 text-eco-green font-bold">$</span>
                <input
                    type="number"
                    id="price"
                    name="price"
                    required
                    step="0.01"
                    min="0.01"
                    value="{{ old('price', $product->price ?? '') }}"
                    placeholder="0.00"
                    class="w-full pl-8 pr-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('price') border-red-500 @enderror">
            </div>
            @error('price')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Material -->
        <div>
            <label for="material" class="block text-sm font-bold text-eco-dark mb-2">
                Material <span class="text-red-500">*</span>
            </label>
            <select
                id="material"
                name="material"
                required
                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('material') border-red-500 @enderror">
                <option value="">Selecciona un material</option>
                <option value="Llantas de Auto" @selected(old('material', $product->material ?? '') === 'Llantas de Auto')>
                    <i class="fas fa-tire"></i> Llantas de Auto
                </option>
                <option value="Costales Reciclados" @selected(old('material', $product->material ?? '') === 'Costales Reciclados')>
                    <i class="fas fa-cube"></i> Costales Reciclados
                </option>
                <option value="Madera Recuperada" @selected(old('material', $product->material ?? '') === 'Madera Recuperada')>
                    <i class="fas fa-tree"></i> Madera Recuperada
                </option>
                <option value="Plástico Reciclado" @selected(old('material', $product->material ?? '') === 'Plástico Reciclado')>
                    <i class="fas fa-recycle"></i> Plástico Reciclado
                </option>
                <option value="Botellas Plásticas" @selected(old('material', $product->material ?? '') === 'Botellas Plásticas')>
                    <i class="fas fa-bottle-water"></i> Botellas Plásticas
                </option>
                <option value="Metal Reciclado" @selected(old('material', $product->material ?? '') === 'Metal Reciclado')>
                    <i class="fas fa-screwdriver-wrench"></i> Metal Reciclado
                </option>
                <option value="Mixto" @selected(old('material', $product->material ?? '') === 'Mixto')>
                    <i class="fas fa-cubes"></i> Mixto
                </option>
            </select>
            @error('material')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Color -->
        <div>
            <label for="color" class="block text-sm font-bold text-eco-dark mb-2">
                Color
            </label>
            <input
                type="text"
                id="color"
                name="color"
                value="{{ old('color', $product->color ?? '') }}"
                placeholder="Ej: Natural, Gris, Castaño"
                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition">
        </div>

        <!-- Estado del Producto -->
        <div>
            <label class="block text-sm font-bold text-eco-dark mb-3">Estado del Producto</label>
            <label class="flex items-center gap-2 p-3 border-2 border-eco-green rounded-lg cursor-pointer hover:bg-eco-sand transition">
                <input
                    type="radio"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $product->is_active ?? true) == 1 ? 'checked' : '' }}
                    class="w-4 h-4 text-eco-green">
                <span class="font-semibold text-eco-dark"><i class="fas fa-eye text-eco-lime"></i> Activo (Visible)</span>
            </label>
            <label class="flex items-center gap-2 p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition mt-2">
                <input
                    type="radio"
                    name="is_active"
                    value="0"
                    {{ old('is_active', $product->is_active ?? true) == 0 ? 'checked' : '' }}
                    class="w-4 h-4 text-gray-400">
                <span class="font-semibold text-gray-600"><i class="fas fa-eye-slash"></i> Inactivo (Oculto)</span>
            </label>
        </div>
    </div>
</div>


<!-- PARTIAL 3: INVENTARIO -->
<!-- resources/views/vendor/products/partials/inventory.blade.php -->

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
        <i class="fas fa-boxes text-eco-green"></i> Inventario
    </h2>

    <div>
        <label for="stock" class="block text-sm font-bold text-eco-dark mb-2">
            Cantidad en Stock <span class="text-red-500">*</span>
        </label>
        <div class="flex items-center gap-4">
            <div class="flex-1 relative">
                <input
                    type="number"
                    id="stock"
                    name="stock"
                    required
                    min="0"
                    value="{{ old('stock', $product->stock ?? 0) }}"
                    placeholder="0"
                    class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('stock') border-red-500 @enderror">
            </div>
        </div>
        @error('stock')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <p class="text-xs text-gray-500 mt-2">
            <i class="fas fa-info-circle"></i> Actualiza el stock cuando recibas nuevas unidades
        </p>
    </div>

    <!-- Info de Stock -->
    <div class="mt-6 p-4 bg-eco-sand rounded-lg">
        @php
            $stock = old('stock', $product->stock ?? 0);
        @endphp
        <div class="flex justify-between items-center">
            <span class="font-semibold text-eco-dark">Stock Actual:</span>
            <span class="text-2xl font-bold text-eco-green">{{ $stock }}</span>
        </div>
        <div class="mt-2 flex items-center gap-2">
            @if($stock > 10)
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="text-sm text-green-700">Stock disponible</span>
            @elseif($stock > 0)
                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                <span class="text-sm text-yellow-700">Stock bajo</span>
            @else
                <i class="fas fa-times-circle text-red-500"></i>
                <span class="text-sm text-red-700">Producto agotado</span>
            @endif
        </div>
    </div>
</div>



