@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <form id="productForm" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- LEFT COLUMN -->
            <div class="space-y-6 col-span-2">
                {{-- @include('vendor.products.partials.basic-info') --}}
                @include('vendor.products.partials.product-details')
                {{-- @include('vendor.products.partials.inventory') --}}
                @include('vendor.products.partials.gallery-edit')
            </div>

        </div>

        <div class="mt-6 text-right">
            <button type="submit"
                class="bg-eco-green text-white px-6 py-3 rounded-lg font-bold hover:bg-opacity-90 transition">
                Crear Producto
            </button>
        </div>
    </form>
</div>
@endsection

@section('customJs')
<script>
$(document).ready(function() {
    // Preview de imágenes seleccionadas
    $('#images').on('change', function() {
        $('#newImagePreview').empty();
        const files = this.files;
        if(files.length > 0){
            $.each(files, function(i, file){
                const reader = new FileReader();
                reader.onload = function(e){
                    $('#newImagePreview').append(`
                        <div class="relative border-2 border-eco-green rounded-lg overflow-hidden h-32">
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            });
        }
        $('#imageCounter').text(files.length + ' imagen(es) seleccionada(s)');
        $('#checkImages').text(files.length > 0 ? '✓' : '✗').toggleClass('text-eco-lime text-red-300');
    });


    // Subida con AJAX
    $('#productForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("vendor.products.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                // Opcional: mostrar loader
            },
            success: function(response){
                if(response.success){
                    window.location.href='{{ route("vendor.dashboard") }}';
                } else {
                    alert('Error al crear el producto.');
                }
            },
            error: function(xhr){
                let errors = xhr.responseJSON.errors;
                let message = '';
                $.each(errors, function(key, val){
                    message += val[0] + '\n';
                });
                alert(message);
            }
        });
    });
});

// Función para eliminar imágenes existentes
function removeExistingImage(id){
    let confirmDelete = confirm('¿Eliminar esta imagen?');
    if(confirmDelete){
        $('#image-' + id).fadeOut();
        $('#remove-' + id).val(id); // Marcar para eliminar
    }
}
</script>
@endsection
