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

        $db = db_connect();
        $db->transStart();

        // 1. Registrar compra
        $puntosService = new PuntosService();
        $puntos = $puntosService->calcularPuntos($monto);

        $db->table('compras')->insert([
            'cliente_id'       => $clienteId,
            'usuario_id'       => session()->get('user_id'),
            'monto_compra'     => $monto,
            'puntos_generados' => $puntos
        ]);

        $compraId = $db->insertID();

        // 2. Registrar movimiento de puntos
        $puntosService->registrarMovimiento(
            $clienteId,
            $monto,
            $compraId
        );

        $db->transComplete();

        return $this->response->setJSON([
            'success'        => true,
            'puntos_generados'=> $puntos,
            'compra_id'      => $compraId
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
