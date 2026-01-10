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
            cl.puntos_acumulados
        ')
        ->join('clientes cl', 'cl.id = c.cliente_id')
        ->where('c.id', $compraId)
        ->get()
        ->getRowArray();

        return view('compras/ticket', $data);
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
