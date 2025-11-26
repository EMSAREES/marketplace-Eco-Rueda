<!-- PARTIAL 3: FORMULARIO DE DIRECCIÓN -->
<!-- resources/views/profile/partials/address-form.blade.php -->

<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
        <i class="fas fa-map-marker-alt text-eco-green"></i> Dirección de Envío
    </h2>

    <form action="{{ route('profile.update-address') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Dirección Principal -->
        <div>
            <label for="address" class="block text-sm font-bold text-eco-dark mb-2">
                <i class="fas fa-map-signs"></i> Dirección *
            </label>
            <input
                type="text"
                id="address"
                name="address"
                required
                value="{{ old('address', auth()->user()->address) }}"
                placeholder="Ej: Calle Principal 123, Apartamento 4B"
                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('address') border-red-500 @enderror">
            @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ciudad y Código Postal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="city" class="block text-sm font-bold text-eco-dark mb-2">
                    <i class="fas fa-city"></i> Ciudad *
                </label>
                <input
                    type="text"
                    id="city"
                    name="city"
                    required
                    value="{{ old('city', auth()->user()->city) }}"
                    placeholder="Tu ciudad"
                    class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('city') border-red-500 @enderror">
                @error('city')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="postal_code" class="block text-sm font-bold text-eco-dark mb-2">
                    <i class="fas fa-hashtag"></i> Código Postal *
                </label>
                <input
                    type="text"
                    id="postal_code"
                    name="postal_code"
                    required
                    value="{{ old('postal_code', auth()->user()->postal_code) }}"
                    placeholder="00000"
                    class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('postal_code') border-red-500 @enderror">
                @error('postal_code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Estado y País -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="state" class="block text-sm font-bold text-eco-dark mb-2">
                    <i class="fas fa-map"></i> Estado/Provincia *
                </label>
                <input
                    type="text"
                    id="state"
                    name="state"
                    required
                    value="{{ old('state', auth()->user()->state) }}"
                    placeholder="Tu estado"
                    class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('state') border-red-500 @enderror">
                @error('state')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="country" class="block text-sm font-bold text-eco-dark mb-2">
                    <i class="fas fa-globe"></i> País *
                </label>
                <input
                    type="text"
                    id="country"
                    name="country"
                    required
                    value="{{ old('country', auth()->user()->country) }}"
                    placeholder="Tu país"
                    class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime focus:ring-2 focus:ring-eco-lime focus:ring-opacity-30 transition @error('country') border-red-500 @enderror">
                @error('country')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Información adicional -->
        <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
            <p class="text-sm text-blue-700">
                <i class="fas fa-info-circle"></i>
                <strong>Nota:</strong> Esta dirección se usará para todos tus envíos. Asegúrate de que sea correcta.
            </p>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 justify-end pt-4 border-t-2 border-eco-sand">
            <a href="javascript:history.back()" class="px-6 py-3 border-2 border-eco-green text-eco-green rounded-lg hover:bg-eco-sand transition font-bold">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="px-6 py-3 bg-eco-green text-white rounded-lg hover:bg-opacity-90 transition font-bold">
                <i class="fas fa-save"></i> Guardar Dirección
            </button>
        </div>
    </form>
</div>

