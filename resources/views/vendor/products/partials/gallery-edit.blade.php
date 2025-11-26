<div class="bg-white rounded-lg shadow-lg p-8 sticky top-20">
    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
        <i class="fas fa-images text-eco-green"></i> Galería de Imágenes
    </h2>

    <!-- Imágenes Existentes -->
    @if(isset($product) && $product->images->count())
        <div class="mb-8">
            <h3 class="font-bold text-eco-dark mb-4">Imágenes Actuales</h3>
            <div class="grid grid-cols-2 gap-3 mb-6">
                @foreach($product->images as $image)
                    <div id="image-{{ $image->id }}" class="relative group border-2 border-eco-green rounded-lg overflow-hidden cursor-pointer transition hover:border-eco-lime"
                        onclick="removeExistingImage({{ $image->id }})">

                        <img src="{{ $image->getUrl() }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">

                        @if($image->is_primary)
                            <div class="absolute top-2 left-2 bg-eco-lime text-eco-dark px-2 py-1 rounded text-xs font-bold">
                                <i class="fas fa-star"></i> Principal
                            </div>
                        @endif

                        <input type="hidden" id="remove-{{ $image->id }}" name="remove_images[{{ $image->id }}]" value="0" class="hidden">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Drop Zone -->
    <div class="border-2 border-dashed border-eco-green rounded-lg p-6 text-center cursor-pointer hover:border-eco-lime hover:bg-eco-sand transition"
        onclick="document.getElementById('images').click()">
        <i class="fas fa-cloud-upload-alt text-eco-green text-4xl mb-3 block"></i>
        <p class="text-eco-dark font-bold mb-1">Arrastra nuevas imágenes</p>
        <p class="text-sm text-gray-600 mb-3">o haz click para seleccionar</p>
        <p class="text-xs text-gray-500">
            <i class="fas fa-info-circle"></i> JPG, PNG, GIF • Máx 2MB cada una • 1-10 imágenes
        </p>
    </div>

    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">

    <!-- Preview -->
    <div id="newImagePreview" class="mt-6 grid grid-cols-2 gap-3"></div>

    <!-- Contador -->
    <div class="mt-4 p-3 bg-eco-sand rounded">
        <p class="text-sm font-semibold text-eco-dark" id="imageCounter">
            <i class="fas fa-check-circle text-eco-lime"></i> 0 imagen(es) seleccionada(s)
        </p>
    </div>
</div>
