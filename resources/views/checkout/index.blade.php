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
            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm" class="space-y-8">
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
                            <input type="text" name="shipping_name" required
                                value="{{ auth()->user()->name }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Correo Electrónico *</label>
                            <input type="email" name="shipping_email" required
                                value="{{ auth()->user()->email }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Teléfono de Contacto *</label>
                            <input type="tel" name="shipping_phone" required
                                value="{{ auth()->user()->phone }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                            @error('shipping_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Dirección -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Dirección *</label>
                            <input type="text" name="shipping_address" required
                                placeholder="Calle, número, apartamento"
                                value="{{ auth()->user()->address }}"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
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

                <!-- SECCIÓN 2: INFORMACIÓN DE PAGO -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-eco-dark mb-6 pb-4 border-b-2 border-eco-green">
                        <i class="fas fa-credit-card"></i> Información de Pago
                    </h2>

                    <p class="text-sm text-gray-600 mb-6 p-4 bg-blue-50 rounded">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        Usa el número de tarjeta <strong>4242 4242 4242 4242</strong> para pruebas. Cualquier fecha futura y cualquier CVC.
                    </p>

                    <div class="space-y-6">
                        <!-- Nombre en Tarjeta -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Nombre en la Tarjeta *</label>
                            <input type="text" id="cardName"
                                placeholder="Nombre como aparece en la tarjeta"
                                class="w-full px-4 py-3 border-2 border-eco-green rounded-lg focus:outline-none focus:border-eco-lime">
                        </div>

                        <!-- Elemento Stripe -->
                        <div>
                            <label class="block text-sm font-bold text-eco-dark mb-2">Detalles de Tarjeta *</label>
                            <div id="card-element" class="p-4 border-2 border-eco-green rounded-lg"></div>
                            <div id="card-errors" class="text-red-500 text-sm mt-2"></div>
                        </div>

                        <!-- Checkbox Términos -->
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="terms" name="terms" required class="mt-1 w-4 h-4 text-eco-green">
                            <label for="terms" class="text-sm text-gray-600">
                                Acepto los términos y condiciones y la política de privacidad
                            </label>
                        </div>
                    </div>
                </div>

                <!-- BOTÓN PAGAR -->
                <button type="submit" id="submitBtn" class="w-full bg-eco-green hover:bg-opacity-90 text-white font-bold text-lg py-4 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-lock"></i> Pagar y Completar Orden
                </button>
            </form>
        </div>

        <!-- RESUMEN DE ORDEN -->
        <div class="h-fit">
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
        </div>
    </div>
</div>

<!-- Scripts Stripe -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_PUBLIC_KEY") }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const cardErrors = document.getElementById('card-errors');
    cardElement.addEventListener('change', function(event) {
        if (event.error) {
            cardErrors.textContent = event.error.message;
        } else {
            cardErrors.textContent = '';
        }
    });

    document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Procesando...';

        const {token} = await stripe.createToken(cardElement, {
            name: document.getElementById('cardName').value
        });

        if (token) {
            const form = document.getElementById('checkoutForm');
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripe_token');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        } else {
            cardErrors.textContent = 'Error al procesar la tarjeta';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Intentar de Nuevo';
        }
    });
</script>

@endsection
