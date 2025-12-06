@extends('layouts.app')

@section('title', 'Sobre Nosotros - Eco-Rueda')

@section('content')

<!-- HERO -->
<section class="relative h-96 bg-gradient-to-r from-eco-green to-eco-lime overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <i class="fas fa-recycle absolute text-8xl top-10 left-10"></i>
        <i class="fas fa-leaf absolute text-8xl bottom-10 right-10"></i>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 h-full flex items-center">
        <div class="text-white">
            <h1 class="text-5xl font-bold mb-4">Sobre Nosotros</h1>
            <p class="text-xl opacity-90">
                Transformamos materiales reciclados en muebles únicos y sostenibles.
            </p>
        </div>
    </div>
</section>

<!-- OBJETIVO / HISTORIA -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-eco-green mb-6">Nuestro Objetivo</h2>

        <p class="text-gray-700 text-lg leading-relaxed">
            En <strong>Eco-Rueda</strong>, nuestro propósito es demostrar que la creatividad y la sostenibilidad
            pueden convivir en cada rincón de nuestro hogar.
            Transformamos materiales como <span class="font-semibold">llantas, madera recuperada,
            costales y plástico reciclado</span> en sillas ergonómicas, resistentes y con diseños modernos.
        </p>

        <p class="text-gray-700 text-lg mt-6">
            Nuestro equipo está comprometido con reducir el impacto ambiental, fomentar la cultura del
            reciclaje y crear productos duraderos que inspiren a más personas a cuidar el planeta.
        </p>
    </div>
</section>

<!-- FOTO DEL EQUIPO -->
<section class="py-16 bg-eco-sand/40">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-eco-green mb-8">Nuestro Equipo</h2>

        <img src={{ asset('fotos_equipo/equipo.jpg')  }}
            alt="Equipo Eco-Rueda"
            class="w-full max-w-4xl mx-auto rounded-2xl shadow-lg">

        <p class="text-gray-700 mt-6 text-lg">
            Este es el equipo detrás de cada diseño, cada corte y cada silla de Eco-Rueda.
        </p>
    </div>
</section>

<!-- CARDS DE INTEGRANTES -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-eco-green mb-12 text-center">Conoce a Cada Miembro</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- MIEMBRO 1 -->
             @foreach ($miembros as $miembro)
                <div class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transition duration-300">
                        <img src={{ asset('fotos_equipo/'. $miembro["foto"] )  }}
                        class="w-full h-56 object-cover">
                        <div class="p-5 text-center">
                            <h3 class="text-xl font-bold text-eco-green">{{ $miembro["nombre"] }}</h3>
                            {{-- <p class="text-gray-600 text-sm mt-2">Diseñador de Sillas</p> --}}
                        </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

<!-- VALORES -->
<section class="bg-eco-green text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Nuestros Valores</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="text-center">
                <i class="fas fa-recycle text-5xl text-eco-lime mb-4"></i>
                <h3 class="font-bold text-xl mb-2">Impacto Ambiental</h3>
                <p class="text-sm opacity-90">Reducimos la contaminación reutilizando materiales.</p>
            </div>

            <div class="text-center">
                <i class="fas fa-hands-helping text-5xl text-eco-lime mb-4"></i>
                <h3 class="font-bold text-xl mb-2">Trabajo en Equipo</h3>
                <p class="text-sm opacity-90">Cada silla es el resultado de un esfuerzo conjunto.</p>
            </div>

            <div class="text-center">
                <i class="fas fa-lightbulb text-5xl text-eco-lime mb-4"></i>
                <h3 class="font-bold text-xl mb-2">Creatividad</h3>
                <p class="text-sm opacity-90">Convertimos basura en arte funcional.</p>
            </div>

        </div>
    </div>
</section>

@endsection
