@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            <i class="fas fa-laptop-code text-blue-600 mr-3"></i>
            Taller PHP Avanzado - 2026-1
        </h1>
        <p class="text-xl text-gray-600">
            Cristian Camilo Echeverri Giraldo
        </p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Students Card -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-blue-500">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Gestión de Estudiantes</h2>
            </div>
            <p class="text-gray-600 mb-4">
                Procesa arreglo de estudiantes con nombre, calificación y carrera. 
                Calcula promedios por carrera e identifica estudiantes destacados.
            </p>
            <a href="{{ route('students.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-arrow-right mr-2"></i>Acceder
            </a>
        </div>

        <!-- Shippings Card -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-green-500">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-shipping-fast text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Control de Envíos</h2>
            </div>
            <p class="text-gray-600 mb-4">
                Procesa envíos con ciudad, transportista, peso y estado. 
                Calcula costos y estadísticas de entregas.
            </p>
            <a href="{{ route('shippings.index') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-arrow-right mr-2"></i>Acceder
            </a>
        </div>

        <!-- Finance Card -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-purple-500">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-calculator text-purple-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Calculadora Financiera</h2>
            </div>
            <p class="text-gray-600 mb-4">
                Calcula interés compuesto con diferentes periodicidades. 
                Compara interés simple vs compuesto.
            </p>
            <a href="{{ route('finance.index') }}" class="inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-arrow-right mr-2"></i>Acceder
            </a>
        </div>

        <!-- Payroll Card -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-yellow-500">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-yellow-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Cálculo de Nómina</h2>
            </div>
            <p class="text-gray-600 mb-4">
                Calcula salario neto en Colombia con deducciones de 
                salud (4%) y pensión (4%).
            </p>
            <a href="{{ route('payroll.index') }}" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition">
                <i class="fas fa-arrow-right mr-2"></i>Acceder
            </a>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-red-500">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-user-circle text-red-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Perfil de Usuario</h2>
            </div>
            <p class="text-gray-600 mb-4">
                Crea un perfil con imagen procesada. 
                Usa intervention/image para redimensionar.
            </p>
            <a href="{{ route('profile.create') }}" class="inline-block bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                <i class="fas fa-arrow-right mr-2"></i>Acceder
            </a>
        </div>

        <!-- PDF Export Card -->
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow p-6 border-t-4 border-indigo-500">
            <div class="flex items-center mb-4">
                <div class="bg-indigo-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-file-pdf text-indigo-600 text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Exportar PDF</h2>
            </div>
            <p class="text-gray-600 mb-4">
                Exporta los resultados de estudiantes a PDF 
                usando barryvdh/laravel-dompdf.
            </p>
            <a href="{{ route('students.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-arrow-right mr-2"></i>Acceder
            </a>
        </div>
    </div>

    <!-- Tech Stack -->
    <div class="mt-12 bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            <i class="fas fa-tools mr-2"></i>Tecnologías Utilizadas
        </h2>
        <div class="flex flex-wrap justify-center gap-4">
            <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold">
                <i class="fab fa-php mr-2"></i>PHP 8+
            </span>
            <span class="bg-red-200 text-red-900 px-4 py-2 rounded-full font-semibold">
                <i class="fab fa-laravel mr-2"></i>Laravel 11
            </span>
            <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-semibold">
                <i class="fab fa-css3 mr-2"></i>Tailwind CSS
            </span>
            <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full font-semibold">
                <i class="fas fa-image mr-2"></i>Intervention Image
            </span>
            <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-semibold">
                <i class="fas fa-file-pdf mr-2"></i>DomPDF
            </span>
        </div>
    </div>
</div>
@endsection
