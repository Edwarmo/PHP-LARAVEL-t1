@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-user-graduate text-blue-600 mr-2"></i>
                Gestión de Estudiantes
            </h1>
            <p class="text-gray-600 mt-1">Procesa arreglo de estudiantes por carrera</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <a href="{{ route('students.export-pdf') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
            </a>
            <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Agregar
            </a>
        </div>
    </div>

    <!-- Custom Data Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-edit text-blue-600 mr-2"></i>Ingresar Datos Personalizados
        </h2>
        <form action="{{ route('students.index') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Datos de Estudiantes</label>
                <p class="text-xs text-gray-500 mb-2">Formato: Nombre, Calificación, Carrera (uno por línea)</p>
                <textarea name="students_data" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Juan Pérez, 4.5, Ingeniería de Sistemas&#10;María García, 4.8, Medicina"></textarea>
            </div>
            <input type="hidden" name="custom_students" value="1">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-calculator mr-2"></i>Procesar
            </button>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- General Average -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100">Promedio General</p>
                    <p class="text-3xl font-bold">{{ $generalAverage }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Lowest Average Career -->
        <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100">Carrera con Menor Promedio</p>
                    <p class="text-lg font-bold">{{ $lowestAverageCareer['carrera'] }}</p>
                    <p class="text-2xl font-bold">{{ $lowestAverageCareer['promedio'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-arrow-down text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Students Above Average -->
        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100">Estudiantes Destacados</p>
                    <p class="text-3xl font-bold">{{ count($studentsAboveAverage) }}</p>
                    <p class="text-sm text-green-100">Por encima del promedio</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-star text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Averages by Career -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-chart-bar text-blue-600 mr-2"></i>Promedio por Carrera
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($averagesByCareer as $career => $average)
            <div class="border border-gray-200 rounded-lg p-4 {{ $career === $lowestAverageCareer['carrera'] ? 'bg-red-50 border-red-300' : '' }}">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-700">{{ $career }}</span>
                    <span class="text-2xl font-bold {{ $career === $lowestAverageCareer['carrera'] ? 'text-red-600' : 'text-blue-600' }}">
                        {{ $average }}
                    </span>
                </div>
                <div class="mt-2 bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($average / 5) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Students Above Average -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-star text-yellow-500 mr-2"></i>Estudiantes Por Encima del Promedio
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Nombre</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Carrera</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Calificación</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Promedio Carrera</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Diferencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentsAboveAverage as $student)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $student['nombre'] }}</td>
                        <td class="px-4 py-3">{{ $student['carrera'] }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded font-semibold">
                                {{ $student['calificacion'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $student['promedio_carrera'] }}</td>
                        <td class="px-4 py-3 text-green-600 font-semibold">+{{ $student['diferencia'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- All Students -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-users text-blue-600 mr-2"></i>Todos los Estudiantes
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">#</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Nombre</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Carrera</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Calificación</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium">{{ $student['nombre'] }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                {{ $student['carrera'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-semibold {{ $student['calificacion'] >= 4.5 ? 'text-green-600' : ($student['calificacion'] >= 3.5 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $student['calificacion'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if(in_array($student['nombre'], array_column($studentsAboveAverage, 'nombre')))
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                <i class="fas fa-star mr-1"></i>Destacado
                            </span>
                            @else
                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-sm">Normal</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
