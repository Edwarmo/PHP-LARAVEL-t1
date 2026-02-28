<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Array asociativo de envíos de ejemplo
     * Estructura: ['id' => int, 'ciudad' => string, 'transportista' => string, 'peso' => float, 'costo_kg' => float, 'estado' => string]
     */
    protected array $shipments = [
        ['id' => 1, 'ciudad' => 'Bogotá', 'transportista' => 'Servientrega', 'peso' => 5.5, 'costo_kg' => 2500, 'estado' => 'Entregado'],
        ['id' => 2, 'ciudad' => 'Medellín', 'transportista' => 'FedEx', 'peso' => 3.2, 'costo_kg' => 3200, 'estado' => 'Entregado'],
        ['id' => 3, 'ciudad' => 'Cali', 'transportista' => 'DHL', 'peso' => 8.0, 'costo_kg' => 2800, 'estado' => 'En tránsito'],
        ['id' => 4, 'ciudad' => 'Bogotá', 'transportista' => 'DHL', 'peso' => 2.1, 'costo_kg' => 3500, 'estado' => 'Entregado'],
        ['id' => 5, 'ciudad' => 'Barranquilla', 'transportista' => 'Servientrega', 'peso' => 12.0, 'costo_kg' => 2200, 'estado' => 'Entregado'],
        ['id' => 6, 'ciudad' => 'Medellín', 'transportista' => 'Servientrega', 'peso' => 6.8, 'costo_kg' => 2600, 'estado' => 'En tránsito'],
        ['id' => 7, 'ciudad' => 'Cali', 'transportista' => 'FedEx', 'peso' => 4.5, 'costo_kg' => 3000, 'estado' => 'Entregado'],
        ['id' => 8, 'ciudad' => 'Bogotá', 'transportista' => 'FedEx', 'peso' => 1.5, 'costo_kg' => 4000, 'estado' => 'Pendiente'],
        ['id' => 9, 'ciudad' => 'Cartagena', 'transportista' => 'DHL', 'peso' => 9.2, 'costo_kg' => 2700, 'estado' => 'Entregado'],
        ['id' => 10, 'ciudad' => 'Medellín', 'transportista' => 'DHL', 'peso' => 7.3, 'costo_kg' => 2900, 'estado' => 'Cancelado'],
        ['id' => 11, 'ciudad' => 'Cali', 'transportista' => 'Servientrega', 'peso' => 11.5, 'costo_kg' => 2100, 'estado' => 'Entregado'],
        ['id' => 12, 'ciudad' => 'Bogotá', 'transportista' => 'Servientrega', 'peso' => 3.8, 'costo_kg' => 3100, 'estado' => 'En tránsito'],
        ['id' => 13, 'ciudad' => 'Barranquilla', 'transportista' => 'FedEx', 'peso' => 5.0, 'costo_kg' => 3300, 'estado' => 'Entregado'],
        ['id' => 14, 'ciudad' => 'Cartagena', 'transportista' => 'Servientrega', 'peso' => 8.7, 'costo_kg' => 2400, 'estado' => 'Entregado'],
        ['id' => 15, 'ciudad' => 'Cali', 'transportista' => 'DHL', 'peso' => 2.5, 'costo_kg' => 3600, 'estado' => 'Pendiente'],
        ['id' => 16, 'ciudad' => 'Medellín', 'transportista' => 'FedEx', 'peso' => 6.2, 'costo_kg' => 2800, 'estado' => 'Entregado'],
        ['id' => 17, 'ciudad' => 'Bogotá', 'transportista' => 'DHL', 'peso' => 4.0, 'costo_kg' => 3200, 'estado' => 'Entregado'],
        ['id' => 18, 'ciudad' => 'Barranquilla', 'transportista' => 'DHL', 'peso' => 10.3, 'costo_kg' => 2300, 'estado' => 'En tránsito'],
        ['id' => 19, 'ciudad' => 'Cartagena', 'transportista' => 'FedEx', 'peso' => 7.8, 'costo_kg' => 2600, 'estado' => 'Entregado'],
        ['id' => 20, 'ciudad' => 'Cali', 'transportista' => 'Servientrega', 'peso' => 3.3, 'costo_kg' => 2900, 'estado' => 'Entregado'],
    ];

    /**
     * Muestra el formulario y procesa los datos de envíos
     */
    public function index(Request $request)
    {
        $shipments = $this->shipments;
        
        if ($request->has('custom_shipments') && $request->custom_shipments) {
            $shipments = $this->parseCustomShipments($request->shipments_data);
        }

        // Calcular costo total de "Entregados"
        $deliveredTotalCost = $this->calculateDeliveredTotalCost($shipments);
        
        // Ciudad con mayor peso total
        $cityWithHighestWeight = $this->getCityWithHighestWeight($shipments);
        
        // Transportista con más entregas exitosas
        $carrierWithMostDeliveries = $this->getCarrierWithMostDeliveries($shipments);
        
        // Estadísticas adicionales
        $statusStats = $this->getStatusStatistics($shipments);
        $carrierStats = $this->getCarrierStatistics($shipments);
        $cityStats = $this->getCityStatistics($shipments);

        return view('shippings.index', compact(
            'shipments',
            'deliveredTotalCost',
            'cityWithHighestWeight',
            'carrierWithMostDeliveries',
            'statusStats',
            'carrierStats',
            'cityStats'
        ));
    }

    /**
     * Procesa datos personalizados de envíos
     */
    protected function parseCustomShipments(?string $data): array
    {
        if (empty($data)) {
            return $this->shipments;
        }

        $lines = explode("\n", trim($data));
        $shipments = [];
        $id = 1;

        foreach ($lines as $line) {
            $parts = array_map('trim', explode(',', $line));
            if (count($parts) >= 6) {
                $shipments[] = [
                    'id' => $id++,
                    'ciudad' => $parts[0],
                    'transportista' => $parts[1],
                    'peso' => (float) $parts[2],
                    'costo_kg' => (float) $parts[3],
                    'estado' => $parts[4]
                ];
            }
        }

        return empty($shipments) ? $this->shipments : $shipments;
    }

    /**
     * Calcula el costo total de envíos "Entregados"
     *
     * @param array $shipments
     * @return float
     */
    public function calculateDeliveredTotalCost(array $shipments): float
    {
        $totalCost = 0;

        foreach ($shipments as $shipment) {
            if ($shipment['estado'] === 'Entregado') {
                $totalCost += $shipment['peso'] * $shipment['costo_kg'];
            }
        }

        return round($totalCost, 2);
    }

    /**
     * Obtiene la ciudad con mayor peso total
     *
     * @param array $shipments
     * @return array
     */
    public function getCityWithHighestWeight(array $shipments): array
    {
        $cityWeights = [];

        foreach ($shipments as $shipment) {
            $city = $shipment['ciudad'];
            if (!isset($cityWeights[$city])) {
                $cityWeights[$city] = 0;
            }
            $cityWeights[$city] += $shipment['peso'];
        }

        if (empty($cityWeights)) {
            return ['ciudad' => 'N/A', 'peso' => 0];
        }

        $highestCity = '';
        $highestWeight = 0;

        foreach ($cityWeights as $city => $weight) {
            if ($weight > $highestWeight) {
                $highestWeight = $weight;
                $highestCity = $city;
            }
        }

        return [
            'ciudad' => $highestCity,
            'peso' => round($highestWeight, 2)
        ];
    }

    /**
     * Obtiene el transportista con más entregas exitosas
     *
     * @param array $shipments
     * @return array
     */
    public function getCarrierWithMostDeliveries(array $shipments): array
    {
        $carrierDeliveries = [];

        foreach ($shipments as $shipment) {
            if ($shipment['estado'] === 'Entregado') {
                $carrier = $shipment['transportista'];
                if (!isset($carrierDeliveries[$carrier])) {
                    $carrierDeliveries[$carrier] = 0;
                }
                $carrierDeliveries[$carrier]++;
            }
        }

        if (empty($carrierDeliveries)) {
            return ['transportista' => 'N/A', 'entregas' => 0];
        }

        $bestCarrier = '';
        $mostDeliveries = 0;

        foreach ($carrierDeliveries as $carrier => $deliveries) {
            if ($deliveries > $mostDeliveries) {
                $mostDeliveries = $deliveries;
                $bestCarrier = $carrier;
            }
        }

        return [
            'transportista' => $bestCarrier,
            'entregas' => $mostDeliveries
        ];
    }

    /**
     * Obtiene estadísticas por estado
     *
     * @param array $shipments
     * @return array
     */
    public function getStatusStatistics(array $shipments): array
    {
        $stats = [];

        foreach ($shipments as $shipment) {
            $status = $shipment['estado'];
            if (!isset($stats[$status])) {
                $stats[$status] = ['count' => 0, 'total_cost' => 0, 'total_weight' => 0];
            }
            $stats[$status]['count']++;
            $stats[$status]['total_cost'] += $shipment['peso'] * $shipment['costo_kg'];
            $stats[$status]['total_weight'] += $shipment['peso'];
        }

        return $stats;
    }

    /**
     * Obtiene estadísticas por transportista
     *
     * @param array $shipments
     * @return array
     */
    public function getCarrierStatistics(array $shipments): array
    {
        $stats = [];

        foreach ($shipments as $shipment) {
            $carrier = $shipment['transportista'];
            if (!isset($stats[$carrier])) {
                $stats[$carrier] = [
                    'total_shipments' => 0,
                    'delivered' => 0,
                    'in_transit' => 0,
                    'pending' => 0,
                    'cancelled' => 0,
                    'total_weight' => 0,
                    'total_cost' => 0
                ];
            }
            
            $stats[$carrier]['total_shipments']++;
            $stats[$carrier]['total_weight'] += $shipment['peso'];
            $stats[$carrier]['total_cost'] += $shipment['peso'] * $shipment['costo_kg'];
            
            switch ($shipment['estado']) {
                case 'Entregado':
                    $stats[$carrier]['delivered']++;
                    break;
                case 'En tránsito':
                    $stats[$carrier]['in_transit']++;
                    break;
                case 'Pendiente':
                    $stats[$carrier]['pending']++;
                    break;
                case 'Cancelado':
                    $stats[$carrier]['cancelled']++;
                    break;
            }
        }

        return $stats;
    }

    /**
     * Obtiene estadísticas por ciudad
     *
     * @param array $shipments
     * @return array
     */
    public function getCityStatistics(array $shipments): array
    {
        $stats = [];

        foreach ($shipments as $shipment) {
            $city = $shipment['ciudad'];
            if (!isset($stats[$city])) {
                $stats[$city] = [
                    'shipments' => 0,
                    'total_weight' => 0,
                    'total_cost' => 0
                ];
            }
            
            $stats[$city]['shipments']++;
            $stats[$city]['total_weight'] += $shipment['peso'];
            $stats[$city]['total_cost'] += $shipment['peso'] * $shipment['costo_kg'];
        }

        // Calcular promedios
        foreach ($stats as $city => &$stat) {
            $stat['avg_weight'] = round($stat['total_weight'] / $stat['shipments'], 2);
            $stat['avg_cost'] = round($stat['total_cost'] / $stat['shipments'], 2);
        }

        return $stats;
    }

    /**
     * Muestra el formulario para agregar envíos
     */
    public function create()
    {
        return view('shippings.create');
    }

    /**
     * Procesa el formulario de envíos
     */
    public function store(Request $request)
    {
        return redirect()->route('shippings.index', [
            'custom_shipments' => true,
            'shipments_data' => $request->shipments_data
        ]);
    }
}
