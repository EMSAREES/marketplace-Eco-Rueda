<!-- PARTIAL 1: INFORMACIÓN PERSONAL -->
<!-- resources/views/profile/partials/personal-info.blade.php -->

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
        <i class="fas fa-user text-eco-green"></i> Información Personal
    </h2>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div>
            <label for="name" class="block text-sm font-bold text-eco-dark mb-2">
                <i class="fas fa-user"></i> Nombre Completo
            </label>
            <input
                type="text"
                id="name"
                name="name"
                required
                value="{{ old('name', auth()->user()->name) }}"
                placeholder="Tu nombre completo"
                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email (Solo lectura si autenticado con Google) -->
        <div>
            <label for="email" class="block text-sm font-bold text-eco-dark mb-2">
                <i class="fas fa-envelope"></i> Correo Electrónico
            </label>
            <div class="relative">
                <input
                    type="email"
                    id="email"
                    value="{{ auth()->user()->email }}"
                    placeholder="tu@correo.com"
                    disabled
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                <i class="fas fa-lock absolute right-3 top-3 text-gray-400"></i>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> Tu correo está protegido y no puede ser modificado
            </p>
        </div>

        <!-- Teléfono -->
        <div>
            <label for="phone" class="block text-sm font-bold text-eco-dark mb-2">
                <i class="fas fa-phone"></i> Teléfono
            </label>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone', auth()->user()->phone) }}"
                placeholder="(000) 000-0000"
                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('phone') border-red-500 @enderror">
            @error('phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Rol del Usuario -->
        <div class="p-4 bg-eco-sand rounded-lg">
            <div class="flex items-center gap-3">
                @if(auth()->user()->role === 'customer')
                    <i class="fas fa-shopping-bag text-eco-green text-2xl"></i>
                    <div>
                        <p class="font-bold text-eco-dark">Comprador</p>
                        <p class="text-xs text-gray-600">Acceso a catálogo y compras</p>
                    </div>
                @elseif(auth()->user()->role === 'vendor')
                    <i class="fas fa-store text-eco-green text-2xl"></i>
                    <div>
                        <p class="font-bold text-eco-dark">Vendedor
                            @if(auth()->user()->is_verified)
                                <span class="ml-2 inline-block bg-eco-lime text-eco-dark px-2 py-1 rounded text-xs font-bold">
                                    <i class="fas fa-check-circle"></i> Verificado
                                </span>
                            @else
                                <span class="ml-2 inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">
                                    <i class="fas fa-hourglass-half"></i> Pendiente Verificación
                                </span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-600">Acceso a panel de vendedor</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Miembro Desde -->
        <div class="p-4 bg-eco-green bg-opacity-10 border-l-4 border-eco-green rounded">
            <p class="text-sm text-eco-dark">
                <i class="fas fa-calendar-alt text-eco-green"></i>
                <strong>Miembro desde:</strong>
                {{ auth()->user()->created_at->format('d \d\e F \d\e Y') }}
            </p>
        </div>

        <!-- Botón Guardar -->
        <div class="flex gap-4 justify-end pt-4 border-t-2 border-eco-sand">
            <a href="javascript:history.back()" class="px-6 py-3 border-2 border-eco-green text-eco-green rounded-lg hover:bg-eco-sand transition font-bold">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="px-6 py-3 bg-eco-green text-white rounded-lg hover:bg-opacity-90 transition font-bold">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>








