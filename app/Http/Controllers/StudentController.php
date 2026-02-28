<?php

namespace App\Http\Controllers;

use App\Services\FinanceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Array de estudiantes de ejemplo
     * Estructura: ['nombre' => string, 'calificacion' => float, 'carrera' => string]
     */
    protected array $students = [
        ['nombre' => 'Juan Pérez', 'calificacion' => 4.5, 'carrera' => 'Ingeniería de Sistemas'],
        ['nombre' => 'María García', 'calificacion' => 4.8, 'carrera' => 'Ingeniería de Sistemas'],
        ['nombre' => 'Carlos López', 'calificacion' => 3.9, 'carrera' => 'Ingeniería de Sistemas'],
        ['nombre' => 'Ana Martínez', 'calificacion' => 4.2, 'carrera' => 'Ingeniería de Sistemas'],
        ['nombre' => 'Pedro Sánchez', 'calificacion' => 3.5, 'carrera' => 'Ingeniería de Sistemas'],
        ['nombre' => 'Laura Rodríguez', 'calificacion' => 4.6, 'carrera' => 'Medicina'],
        ['nombre' => 'Jorge Wilson', 'calificacion' => 4.3, 'carrera' => 'Medicina'],
        ['nombre' => 'Sofia Hernández', 'calificacion' => 4.9, 'carrera' => 'Medicina'],
        ['nombre' => 'Miguel Torres', 'calificacion' => 3.8, 'carrera' => 'Medicina'],
        ['nombre' => 'Isabella Díaz', 'calificacion' => 4.1, 'carrera' => 'Medicina'],
        ['nombre' => 'Diego Rivera', 'calificacion' => 4.7, 'carrera' => 'Derecho'],
        ['nombre' => 'Valentina Castro', 'calificacion' => 4.4, 'carrera' => 'Derecho'],
        ['nombre' => 'Alejandro Suárez', 'calificacion' => 3.6, 'carrera' => 'Derecho'],
        ['nombre' => 'Carmen Ortega', 'calificacion' => 4.0, 'carrera' => 'Derecho'],
        ['nombre' => 'Ricardo Vargas', 'calificacion' => 3.2, 'carrera' => 'Derecho'],
        ['nombre' => 'Fernanda López', 'calificacion' => 4.5, 'carrera' => 'Administración'],
        ['nombre' => 'Andrea Peña', 'calificacion' => 4.3, 'carrera' => 'Administración'],
        ['nombre' => 'Luis Herrera', 'calificacion' => 3.7, 'carrera' => 'Administración'],
        ['nombre' => 'Natalia Jiménez', 'calificacion' => 4.1, 'carrera' => 'Administración'],
        ['nombre' => 'David Moreno', 'calificacion' => 3.4, 'carrera' => 'Administración'],
    ];

    /**
     * Muestra el formulario y procesa los datos de estudiantes
     */
    public function index(Request $request)
    {
        // Usar datos de ejemplo o datos personalizados del formulario
        $students = $this->students;
        
        if ($request->has('custom_students') && $request->custom_students) {
            $students = $this->parseCustomStudents($request->students_data);
        }

        // Calcular promedio por carrera
        $averagesByCareer = $this->calculateAveragesByCareer($students);
        
        // Identificar carrera con menor promedio
        $lowestAverageCareer = $this->getLowestAverageCareer($averagesByCareer);
        
        // Listar estudiantes por encima del promedio de su carrera
        $studentsAboveAverage = $this->getStudentsAboveAverage($students, $averagesByCareer);
        
        // Promedio general
        $generalAverage = $this->calculateGeneralAverage($students);
        
        // Carreras disponibles
        $careers = array_keys($averagesByCareer);

        return view('students.index', compact(
            'students',
            'averagesByCareer',
            'lowestAverageCareer',
            'studentsAboveAverage',
            'generalAverage',
            'careers'
        ));
    }

    /**
     * Procesa datos personalizados de estudiantes
     */
    protected function parseCustomStudents(?string $data): array
    {
        if (empty($data)) {
            return $this->students;
        }

        $lines = explode("\n", trim($data));
        $students = [];

        foreach ($lines as $line) {
            $parts = array_map('trim', explode(',', $line));
            if (count($parts) >= 3) {
                $students[] = [
                    'nombre' => $parts[0],
                    'calificacion' => (float) $parts[1],
                    'carrera' => $parts[2]
                ];
            }
        }

        return empty($students) ? $this->students : $students;
    }

    /**
     * Calcula el promedio por carrera
     *
     * @param array $students
     * @return array
     */
    public function calculateAveragesByCareer(array $students): array
    {
        $careerTotals = [];
        $careerCounts = [];

        foreach ($students as $student) {
            $career = $student['carrera'];
            
            if (!isset($careerTotals[$career])) {
                $careerTotals[$career] = 0;
                $careerCounts[$career] = 0;
            }
            
            $careerTotals[$career] += $student['calificacion'];
            $careerCounts[$career]++;
        }

        $averages = [];
        foreach ($careerTotals as $career => $total) {
            $averages[$career] = round($total / $careerCounts[$career], 2);
        }

        return $averages;
    }

    /**
     * Identifica la carrera con menor promedio
     *
     * @param array $averagesByCareer
     * @return array
     */
    public function getLowestAverageCareer(array $averagesByCareer): array
    {
        if (empty($averagesByCareer)) {
            return ['carrera' => 'N/A', 'promedio' => 0];
        }

        $lowestCareer = '';
        $lowestAverage = PHP_FLOAT_MAX;

        foreach ($averagesByCareer as $career => $average) {
            if ($average < $lowestAverage) {
                $lowestAverage = $average;
                $lowestCareer = $career;
            }
        }

        return [
            'carrera' => $lowestCareer,
            'promedio' => $lowestAverage
        ];
    }

    /**
     * Lista estudiantes por encima del promedio de su carrera
     *
     * @param array $students
     * @param array $averagesByCareer
     * @return array
     */
    public function getStudentsAboveAverage(array $students, array $averagesByCareer): array
    {
        $aboveAverage = [];

        foreach ($students as $student) {
            $career = $student['carrera'];
            $careerAverage = $averagesByCareer[$career] ?? 0;

            if ($student['calificacion'] > $careerAverage) {
                $aboveAverage[] = [
                    'nombre' => $student['nombre'],
                    'calificacion' => $student['calificacion'],
                    'carrera' => $career,
                    'promedio_carrera' => $careerAverage,
                    'diferencia' => round($student['calificacion'] - $careerAverage, 2)
                ];
            }
        }

        // Ordenar por calificación descendente
        usort($aboveAverage, function($a, $b) {
            return $b['calificacion'] <=> $a['calificacion'];
        });

        return $aboveAverage;
    }

    /**
     * Calcula el promedio general de todos los estudiantes
     *
     * @param array $students
     * @return float
     */
    public function calculateGeneralAverage(array $students): float
    {
        if (empty($students)) {
            return 0;
        }

        $total = array_sum(array_column($students, 'calificacion'));
        return round($total / count($students), 2);
    }

    /**
     * Exporta los resultados a PDF
     */
    public function exportPdf(Request $request)
    {
        $students = $this->students;
        
        if ($request->has('custom_students') && $request->custom_students) {
            $students = $this->parseCustomStudents($request->students_data);
        }

        $averagesByCareer = $this->calculateAveragesByCareer($students);
        $lowestAverageCareer = $this->getLowestAverageCareer($averagesByCareer);
        $studentsAboveAverage = $this->getStudentsAboveAverage($students, $averagesByCareer);
        $generalAverage = $this->calculateGeneralAverage($students);
        $careers = array_keys($averagesByCareer);

        $pdf = Pdf::loadView('students.pdf', compact(
            'students',
            'averagesByCareer',
            'lowestAverageCareer',
            'studentsAboveAverage',
            'generalAverage',
            'careers'
        ));

        return $pdf->download('reporte_estudiantes.pdf');
    }

    /**
     * Muestra el formulario para agregar estudiantes
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Procesa el formulario de estudiantes
     */
    public function store(Request $request)
    {
        return redirect()->route('students.index', [
            'custom_students' => true,
            'students_data' => $request->students_data
        ]);
    }
}
