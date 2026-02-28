<?php

namespace App\Services;

/**
 * FinanceService - Cálculos de interés compuesto
 * 
 * Calcula el interés compuesto usando la fórmula: A = P(1 + r/n)^(nt)
 * Donde:
 * - A = Monto final
 * - P = Principal (capital inicial)
 * - r = Tasa de interés anual (en decimal)
 * - n = Número de veces que se capitaliza por año
 * - t = Tiempo en años
 */
class FinanceService
{
    /**
     * Calcula el interés compuesto
     *
     * @param float $principal Capital inicial
     * @param float $rate Tasa de interés anual (porcentaje)
     * @param int $years Años
     * @param int $compoundsPerYear Número de capitalizaciones por año (default: 12 mensual)
     * @return array Resultado del cálculo
     */
    public function compoundInterest(float $principal, float $rate, int $years, int $compoundsPerYear = 12): array
    {
        $rateDecimal = $rate / 100;
        
        // Fórmula: A = P(1 + r/n)^(nt)
        $amount = $principal * pow(1 + $rateDecimal / $compoundsPerYear, $compoundsPerYear * $years);
        
        // Calcular el interés ganado
        $interestEarned = $amount - $principal;
        
        return [
            'principal' => $principal,
            'rate' => $rate,
            'years' => $years,
            'compounds_per_year' => $compoundsPerYear,
            'amount' => round($amount, 2),
            'interest_earned' => round($interestEarned, 2),
            'total_return_percentage' => round(($interestEarned / $principal) * 100, 2)
        ];
    }

    /**
     * Calcula el interés compuesto con aportaciones periódicas
     *
     * @param float $initialPrincipal Capital inicial
     * @param float $monthlyContribution	Aportación mensual
     * @param float $rate Tasa de interés anual (porcentaje)
     * @param int $years Años
     * @return array Resultado del cálculo
     */
    public function compoundInterestWithContributions(
        float $initialPrincipal,
        float $monthlyContribution,
        float $rate,
        int $years
    ): array {
        $rateDecimal = $rate / 100;
        $months = $years * 12;
        $monthlyRate = $rateDecimal / 12;
        
        // Capital inicial crecimiento
        $initialAmount = $initialPrincipal * pow(1 + $monthlyRate, $months);
        
        // Serie de aportaciones futuras (anualidad)
        // FV = PMT * [(1 + r)^n - 1] / r
        $contributionsAmount = $monthlyContribution * 
            (pow(1 + $monthlyRate, $months) - 1) / $monthlyRate;
        
        $totalAmount = $initialAmount + $contributionsAmount;
        $totalContributions = $monthlyContribution * $months;
        $totalInterest = $totalAmount - $initialPrincipal - $totalContributions;
        
        return [
            'initial_principal' => $initialPrincipal,
            'monthly_contribution' => $monthlyContribution,
            'rate' => $rate,
            'years' => $years,
            'months' => $months,
            'total_amount' => round($totalAmount, 2),
            'total_contributions' => round($totalContributions, 2),
            'interest_earned' => round($totalInterest, 2),
            'total_return_percentage' => round(($totalInterest / ($initialPrincipal + $totalContributions)) * 100, 2)
        ];
    }

    /**
     * Calcula el valor futuro con tasa de interés simple
     *
     * @param float $principal Capital inicial
     * @param float $rate Tasa de interés anual (porcentaje)
     * @param int $years Años
     * @return array Resultado del cálculo
     */
    public function simpleInterest(float $principal, float $rate, int $years): array
    {
        $rateDecimal = $rate / 100;
        
        // Fórmula: A = P(1 + rt)
        $amount = $principal * (1 + $rateDecimal * $years);
        $interestEarned = $amount - $principal;
        
        return [
            'principal' => $principal,
            'rate' => $rate,
            'years' => $years,
            'amount' => round($amount, 2),
            'interest_earned' => round($interestEarned, 2),
            'total_return_percentage' => round(($interestEarned / $principal) * 100, 2)
        ];
    }

    /**
     * Compara interés simple vs compuesto
     *
     * @param float $principal Capital inicial
     * @param float $rate Tasa de interés anual (porcentaje)
     * @param int $years Años
     * @return array Comparación
     */
    public function compareInterestTypes(float $principal, float $rate, int $years): array
    {
        return [
            'simple' => $this->simpleInterest($principal, $rate, $years),
            'compound' => $this->compoundInterest($principal, $rate, $years),
            'difference' => round(
                $this->compoundInterest($principal, $rate, $years)['amount'] - 
                $this->simpleInterest($principal, $rate, $years)['amount'],
                2
            )
        ];
    }
}
