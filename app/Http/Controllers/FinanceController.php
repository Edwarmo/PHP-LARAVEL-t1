<?php

namespace App\Http\Controllers;

use App\Services\FinanceService;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected FinanceService $financeService;

    public function __construct()
    {
        $this->financeService = new FinanceService();
    }

    /**
     * Muestra el formulario de cálculo de interés
     */
    public function index(Request $request)
    {
        $result = null;
        $comparison = null;

        if ($request->has('calculate')) {
            $principal = (float) $request->principal;
            $rate = (float) $request->rate;
            $years = (int) $request->years;
            $compoundsPerYear = (int) $request->compounds_per_year;
            
            if ($request->comparison) {
                $comparison = $this->financeService->compareInterestTypes($principal, $rate, $years);
            } else {
                $result = $this->financeService->compoundInterest($principal, $rate, $years, $compoundsPerYear);
            }
        }

        return view('finance.index', compact('result', 'comparison'));
    }

    /**
     * Calcula interés compuesto con aportaciones
     */
    public function withContributions(Request $request)
    {
        $result = null;

        if ($request->has('calculate')) {
            $initialPrincipal = (float) $request->initial_principal;
            $monthlyContribution = (float) $request->monthly_contribution;
            $rate = (float) $request->rate;
            $years = (int) $request->years;

            $result = $this->financeService->compoundInterestWithContributions(
                $initialPrincipal,
                $monthlyContribution,
                $rate,
                $years
            );
        }

        return view('finance.contributions', compact('result'));
    }
}
