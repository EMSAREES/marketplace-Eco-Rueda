<!-- PARTIAL 5: PREVIEW DEL PRODUCTO -->
<!-- resources/views/vendor/products/partials/preview.blade.php -->

<div class="bg-eco-green text-white rounded-lg shadow-lg p-8 sticky top-96">
    <h3 class="text-lg font-bold mb-4">
        <i class="fas fa-eye"></i> Vista Previa
    </h3>

    <!-- Tarjeta de Producto -->
    <div class="bg-white text-eco-dark rounded-lg overflow-hidden shadow-lg">
        <!-- Imagen -->
        <div class="h-40 bg-eco-sand flex items-center justify-center">
            <i class="fas fa-chair text-4xl text-eco-green opacity-30"></i>
        </div>

        <!-- Contenido -->
        <div class="p-4">
            <h4 class="font-bold text-eco-dark line-clamp-2 mb-2" id="previewName">
                Nombre del Producto
            </h4>

            <div class="flex items-center gap-2 mb-3">
                <span class="text-eco-green font-bold text-2xl" id="previewPrice">$0.00</span>
            </div>

            <div class="inline-block bg-eco-lime text-eco-dark px-2 py-1 rounded text-xs font-bold mb-3">
                <i class="fas fa-leaf"></i> <span id="previewMaterial">Material</span>
            </div>

            <div class="flex gap-2">
                <button class="flex-1 bg-eco-green text-white py-2 rounded text-xs font-bold hover:bg-opacity-90">
                    Ver
                </button>
                <button class="flex-1 bg-eco-lime text-eco-dark py-2 rounded text-xs font-bold hover:bg-opacity-90">
                    Agregar
                </button>
            </div>
        </div>
    </div>

    <!-- Estado del formulario -->
    <div class="mt-6 p-4 bg-white bg-opacity-10 rounded-lg text-sm space-y-2">
        <div class="flex justify-between">
            <span>Nombre:</span>
            <span id="checkName" class="text-eco-lime">✓</span>
        </div>
        <div class="flex justify-between">
            <span>Precio:</span>
            <span id="checkPrice" class="text-eco-lime">✓</span>
        </div>
        <div class="flex justify-between">
            <span>Material:</span>
            <span id="checkMaterial" class="text-eco-lime">✓</span>
        </div>
        <div class="flex justify-between">
            <span>Imágenes:</span>
            <span id="checkImages" class="text-red-300">✗</span>
        </div>
    </div>
</div>
