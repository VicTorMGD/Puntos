<?php

namespace App\Controllers;

use App\Services\PuntosService;

class ComprasController extends BaseController
{
    public function index()
    {
        return view('compras/index');
    }

    public function registrar()
    {
        $clienteId = (int) $this->request->getPost('cliente_id');
        $monto     = (float) $this->request->getPost('monto');

        if ($clienteId <= 0 || $monto <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Datos inválidos'
            ]);
        }

        try {
            $service = new PuntosService();

            $resultado = $service->registrarCompra(
                $clienteId,
                session()->get('user_id'),
                $monto,
                'PEN' // moneda por ahora
            );

            return $this->response->setJSON([
                'success' => true,
                'puntos_generados' => $resultado['puntos'],
                'compra_id' => $resultado['compra_id']
            ]);

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }


    public function ticket($compraId)
    {
        $db = db_connect();

        $data = $db->table('compras c')
            ->select('c.*, cl.nombres, cl.apellidos, cl.numero_documento, cl.puntos_acumulados')
            ->join('clientes cl', 'cl.id = c.cliente_id')
            ->where('c.id', $compraId)
            ->get()->getRowArray();

        return view('compras/ticket', $data);
    }

}
