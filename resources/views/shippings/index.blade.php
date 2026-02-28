@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-shipping-fast text-green-600 mr-2"></i>
                Control de Envíos
            </h1>
            <p class="text-gray-600 mt-1">Procesa envíos con ciudad, transportista, peso y estado</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('shippings.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i>Agregar
            </a>
        </div>
    </div>

    <!-- Custom Data Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-edit text-green-600 mr-2"></i>Ingresar Datos Personalizados
        </h2>
        <form action="{{ route('shippings.index') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Datos de Envíos</label>
                <p class="text-xs text-gray-500 mb-2">Formato: Ciudad, Transportista, Peso, Costo/kg, Estado (uno por línea)</p>
                <textarea name="shipments_data" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Bogotá, Servientrega, 5.5, 2500, Entregado"></textarea>
            </div>
            <input type="hidden" name="custom_shipments" value="1">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-calculator mr-2"></i>Procesar
            </button>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Delivered Total Cost -->
        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100">Costo Total Entregados</p>
                    <p class="text-2xl font-bold">${{ number_format($deliveredTotalCost, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- City with Highest Weight -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100">Ciudad con Mayor Peso</p>
                    <p class="text-xl font-bold">{{ $cityWithHighestWeight['ciudad'] }}</p>
                    <p class="text-lg">{{ $cityWithHighestWeight['peso'] }} kg</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-weight-hanging text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Carrier with Most Deliveries -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100">Mejor Transportista</p>
                    <p class="text-xl font-bold">{{ $carrierWithMostDeliveries['transportista'] }}</p>
                    <p class="text-lg">{{ $carrierWithMostDeliveries['entregas'] }} entregas</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i class="fas fa-trophy text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats by Carrier -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-truck text-blue-600 mr-2"></i>Estadísticas por Transportista
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Transportista</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Total Envíos</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Entregados</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">En Tránsito</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Pendientes</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Peso Total (kg)</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Costo Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrierStats as $carrier => $stats)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $carrier }}</td>
                        <td class="px-4 py-3">{{ $stats['total_shipments'] }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">{{ $stats['delivered'] }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $stats['in_transit'] }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">{{ $stats['pending'] }}</span>
                        </td>
                        <td class="px-4 py-3">{{ number_format($stats['total_weight'], 2) }}</td>
                        <td class="px-4 py-3">${{ number_format($stats['total_cost'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stats by City -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-city text-purple-600 mr-2"></i>Estadísticas por Ciudad
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Ciudad</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Envíos</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Peso Total (kg)</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Peso Promedio</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Costo Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cityStats as $city => $stats)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $city }}</td>
                        <td class="px-4 py-3">{{ $stats['shipments'] }}</td>
                        <td class="px-4 py-3">{{ number_format($stats['total_weight'], 2) }}</td>
                        <td class="px-4 py-3">{{ number_format($stats['avg_weight'], 2) }}</td>
                        <td class="px-4 py-3">${{ number_format($stats['total_cost'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- All Shipments -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-boxes text-green-600 mr-2"></i>Todos los Envíos
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">#</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Ciudad</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Transportista</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Peso (kg)</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Costo/kg</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Costo Total</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shipments as $index => $shipment)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">{{ $shipment['id'] }}</td>
                        <td class="px-4 py-3 font-medium">{{ $shipment['ciudad'] }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                {{ $shipment['transportista'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $shipment['peso'] }}</td>
                        <td class="px-4 py-3">${{ number_format($shipment['costo_kg'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 font-semibold">${{ number_format($shipment['peso'] * $shipment['costo_kg'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            @switch($shipment['estado'])
                                @case('Entregado')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                        <i class="fas fa-check-circle mr-1"></i>Entregado
                                    </span>
                                    @break
                                @case('En tránsito')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                        <i class="fas fa-truck mr-1"></i>En tránsito
                                    </span>
                                    @break
                                @case('Pendiente')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">
                                        <i class="fas fa-clock mr-1"></i>Pendiente
                                    </span>
                                    @break
                                @case('Cancelado')
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">
                                        <i class="fas fa-times-circle mr-1"></i>Cancelado
                                    </span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
