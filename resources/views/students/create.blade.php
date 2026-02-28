@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('students.index') }}" class="text-blue-600 hover:text-blue-800 mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-user-plus text-blue-600 mr-2"></i>
            Agregar Estudiantes
        </h1>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-users text-blue-600 mr-2"></i>Datos de Estudiantes
                </label>
                <p class="text-xs text-gray-500 mb-3">
                    Ingrese los datos en el formato: Nombre, Calificación, Carrera<br>
                    Un estudiante por línea
                </p>
                <textarea 
                    name="students_data" 
                    rows="10" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                    placeholder="Juan Pérez, 4.5, Ingeniería de Sistemas&#10;María García, 4.8, Medicina&#10;Carlos López, 3.9, Derecho"
                ></textarea>
            </div>
            
            <div class="flex justify-end gap-3">
                <a href="{{ route('students.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar y Procesar
                </button>
            </div>
        </form>
    </div>

    <!-- Ejemplos -->
    <div class="bg-gray-50 rounded-xl shadow-lg p-6 mt-6">
        <h3 class="font-bold text-gray-800 mb-3">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>Ejemplo de formato:
        </h3>
        <pre class="bg-gray-800 text-green-400 p-4 rounded-lg overflow-x-auto text-sm font-mono">
Juan Pérez, 4.5, Ingeniería de Sistemas
María García, 4.8, Medicina
Carlos López, 3.9, Derecho
Ana Martínez, 4.2, Administración
        </pre>
    </div>
</div>
@endsection
