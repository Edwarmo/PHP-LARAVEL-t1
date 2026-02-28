@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-user-check text-green-600 mr-2"></i>
            Perfil Creado
        </h1>
        <p class="text-gray-600 mt-1">El perfil ha sido procesado exitosamente</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex flex-col items-center">
            <!-- Profile Image -->
            <div class="mb-6">
                <img src="{{ $profile['photo_url'] }}" alt="{{ $profile['name'] }}" class="w-48 h-48 rounded-full shadow-lg object-cover border-4 border-blue-500">
            </div>
            
            <!-- Profile Info -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $profile['name'] }}</h2>
            <p class="text-gray-600 mb-6">{{ $profile['email'] }}</p>
            
            <!-- Image Info -->
            <div class="w-full bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-700 mb-3">
                    <i class="fas fa-image text-blue-600 mr-2"></i>Información de la Imagen
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nombre del archivo:</span>
                        <span class="font-medium">{{ $profile['photo'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dimensiones:</span>
                        <span class="font-medium">{{ $profile['dimensions'] }} px</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tamaño original:</span>
                        <span class="font-medium">{{ number_format($profile['original_size'] / 1024, 2) }} KB</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tamaño procesado:</span>
                        <span class="font-medium">{{ number_format($profile['processed_size'] / 1024, 2) }} KB</span>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="mt-6 flex gap-3">
                <a href="{{ route('profile.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>Crear Nuevo
                </a>
                <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-home mr-2"></i>Inicio
                </a>
            </div>
        </div>
    </div>

    <!-- Processing Info -->
    <div class="bg-green-50 rounded-xl shadow-lg p-6 mt-6">
        <h3 class="font-bold text-green-800 mb-3">
            <i class="fas fa-check-circle text-green-600 mr-2"></i>Procesamiento completado
        </h3>
        <p class="text-sm text-gray-700">
            La imagen fue procesada exitosamente usando <strong>Intervention Image</strong>. 
            La imagen fue redimensionada a <strong>300x300 píxeles</strong> y guardada en formato JPG 
            con calidad del 85%.
        </p>
    </div>
</div>
@endsection
