<?php

namespace App\Controllers;

use App\Services\PuntosService;
use App\Models\PuntosModel;

class ComprasController extends BaseController
{
    public function index()
    {
        return view('compras/index');
    }

    // public function registrar()
    // {
    //     $clienteId = (int) $this->request->getPost('cliente_id');
    //     $monto     = (float) $this->request->getPost('monto');

    //     if ($clienteId <= 0 || $monto <= 0) {
    //         return $this->response->setJSON([
    //             'success' => false,
    //             'msg' => 'Datos inválidos'
    //         ]);
    //     }

    //     try {
    //         $service = new PuntosService();

    //         $resultado = $service->registrarCompra(
    //             $clienteId,
    //             session()->get('user_id'),
    //             $monto,
    //             'PEN' // moneda por ahora
    //         );

    //         return $this->response->setJSON([
    //             'success' => true,
    //             'puntos_generados' => $resultado['puntos'],
    //             'compra_id' => $resultado['compra_id']
    //         ]);

    //     } catch (\Throwable $e) {
    //         return $this->response->setJSON([
    //             'success' => false,
    //             'msg' => $e->getMessage()
    //         ]);
    //     }
    // }

    public function registrar()
    {
        $clienteId = (int) $this->request->getPost('cliente_id');
        $monto     = (float) $this->request->getPost('monto');

        // Validar datos básicos
        if ($clienteId <= 0 || $monto <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Datos inválidos'
            ]);
        }

        // Validar que el cliente existe y está activo
        $clienteModel = new \App\Models\ClienteModel();
        $cliente = $clienteModel->where('id', $clienteId)->where('estado', 1)->first();

        if (!$cliente) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Cliente no encontrado o inactivo'
            ]);
        }

        // Usar el servicio de puntos que ahora maneja campañas
        $puntosService = new PuntosService();
        $resultado = $puntosService->registrarCompra(
            $clienteId,
            session()->get('user_id'),
            $monto
        );

        if (!$resultado['success']) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => $resultado['message']
            ]);
        }

        return $this->response->setJSON([
            'success'         => true,
            'puntos_generados' => $resultado['puntos'],
            'compra_id'       => $resultado['compra_id'],
            'campania'        => $resultado['campania'] ?? null
        ]);
    }


    public function ticket($compraId)
    {
        $db = db_connect();

        $data = $db->table('compras c')
        ->select('
            c.*,
            cl.nombres,
            cl.apellidos,
            cl.numero_documento,
            cl.puntos_acumulados,
            camp.nombre as campania_nombre,
            camp.monto_base,
            camp.puntos_por_monto,
            camp.puntos_dobles_finsemana,
            camp.multiplicador_monto_minimo,
            camp.multiplicador_valor
        ')
        ->join('clientes cl', 'cl.id = c.cliente_id')
        ->join('campanias camp', 'camp.id = c.campania_id', 'left')
        ->where('c.id', $compraId)
        ->get()
        ->getRowArray();

        if (!$data) {
            return redirect()->to('/compras')->with('error', 'Compra no encontrada');
        }

        // Calcular desglose de puntos para mostrar al cliente
        $desglosePuntos = $this->calcularDesglosePuntos($data);
        $data['desglose'] = $desglosePuntos;

        return view('compras/ticket', $data);
    }

    /**
     * Calcula el desglose de cómo se obtuvieron los puntos
     */
    private function calcularDesglosePuntos($compra)
    {
        $desglose = [
            'regla_base' => '',
            'puntos_base' => 0,
            'potenciadores' => [],
            'puntos_finales' => (int)$compra['puntos_generados']
        ];

        if (empty($compra['monto_base']) || empty($compra['puntos_por_monto'])) {
            return $desglose;
        }

        $montoBase = (float)$compra['monto_base'];
        $puntosPorMonto = (int)$compra['puntos_por_monto'];
        $montoCompra = (float)$compra['monto_compra'];

        // Regla base
        $desglose['regla_base'] = "Por cada S/ " . number_format($montoBase, 2) . " ganas {$puntosPorMonto} punto(s)";

        // Puntos base (sin multiplicadores)
        $puntosBase = floor($montoCompra / $montoBase) * $puntosPorMonto;
        $desglose['puntos_base'] = $puntosBase;

        $puntosActuales = $puntosBase;

        // Verificar si se aplicó puntos dobles por fin de semana
        if ($compra['puntos_dobles_finsemana']) {
            $fechaCompra = strtotime($compra['created_at']);
            $diaSemana = date('N', $fechaCompra); // 1=Lunes, 7=Domingo
            if ($diaSemana >= 6) {
                $desglose['potenciadores'][] = [
                    'nombre' => 'Puntos x2 por fin de semana',
                    'descripcion' => 'Sábado o Domingo',
                    'multiplicador' => 2,
                    'puntos_antes' => $puntosActuales,
                    'puntos_despues' => $puntosActuales * 2
                ];
                $puntosActuales *= 2;
            }
        }

        // Verificar si se aplicó multiplicador por monto mínimo
        if ($compra['multiplicador_monto_minimo'] && $compra['multiplicador_valor']) {
            $montoMinimo = (float)$compra['multiplicador_monto_minimo'];
            $multiplicador = (int)$compra['multiplicador_valor'];
            if ($montoCompra >= $montoMinimo) {
                $desglose['potenciadores'][] = [
                    'nombre' => "Puntos x{$multiplicador} por compra mayor a S/ " . number_format($montoMinimo, 2),
                    'descripcion' => "Compra de S/ " . number_format($montoCompra, 2),
                    'multiplicador' => $multiplicador,
                    'puntos_antes' => $puntosActuales,
                    'puntos_despues' => $puntosActuales * $multiplicador
                ];
                $puntosActuales *= $multiplicador;
            }
        }

        return $desglose;
    }

    /**
     * Genera un ticket solo con los puntos actuales del cliente (sin compra)
     */
    public function ticketCliente($clienteId)
    {
        $db = db_connect();

        $data = $db->table('clientes')
            ->select('nombres, apellidos, numero_documento, puntos_acumulados')
            ->where('id', $clienteId)
            ->get()->getRowArray();

        if (!$data) {
            return 'Cliente no encontrado';
        }

        // Agregar fecha actual
        $data['fecha_consulta'] = date('Y-m-d H:i:s');
        
        return view('compras/ticket_cliente', $data);
    }

}
