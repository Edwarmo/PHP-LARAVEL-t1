@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-money-bill-wave text-yellow-600 mr-2"></i>
                Cálculo de Nómina - Colombia
            </h1>
            <p class="text-gray-600 mt-1">Calcula salario neto con deducciones de ley</p>
        </div>
    </div>

    <!-- Calculator Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-calculator text-yellow-600 mr-2"></i>Calculadora de Salario Neto
        </h2>
        
        <form action="{{ route('payroll.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Salario Bruto ($)</label>
                    <input type="number" name="gross_salary" step="1" value="{{ old('gross_salary', 2500000) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" required>
                    <p class="text-xs text-gray-500 mt-1">SMMLV 2026: $1,423,500</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Auxilio de Transporte ($)</label>
                    <input type="number" name="transport_allowance" step="1" value="{{ old('transport_allowance', 0) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>
            </div>
            
            <button type="submit" name="calculate" value="1" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition">
                <i class="fas fa-calculator mr-2"></i>Calcular
            </button>
        </form>
    </div>

    <!-- Results -->
    @if($result)
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-receipt text-green-600 mr-2"></i>Desglose de Salario
        </h2>
        
        <!-- Income -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Ingresos</h3>
            <div class="bg-green-50 rounded-lg p-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-700">Salario Bruto:</span>
                    <span class="font-semibold">${{ number_format($result['gross_salary'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Auxilio de Transporte:</span>
                    <span class="font-semibold">${{ number_format($result['transport_allowance'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-t border-green-200 pt-2 mt-2">
                    <span class="text-gray-700 font-semibold">Total Ingresos:</span>
                    <span class="font-bold text-green-700">${{ number_format($result['gross_salary'] + $result['transport_allowance'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Deductions -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Deducciones</h3>
            <div class="bg-red-50 rounded-lg p-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-700">Salud (4%):</span>
                    <span class="font-semibold">-${{ number_format($result['health_deduction'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Pensión (4%):</span>
                    <span class="font-semibold">-${{ number_format($result['pension_deduction'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Total Deducciones de Ley:</span>
                    <span class="font-semibold">-${{ number_format($result['law_deductions'], 0, ',', '.') }}</span>
                </div>
                @if($result['withholding_tax'] > 0)
                <div class="flex justify-between">
                    <span class="text-gray-700">Retención en la Fuente:</span>
                    <span class="font-semibold">-${{ number_format($result['withholding_tax'], 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between border-t border-red-200 pt-2 mt-2">
                    <span class="text-gray-700 font-semibold">Total Deducciones:</span>
                    <span class="font-bold text-red-700">-${{ number_format($result['total_deductions'] + $result['withholding_tax'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Net Salary -->
        <div class="bg-blue-50 rounded-lg p-6 text-center">
            <p class="text-blue-600 font-medium">Salario Neto a Recibir</p>
            <p class="text-4xl font-bold text-blue-800">${{ number_format($result['net_salary'], 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mt-2">Tasa efectiva de deducciones: {{ $result['effective_rate'] }}%</p>
        </div>
    </div>
    
    <!-- Employer Contributions -->
    @if($employerContributions)
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-building text-purple-600 mr-2"></i>Aportes del Empleador
        </h2>
        
        <div class="bg-purple-50 rounded-lg p-4 space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-700">Salud (8.5%):</span>
                <span class="font-semibold">${{ number_format($employerContributions['health'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-700">Pensión (12%):</span>
                <span class="font-semibold">${{ number_format($employerContributions['pension'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-700">ARL (0.524%):</span>
                <span class="font-semibold">${{ number_format($employerContributions['arl'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-700">Caja de Compensación (4%):</span>
                <span class="font-semibold">${{ number_format($employerContributions['compensation_fund'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between border-t border-purple-200 pt-2 mt-2">
                <span class="text-gray-700 font-semibold">Total Aportes:</span>
                <span class="font-bold text-purple-700">${{ number_format($employerContributions['total'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Total Cost -->
    @if($totalCost)
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-dollar-sign text-green-600 mr-2"></i>Costo Total de Nómina
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-gray-600">Del empleado:</p>
                <p class="text-2xl font-bold text-green-600">${{ number_format($result['net_salary'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-gray-600">Del empleador:</p>
                <p class="text-2xl font-bold text-purple-600">${{ number_format($employerContributions['total'], 0, ',', '.') }}</p>
            </div>
        </div>
        
        <div class="mt-4 bg-gradient-to-r from-green-500 to-blue-500 rounded-lg p-4 text-center text-white">
            <p class="font-medium">Costo Total para la Empresa:</p>
            <p class="text-3xl font-bold">${{ number_format($totalCost['total_cost'], 0, ',', '.') }}</p>
        </div>
    </div>
    @endif
    @endif

    <!-- Info -->
    <div class="bg-gray-50 rounded-xl shadow-lg p-6">
        <h3 class="font-bold text-gray-800 mb-3">
            <i class="fas fa-info-circle text-yellow-600 mr-2"></i>Deducciones aplicables en Colombia:
        </h3>
        <ul class="space-y-2 text-sm text-gray-600">
            <li><i class="fas fa-check text-green-500 mr-2"></i><strong>Salud:</strong> 4% del salario base (empleado)</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i><strong>Pensión:</strong> 4% del salario base (empleado)</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i><strong>Salud:</strong> 8.5% del IBC (empleador)</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i><strong>Pensión:</strong> 12% del IBC (empleador)</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i><strong>ARL:</strong> 0.524% - 6.96% según riesgo (empleador)</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i><strong>Compensación:</strong> 4% (empleador)</li>
        </ul>
    </div>
</div>
@endsection
