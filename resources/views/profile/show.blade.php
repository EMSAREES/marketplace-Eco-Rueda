@extends('layouts.app')

@section('title', 'Mi Perfil - ' . auth()->user()->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- ENCABEZADO -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-eco-dark mb-2">
            <i class="fas fa-user-circle text-eco-green"></i> Mi Perfil
        </h1>
        <p class="text-gray-600">Administra tu información personal y dirección de envío</p>
    </div>

    <!-- NAVEGACIÓN DE TABS -->
    <div class="mb-8 flex gap-4 border-b-2 border-eco-sand flex-wrap">
        <button onclick="showTab('info')" id="tab-info"
            class="px-6 py-3 font-bold text-eco-green border-b-4 border-eco-green">
            <i class="fas fa-user"></i> Información Personal
        </button>

        <button onclick="showTab('address')" id="tab-address"
            class="px-6 py-3 font-bold text-gray-600 hover:text-eco-green transition">
            <i class="fas fa-map-marker-alt"></i> Dirección
        </button>

        <button onclick="showTab('orders')" id="tab-orders"
            class="px-6 py-3 font-bold text-gray-600 hover:text-eco-green transition">
            <i class="fas fa-history"></i> Mis Compras
        </button>
    </div>

    <!-- CONTENIDO DE TABS -->

    <!-- TAB 1: INFORMACIÓN PERSONAL -->
    <div id="content-info" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- FORMULARIO -->
            <div class="lg:col-span-2">
                @include('profile.partials.personal-info')
            </div>

            <!-- RESUMEN -->
            <div>
                @include('profile.partials.profile-summary')
            </div>

        </div>
    </div>

    <!-- TAB 2: DIRECCIÓN -->
    <div id="content-address" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- FORMULARIO DIRECCIÓN -->
            <div class="lg:col-span-2">
                @include('profile.partials.address-form')
            </div>

            <!-- PREVIEW MAPA -->
            <div>
                @include('profile.partials.address-preview')
            </div>

        </div>
    </div>

    <!-- TAB 3: HISTORIAL DE COMPRAS -->
    <div id="content-orders" class="tab-content hidden">
        @include('profile.partials.orders-history')
    </div>

</div>

<!-- SCRIPTS -->
<script>
    function showTab(tabName) {

        // OCULTAR TODO
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // QUITAR ACTIVO A BOTONES
        document.querySelectorAll('[id^="tab-"]').forEach(btn => {
            btn.classList.remove('border-b-4', 'border-eco-green', 'text-eco-green');
            btn.classList.add('text-gray-600', 'hover:text-eco-green');
        });

        // MOSTRAR TAB
        document.getElementById('content-' + tabName).classList.remove('hidden');

        // ACTIVAR BOTÓN
        document.getElementById('tab-' + tabName).classList.add('border-b-4', 'border-eco-green', 'text-eco-green');
    }

    // VALIDAR EMAIL
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    document.getElementById('email')?.addEventListener('blur', function () {
        if (this.value && !validateEmail(this.value)) {
            this.classList.add('border-red-500');
            this.classList.remove('border-eco-green');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-eco-green');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    // Revisar si la URL tiene ?tab=orders
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab');

    if (tab) {
        showTab(tab);
    } else {
        showTab('info'); // pestaña por defecto
    }
});

</script>

@endsection
