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
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = db_connect();
        $builder = $db->table('puntos')
            ->select("DATE(created_at) as fecha, SUM(puntos) as total")
            ->where('puntos >', 0);

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy('DATE(created_at)')
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        // Formatear fechas a DD/MM/YYYY
        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'dia');
        }

        return $this->response->setJSON($data);
    }

    public function puntosPorMes()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = db_connect();
        $builder = $db->table('puntos')
            ->select("DATE_FORMAT(created_at, '%Y-%m') as fecha, SUM(puntos) as total")
            ->where('puntos >', 0);

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        // Formatear fechas a MM/YYYY
        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'mes');
        }

        return $this->response->setJSON($data);
    }

    public function comprasPorDia()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('compras')
            ->select('DATE(created_at) as fecha, COUNT(*) as total');

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy('DATE(created_at)')
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        // Formatear fechas a DD/MM/YYYY
        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'dia');
        }

        return $this->response->setJSON($data);
    }

    public function comprasPorMes()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('compras')
            ->select("DATE_FORMAT(created_at, '%Y-%m') as fecha, COUNT(*) as total");

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        // Formatear fechas a MM/YYYY
        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'mes');
        }

        return $this->response->setJSON($data);
    }


    public function topClientes()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('clientes c')
            ->select("c.id, CONCAT(c.nombres,' ',c.apellidos) as cliente, COALESCE(SUM(p.puntos),0) as total")
            ->join('puntos p', 'p.cliente_id = c.id', 'left');

        if ($inicio && $fin) {
            $builder->where('p.created_at >=', $inicio)
                    ->where('p.created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy('c.id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }



}
