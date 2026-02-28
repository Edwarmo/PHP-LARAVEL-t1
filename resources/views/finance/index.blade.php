@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-calculator text-purple-600 mr-2"></i>
                Calculadora Financiera
            </h1>
            <p class="text-gray-600 mt-1">Calcula interés compuesto y compara con interés simple</p>
        </div>
    </div>

    <!-- Calculator Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-percent text-purple-600 mr-2"></i>Calculadora de Interés Compuesto
        </h2>
        
        <form action="{{ route('finance.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capital Inicial ($)</label>
                    <input type="number" name="principal" step="0.01" value="{{ old('principal', 1000000) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tasa de Interés Anual (%)</label>
                    <input type="number" name="rate" step="0.01" value="{{ old('rate', 12) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Años</label>
                    <input type="number" name="years" value="{{ old('years', 5) }}" min="1" max="50"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capitalizaciones por Año</label>
                    <select name="compounds_per_year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="1">Anual (1 vez/año)</option>
                        <option value="4">Trimestral (4 veces/año)</option>
                        <option value="12" selected>Mensual (12 veces/año)</option>
                        <option value="365">Diaria (365 veces/año)</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <input type="checkbox" name="comparison" id="comparison" value="1" class="w-4 h-4 text-purple-600 rounded">
                <label for="comparison" class="text-sm text-gray-700">Comparar con interés simple</label>
            </div>
            
            <button type="submit" name="calculate" value="1" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-calculator mr-2"></i>Calcular
            </button>
        </form>
    </div>

    <!-- Results -->
    @if($result)
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-chart-line text-green-600 mr-2"></i>Resultado - Interés Compuesto
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <p class="text-blue-600 font-medium">Capital Inicial</p>
                <p class="text-2xl font-bold text-blue-800">${{ number_format($result['principal'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <p class="text-green-600 font-medium">Monto Final</p>
                <p class="text-2xl font-bold text-green-800">${{ number_format($result['amount'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <p class="text-purple-600 font-medium">Interés Ganado</p>
                <p class="text-2xl font-bold text-purple-800">${{ number_format($result['interest_earned'], 0, ',', '.') }}</p>
            </div>
        </div>
        
        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-gray-500">Tasa Anual</p>
                <p class="font-semibold">{{ $result['rate'] }}%</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-gray-500">Tiempo</p>
                <p class="font-semibold">{{ $result['years'] }} años</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-gray-500">Capitalizaciones</p>
                <p class="font-semibold">{{ $result['compounds_per_year'] }}/año</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-gray-500">Retorno Total</p>
                <p class="font-semibold text-green-600">{{ $result['total_return_percentage'] }}%</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Comparison Results -->
    @if($comparison)
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-balance-scale text-purple-600 mr-2"></i>Comparación: Simple vs Compuesto
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Simple Interest -->
            <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                <h3 class="text-lg font-bold text-yellow-800 mb-4">
                    <i class="fas fa-minus-circle mr-2"></i>Interés Simple
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Capital Inicial:</span>
                        <span class="font-semibold">${{ number_format($comparison['simple']['principal'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Monto Final:</span>
                        <span class="font-semibold">${{ number_format($comparison['simple']['amount'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Interés Ganado:</span>
                        <span class="font-semibold text-yellow-700">${{ number_format($comparison['simple']['interest_earned'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Retorno:</span>
                        <span class="font-semibold">{{ $comparison['simple']['total_return_percentage'] }}%</span>
                    </div>
                </div>
            </div>
            
            <!-- Compound Interest -->
            <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                <h3 class="text-lg font-bold text-green-800 mb-4">
                    <i class="fas fa-plus-circle mr-2"></i>Interés Compuesto
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Capital Inicial:</span>
                        <span class="font-semibold">${{ number_format($comparison['compound']['principal'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Monto Final:</span>
                        <span class="font-semibold">${{ number_format($comparison['compound']['amount'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Interés Ganado:</span>
                        <span class="font-semibold text-green-700">${{ number_format($comparison['compound']['interest_earned'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Retorno:</span>
                        <span class="font-semibold">{{ $comparison['compound']['total_return_percentage'] }}%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Difference -->
        <div class="mt-6 bg-blue-50 rounded-lg p-4 text-center">
            <p class="text-blue-600 font-medium">Diferencia a favor de interés compuesto</p>
            <p class="text-3xl font-bold text-blue-800">${{ number_format($comparison['difference'], 0, ',', '.') }}</p>
        </div>
    </div>
    @endif

    <!-- Formula Explanation -->
    <div class="bg-gray-50 rounded-xl shadow-lg p-6">
        <h3 class="font-bold text-gray-800 mb-3">
            <i class="fas fa-info-circle text-purple-600 mr-2"></i>Fórmulas utilizadas:
        </h3>
        <div class="space-y-2 font-mono text-sm">
            <p class="bg-gray-800 text-green-400 p-3 rounded">
                Interés Simple: A = P(1 + rt)
            </p>
            <p class="bg-gray-800 text-green-400 p-3 rounded">
                Interés Compuesto: A = P(1 + r/n)^(nt)
            </p>
        </div>
        <p class="text-sm text-gray-600 mt-3">
            Donde: A = Monto final, P = Capital inicial, r = Tasa anual, n = Capitalizaciones/año, t = Años
        </p>
    </div>
</div>
@endsection
