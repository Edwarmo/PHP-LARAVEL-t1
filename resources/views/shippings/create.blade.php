@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('shippings.index') }}" class="text-green-600 hover:text-green-800 mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-plus text-green-600 mr-2"></i>
            Agregar Envíos
        </h1>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('shippings.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-box text-green-600 mr-2"></i>Datos de Envíos
                </label>
                <p class="text-xs text-gray-500 mb-3">
                    Ingrese los datos en el formato: Ciudad, Transportista, Peso, Costo/kg, Estado<br>
                    Un envío por línea
                </p>
                <textarea 
                    name="shipments_data" 
                    rows="10" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 font-mono text-sm"
                    placeholder="Bogotá, Servientrega, 5.5, 2500, Entregado&#10;Medellín, DHL, 3.2, 3200, En tránsito"
                ></textarea>
            </div>
            
            <div class="flex justify-end gap-3">
                <a href="{{ route('shippings.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar y Procesar
                </button>
            </div>
        </form>
    </div>

    <!-- Ejemplos -->
    <div class="bg-gray-50 rounded-xl shadow-lg p-6 mt-6">
        <h3 class="font-bold text-gray-800 mb-3">
            <i class="fas fa-info-circle text-green-600 mr-2"></i>Estados disponibles:
        </h3>
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded">Entregado</span>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded">En tránsito</span>
            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded">Pendiente</span>
            <span class="bg-red-100 text-red-800 px-3 py-1 rounded">Cancelado</span>
        </div>
        
        <h3 class="font-bold text-gray-800 mb-3">
            <i class="fas fa-info-circle text-green-600 mr-2"></i>Transportistas disponibles:
        </h3>
        <div class="flex flex-wrap gap-2">
            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded">Servientrega</span>
            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded">FedEx</span>
            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded">DHL</span>
        </div>
    </div>
</div>
@endsection
