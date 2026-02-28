<?php

namespace App\Http\Controllers;

use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected PayrollService $payrollService;

    public function __construct()
    {
        $this->payrollService = new PayrollService();
    }

    /**
     * Muestra el formulario de cálculo de nómina
     */
    public function index(Request $request)
    {
        $result = null;
        $employerContributions = null;
        $totalCost = null;
        $inSMMLV = null;

        if ($request->has('calculate')) {
            $grossSalary = (float) $request->gross_salary;
            $transportAllowance = (float) $request->transport_allowance;
            
            $result = $this->payrollService->calculateNetSalary($grossSalary, $transportAllowance);
            $employerContributions = $this->payrollService->employerContributions($grossSalary);
            $totalCost = $this->payrollService->totalPayrollCost($grossSalary, $transportAllowance);
            $inSMMLV = $this->payrollService->toSMMLV($grossSalary);
        }

        return view('payroll.index', compact('result', 'employerContributions', 'totalCost', 'inSMMLV'));
    }
}
