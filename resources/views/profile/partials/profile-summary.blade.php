<!-- PARTIAL 2: RESUMEN DEL PERFIL -->
<!-- resources/views/profile/partials/profile-summary.blade.php -->

<div class="h-fit sticky top-20">
    <!-- TARJETA DE PERFIL -->
    <div class="bg-gradient-to-br from-eco-green to-eco-lime text-white rounded-lg shadow-lg p-8 mb-6">
        <div class="text-center">
            <i class="fas fa-user-circle text-6xl mb-4 block opacity-80"></i>
            <h3 class="text-2xl font-bold">{{ auth()->user()->name }}</h3>
            <p class="text-sm opacity-75 mt-2">{{ auth()->user()->email }}</p>

            <!-- Badge de rol -->
            <div class="mt-4 inline-block">
                @if(auth()->user()->role === 'customer')
                    <span class="bg-white text-eco-green px-4 py-2 rounded-full text-xs font-bold">
                        <i class="fas fa-shopping-bag"></i> Comprador
                    </span>
                @elseif(auth()->user()->role === 'vendor')
                    <span class="bg-white text-eco-green px-4 py-2 rounded-full text-xs font-bold">
                        <i class="fas fa-store"></i> Vendedor
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- ESTADÍSTICAS -->
    <div class="space-y-4">
        <!-- Total Compras -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-eco-green">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-600">Total de Compras</p>
                    <p class="text-3xl font-bold text-eco-green">{{ auth()->user()->orders->count() }}</p>
                </div>
                <i class="fas fa-shopping-bag text-eco-green text-3xl opacity-20"></i>
            </div>
        </div>

        <!-- Gasto Total -->
        {{-- <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-eco-lime">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-600">Gasto Total</p>
                    <p class="text-3xl font-bold text-eco-lime">
                        ${{ number_format(auth()->user()->orders->sum('total'), 2) }}
                    </p>
                </div>
                <i class="fas fa-dollar-sign text-eco-lime text-3xl opacity-20"></i>
            </div>
        </div> --}}

        <!-- Órdenes Pagadas -->
        {{-- <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-600">Órdenes Completadas</p>
                    <p class="text-3xl font-bold text-green-600">
                        {{ auth()->user()->orders->where('status', 'completed')->count() }}
                    </p>
                </div>
                <i class="fas fa-check-circle text-green-500 text-3xl opacity-20"></i>
            </div>
        </div> --}}
    </div>

    <!-- INFO ÚTIL -->
    <div class="mt-6 p-4 bg-eco-green bg-opacity-10 border-l-4 border-eco-green rounded">
        <p class="text-xs text-eco-green font-semibold">
            <i class="fas fa-lightbulb"></i> Mantén tu información actualizada para recibir notificaciones sobre tus compras
        </p>
    </div>
</div>

