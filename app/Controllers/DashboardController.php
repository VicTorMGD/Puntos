<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Obtener fecha de hoy para filtros
        $hoy = date('Y-m-d');
        $inicioHoy = $hoy . ' 00:00:00';
        $finHoy = $hoy . ' 23:59:59';

        $data = [
            'totalClientes' => $db->table('clientes')->where('estado', 1)->countAllResults(),
            // Suma los puntos acumulados reales de los clientes activos
            'puntosTotales' => (int) $db->table('clientes')
                                    ->selectSum('puntos_acumulados')
                                    ->where('estado', 1)
                                    ->get()->getRow()->puntos_acumulados ?? 0,
            // Suma solo los puntos positivos generados hoy
            'puntosHoy'     => (int) $db->table('puntos')
                                    ->selectSum('puntos')
                                    ->where('puntos >', 0)
                                    ->where('created_at >=', $inicioHoy)
                                    ->where('created_at <=', $finHoy)
                                    ->get()->getRow()->puntos ?? 0,
            // Cuenta solo las compras realizadas hoy
            'totalComprasHoy' => $db->table('compras')
                                    ->where('created_at >=', $inicioHoy)
                                    ->where('created_at <=', $finHoy)
                                    ->countAllResults(),
        ];

        return view('dashboard/index', $data);
    }

    public function puntosPorDia()
    {
        $db = db_connect();

        $result = $db->table('puntos')
            ->select("DATE(created_at) as fecha, SUM(puntos) as total")
            ->groupBy('DATE(created_at)')
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($result);
    }

    public function comprasPorDia()
    {
        $db = \Config\Database::connect();

        $data = $db->table('compras')
            ->select('DATE(created_at) as fecha, COUNT(*) as total')
            ->groupBy('DATE(created_at)')
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

}
