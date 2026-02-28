<?php

namespace App\Services;

/**
 * PayrollService - Cálculo de salario neto en Colombia
 * 
 * Deducciones aplicables en Colombia:
 * - Salud: 4% del salario base
 * - Pensión: 4% del salario base
 * - Retención en la fuente: Dependiendo del IBC (Ingreso Base de Cotización)
 */
class PayrollService
{
    /**
     * Porcentaje de deducciones de salud
     */
    const HEALTH_RATE = 0.04;
    
    /**
     * Porcentaje de deducciones de pensión
     */
    const PENSION_RATE = 0.04;

    /**
     * SMMLV 2026 (Salario Mínimo Mensual Legal Vigente)
     * Valor aproximado - se debe actualizar anualmente
     */
    const SMMLV = 1423500;

    /**
     * IBC (Ingreso Base de Cotización) máximo
     * 25 SMMLV
     */
    const MAX_IBC = 35587500;

    /**
     * Calcula el salario neto con deducciones de salud y pensión
     *
     * @param float $grossSalary Salario bruto
     * @param float $transportAllowance Auxilio de transporte (opcional)
     * @param array $deductions Deducciones adicionales (opcional)
     * @return array Resultado del cálculo
     */
    public function calculateNetSalary(
        float $grossSalary,
        float $transportAllowance = 0,
        array $deductions = []
    ): array {
        // Calcular deducciones de ley
        $healthDeduction = $grossSalary * self::HEALTH_RATE;
        $pensionDeduction = $grossSalary * self::PENSION_RATE;
        
        // Total deducciones de ley
        $lawDeductions = $healthDeduction + $pensionDeduction;
        
        // Deducciones adicionales
        $additionalDeductions = array_sum($deductions);
        
        // Total deducciones
        $totalDeductions = $lawDeductions + $additionalDeductions;
        
        // Salario neto
        $netSalary = $grossSalary + $transportAllowance - $totalDeductions;
        
        // Calcular IBC (Ingreso Base de Cotización)
        $ibc = $this->calculateIBC($grossSalary, $transportAllowance);
        
        // Calcular retención en la fuente
        $withholdingTax = $this->calculateWithholdingTax($grossSalary, $transportAllowance);
        
        return [
            'gross_salary' => round($grossSalary),
            'transport_allowance' => round($transportAllowance),
            'health_deduction' => round($healthDeduction),
            'pension_deduction' => round($pensionDeduction),
            'law_deductions' => round($lawDeductions),
            'additional_deductions' => round($additionalDeductions),
            'total_deductions' => round($totalDeductions),
            'withholding_tax' => round($withholdingTax),
            'ibc' => round($ibc),
            'net_salary' => round($netSalary - $withholdingTax),
            'net_salary_before_tax' => round($netSalary),
            'effective_rate' => round(($totalDeductions / $grossSalary) * 100, 2)
        ];
    }

    /**
     * Calcula el IBC (Ingreso Base de Cotización)
     *
     * @param float $grossSalary Salario bruto
     * @param float $transportAllowance Auxilio de transporte
     * @return float IBC
     */
    public function calculateIBC(float $grossSalary, float $transportAllowance = 0): float
    {
        // El IBC incluye el salario + bonificaciones + auxilios (excepto transporte)
        // No puede ser mayor a 25 SMMLV
        $ibc = $grossSalary;
        
        return min($ibc, self::MAX_IBC);
    }

    /**
     * Calcula la retención en la fuente aproximada
     * 
     * Sistema detarifa simplificada para empleados
     *
     * @param float $grossSalary Salario bruto
     * @param float $transportAllowance Auxilio de transporte
     * @return float Retención en la fuente
     */
    public function calculateWithholdingTax(float $grossSalary, float $transportAllowance = 0): float
    {
        $totalIncome = $grossSalary + $transportAllowance;
        
        // Rentas de trabajo - tabla simplificada 2026
        // Según la UIT (Unidad de Valor Tributario) vigente
        
        // Empleados con menos de 95 UVT de ingreso mensual no pagan retención
        $uvt = 47654; // Valor UVT 2026
        $exemptionLimit = 95 * $uvt; // 4,527,130
        
        if ($totalIncome <= $exemptionLimit) {
            return 0;
        }
        
        // Tarifa simplificada para empleados (gradual)
        $baseTaxable = $totalIncome - $exemptionLimit;
        
        // Aplica una tarifa progresiva simplificada
        // 0% hasta 1090 UVT, luego porcentajes superiores
        $secondLimit = 1090 * $uvt; // 51,983,060
        
        if ($baseTaxable <= 0) {
            return 0;
        }
        
        if ($baseTaxable <= $secondLimit) {
            // 0% para los primeros 1090 UVT
            return 0;
        }
        
        $excess = $baseTaxable - $secondLimit;
        
        // Tarifa simplificada del 10% sobre el exceso
        return round($excess * 0.10);
    }

    /**
     * Calcula las contribuciones a seguridad social del empleador
     *
     * @param float $grossSalary Salario bruto
     * @return array Contribuciones del empleador
     */
    public function employerContributions(float $grossSalary): array
    {
        $ibc = $this->calculateIBC($grossSalary);
        
        // Aportes del empleador (2026)
        $healthEmployer = $ibc * 0.085;     // 8.5%
        $pensionEmployer = $ibc * 0.12;      // 12%
        $arlEmployer = $ibc * 0.00524;       // 0.524% (riesgo clase 1)
        $compensationFund = $ibc * 0.04;     // 4%
        
        return [
            'ibc' => round($ibc),
            'health' => round($healthEmployer),
            'pension' => round($pensionEmployer),
            'arl' => round($arlEmployer),
            'compensation_fund' => round($compensationFund),
            'total' => round($healthEmployer + $pensionEmployer + $arlEmployer + $compensationFund)
        ];
    }

    /**
     * Calcula el costo total de nómina (empleado + empleador)
     *
     * @param float $grossSalary Salario bruto
     * @param float $transportAllowance Auxilio de transporte
     * @return array Costo total de nómina
     */
    public function totalPayrollCost(float $grossSalary, float $transportAllowance = 0): array
    {
        $employee = $this->calculateNetSalary($grossSalary, $transportAllowance);
        $employer = $this->employerContributions($grossSalary);
        
        return [
            'employee' => $employee,
            'employer' => $employer,
            'total_cost' => $grossSalary + $transportAllowance + $employer['total']
        ];
    }

    /**
     * Convierte el salario a términos de SMMLV
     *
     * @param float $salary Salario
     * @return float Salario en SMMLV
     */
    public function toSMMLV(float $salary): float
    {
        return round($salary / self::SMMLV, 2);
    }

    /**
     * Verifica si el salary está por encima del SMMLV
     *
     * @param float $salary Salario
     * @return bool
     */
    public function isAboveMinimumWage(float $salary): bool
    {
        return $salary >= self::SMMLV;
    }
}
