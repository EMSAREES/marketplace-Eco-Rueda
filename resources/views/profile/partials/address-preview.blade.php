<!-- PARTIAL 4: PREVIEW DE DIRECCIÓN -->
<!-- resources/views/profile/partials/address-preview.blade.php -->

<div class="h-fit sticky top-20">
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
        <h3 class="font-bold text-eco-dark mb-4 flex items-center gap-2">
            <i class="fas fa-map-pin text-eco-green text-2xl"></i> Tu Dirección
        </h3>

        @if(auth()->user()->address)
            <div class="bg-eco-sand rounded-lg p-6 mb-6">
                <div class="space-y-2 text-sm">
                    <p class="font-bold text-eco-dark">{{ auth()->user()->address }}</p>
                    <p class="text-gray-600">{{ auth()->user()->city }}, {{ auth()->user()->state }}</p>
                    <p class="text-gray-600">{{ auth()->user()->postal_code }} - {{ auth()->user()->country }}</p>
                </div>
            </div>

            <!-- Estado de la dirección -->
            <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded">
                <p class="text-sm text-green-700">
                    <i class="fas fa-check-circle"></i> Dirección configurada
                </p>
            </div>
        @else
            <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                <p class="text-sm text-yellow-700">
                    <i class="fas fa-exclamation-circle"></i> No has configurado una dirección aún
                </p>
            </div>

            <div class="mt-4 p-4 bg-eco-green bg-opacity-10 border-l-4 border-eco-green rounded">
                <p class="text-sm text-eco-green">
                    <i class="fas fa-info-circle"></i> Completa el formulario para guardar tu dirección de envío
                </p>
            </div>
        @endif
    </div>

    <!-- INFORMACIÓN DE SEGURIDAD -->
    <div class="bg-eco-green bg-opacity-10 border-l-4 border-eco-green rounded p-6">
        <h4 class="font-bold text-eco-dark mb-3 flex items-center gap-2">
            <i class="fas fa-shield-alt text-eco-green"></i> Seguridad
        </h4>
        <ul class="space-y-2 text-sm text-eco-dark">
            <li class="flex items-center gap-2">
                <i class="fas fa-lock text-eco-lime"></i>
                Tus datos están encriptados
            </li>
            <li class="flex items-center gap-2">
                <i class="fas fa-lock text-eco-lime"></i>
                Solo visible para ti
            </li>
            <li class="flex items-center gap-2">
                <i class="fas fa-lock text-eco-lime"></i>
                Usado solo para envíos
            </li>
        </ul>
    </div>
</div>


