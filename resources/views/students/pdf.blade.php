<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Estudiantes</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 24px; color: #1e40af; }
        .stats { display: flex; justify-content: space-around; margin-bottom: 20px; }
        .stat-box { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: center; 
            border-radius: 5px;
            width: 30%;
        }
        .stat-box h3 { font-size: 12px; color: #666; margin: 0; }
        .stat-box p { font-size: 20px; font-weight: bold; color: #1e40af; margin: 5px 0 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #1e40af; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .section { margin-top: 30px; }
        .section h2 { font-size: 16px; color: #1e40af; border-bottom: 2px solid #1e40af; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Estudiantes</h1>
        <p>Taller PHP Avanzado - 2026-1</p>
        <p>Cristian Camilo Echeverri Giraldo</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>Promedio General</h3>
            <p>{{ $generalAverage }}</p>
        </div>
        <div class="stat-box">
            <h3>Carrera con Menor Promedio</h3>
            <p>{{ $lowestAverageCareer['carrera'] }}</p>
        </div>
        <div class="stat-box">
            <h3>Total Estudiantes</h3>
            <p>{{ count($students) }}</p>
        </div>
    </div>

    <div class="section">
        <h2>Promedio por Carrera</h2>
        <table>
            <thead>
                <tr>
                    <th>Carrera</th>
                    <th>Promedio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($averagesByCareer as $career => $average)
                <tr>
                    <td>{{ $career }}</td>
                    <td>{{ $average }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Estudiantes Por Encima del Promedio</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Calificación</th>
                    <th>Promedio Carrera</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentsAboveAverage as $student)
                <tr>
                    <td>{{ $student['nombre'] }}</td>
                    <td>{{ $student['carrera'] }}</td>
                    <td>{{ $student['calificacion'] }}</td>
                    <td>{{ $student['promedio_carrera'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Todos los Estudiantes</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student['nombre'] }}</td>
                    <td>{{ $student['carrera'] }}</td>
                    <td>{{ $student['calificacion'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
