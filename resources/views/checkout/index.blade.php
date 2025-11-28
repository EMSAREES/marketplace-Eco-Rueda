<!-- resources/views/checkout/index.blade.php -->
@extends('layouts.app')

@section('title', 'Checkout - Pagar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold text-eco-dark mb-12">
        <i class="fas fa-credit-card text-eco-green"></i> Información de Envío y Pago
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- FORMULARIO -->
        <div class="lg:col-span-2">
            <form action="" method="POST" id="checkoutForm" name="checkoutForm" class="space-y-8">
                @csrf

                <!-- SECCIÓN 1: INFORMACIÓN DE ENVÍO -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
                        <i class="fas fa-box"></i> Información de Envío
                    </h2>

                    <div class="space-y-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Nombre Completo *</label>
                            <input type="text" name="shipping_name" disabled
                                value="{{ auth()->user()->name }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg bg-gray-300 focus:outline-none focus:border-eco-lime">
                            @error('shipping_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Correo Electrónico *</label>
                            <input type="email" name="shipping_email" disabled
                                value="{{ auth()->user()->email }}"
                                class="w-full px-4 py-3 border-2 bg-gray-300  border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Teléfono de Contacto *</label>
                            <input type="tel" name="shipping_phone" disabled
                                value="{{ auth()->user()->phone }}"
                                class="w-full px-4 py-3 border-2 bg-gray-300 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Dirección -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Dirección *</label>
                            <input type="text" name="shipping_address" required
                                placeholder="Calle, número, apartamento"
                                value="{{ auth()->user()->address }}"
                                class="w-full px-4 py-3  border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ciudad -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Ciudad *</label>
                            <input type="text" name="shipping_city" required
                                value="{{ auth()->user()->city }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Estado *</label>
                            <input type="text" name="shipping_state" required
                                value="{{ auth()->user()->state }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- País -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">País *</label>
                            <input type="text" name="shipping_country" required
                                value="{{ auth()->user()->country }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Código Postal -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Código Postal *</label>
                            <input type="text" name="shipping_postal_code" required
                                value="{{ auth()->user()->postal_code }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <input type="hidden" id="stripeToken" name="stripe_token">

                <!-- BOTÓN PAGAR -->
                <button type="submit" id="submitBtn" class="w-full bg-eco-green hover:bg-opacity-90 text-white font-bold text-lg py-4 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-lock"></i> Pagar y Completar Orden
                </button>

            </form>
        </div>

        <!-- RESUMEN DE ORDEN -->
        {{-- <div class="h-fit">
            <div class="bg-eco-green text-white rounded-lg shadow-lg p-8 space-y-6">
                <h2 class="text-2xl font-bold">Resumen de Orden</h2>

                <!-- ITEMS -->
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @php
                        $total = 0;
                    @endphp
                    @foreach(session('cart', []) as $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <div class="flex justify-between items-start pb-3 border-b border-eco-lime border-opacity-30">
                            <div>
                                <p class="font-bold text-sm">{{ $item['name'] }}</p>
                                <p class="text-xs opacity-75">Cantidad: {{ $item['quantity'] }}</p>
                            </div>
                            <p class="font-bold text-eco-lime">${{ number_format($subtotal, 2) }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- CÁLCULOS -->
                <div class="border-t border-eco-lime pt-4 space-y-3">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-bold">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Envío</span>
                        <span class="font-bold">Gratis</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Impuestos (16%)</span>
                        <span class="font-bold">${{ number_format($total * 0.16, 2) }}</span>
                    </div>
                </div>

                <!-- TOTAL -->
                <div class="bg-eco-lime bg-opacity-20 rounded p-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">Total a Pagar</span>
                        <span class="text-3xl font-bold text-eco-lime">
                            ${{ number_format($total * 1.16, 2) }}
                        </span>
                    </div>
                </div>

                <!-- SEGURIDAD -->
                <div class="bg-white bg-opacity-10 rounded p-3 text-xs">
                    <p><i class="fas fa-lock"></i> Tu información de pago es segura</p>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<!-- Scripts Stripe -->
@endsection

@section('customJs')

<script src="https://js.stripe.com/v3/"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    $("#checkoutForm").submit(function(e){
        e.preventDefault();

        $("#submitBtn").prop("disabled", true).text("Procesando pago...");

        // AJAX NORMAL (NO token, NO card-element)
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('checkout.process') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",

            success: function (response) {
                if (response.success) {
                    // Redirige a Stripe Checkout
                    window.location.href = response.url;
                } else {
                    alert("Error: " + response.message);
                    $("#submitBtn").prop("disabled", false).text("Pagar y Completar Orden");
                }
            },

            error: function(xhr){
                $("#submitBtn").prop("disabled", false).text("Pagar y Completar Orden");

                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    let msg = "";
                    $.each(errors, function(key,val){ msg += val[0] + "\n"; });
                    alert(msg);
                } else {
                    alert("Error inesperado.");
                }
            }
        });
    });
});
</script>
@endsection
