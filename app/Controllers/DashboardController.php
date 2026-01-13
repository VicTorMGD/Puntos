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

    /**
     * Distribución de tipos de movimientos de puntos (para gráfico de pastel)
     */
    public function distribucionTiposPuntos()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('puntos')
            ->select("tipo, COUNT(*) as cantidad, SUM(ABS(puntos)) as total_puntos");

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy('tipo')
            ->get()
            ->getResultArray();

        // Mapear nombres amigables para los tipos
        $tiposNombres = [
            'GANADO' => 'Puntos Ganados',
            'CANJEADO' => 'Canjes',
            'USADO' => 'Canjes',
            'AJUSTE' => 'Ajustes',
            'AJUSTE_POSITIVO' => 'Ajustes (+)',
            'AJUSTE_NEGATIVO' => 'Ajustes (-)',
            'ELIMINADO' => 'Eliminados',
            'MIGRACION' => 'Migraciones'
        ];

        foreach ($data as &$row) {
            $row['nombre'] = $tiposNombres[$row['tipo']] ?? $row['tipo'];
        }

        return $this->response->setJSON($data);
    }

    /**
     * Canjes realizados por día/mes
     */
    public function canjesPorDia()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('canjes')
            ->select('DATE(created_at) as fecha, COUNT(*) as cantidad, SUM(puntos_canjeados) as total_puntos');

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy('DATE(created_at)')
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'dia');
        }

        return $this->response->setJSON($data);
    }

    public function canjesPorMes()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('canjes')
            ->select("DATE_FORMAT(created_at, '%Y-%m') as fecha, COUNT(*) as cantidad, SUM(puntos_canjeados) as total_puntos");

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'mes');
        }

        return $this->response->setJSON($data);
    }

    /**
     * Comparativa Puntos Ganados vs Canjeados (para gráfico de dona)
     */
    public function comparativaPuntosGanadosVsCanjeados()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();

        // Puntos ganados (positivos de tipo GANADO)
        $builderGanados = $db->table('puntos')
            ->selectSum('puntos', 'total')
            ->where('puntos >', 0)
            ->whereIn('tipo', ['GANADO']);

        if ($inicio && $fin) {
            $builderGanados->where('created_at >=', $inicio)
                          ->where('created_at <=', $fin . ' 23:59:59');
        }

        $ganados = (int) ($builderGanados->get()->getRow()->total ?? 0);

        // Puntos canjeados (valores absolutos de canjes)
        $builderCanjeados = $db->table('canjes')
            ->selectSum('puntos_canjeados', 'total');

        if ($inicio && $fin) {
            $builderCanjeados->where('created_at >=', $inicio)
                            ->where('created_at <=', $fin . ' 23:59:59');
        }

        $canjeados = (int) ($builderCanjeados->get()->getRow()->total ?? 0);

        return $this->response->setJSON([
            ['nombre' => 'Puntos Ganados', 'valor' => $ganados],
            ['nombre' => 'Puntos Canjeados', 'valor' => $canjeados],
            ['nombre' => 'Disponibles', 'valor' => max(0, $ganados - $canjeados)]
        ]);
    }

    /**
     * Estadísticas de campañas
     */
    public function estadisticasCampanias()
    {
        $db = \Config\Database::connect();

        // Total de campañas por estado
        $campanias = $db->table('campanias')
            ->select("estado, COUNT(*) as cantidad")
            ->groupBy('estado')
            ->get()
            ->getResultArray();

        // Puntos por campaña (top 5)
        $puntosPorCampania = $db->table('puntos_campania pc')
            ->select("c.nombre, SUM(pc.puntos_disponibles) as disponibles, SUM(pc.puntos_canjeados) as canjeados")
            ->join('campanias c', 'c.id = pc.campania_id')
            ->groupBy('pc.campania_id')
            ->orderBy('disponibles', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'por_estado' => $campanias,
            'puntos_por_campania' => $puntosPorCampania
        ]);
    }

    /**
     * Montos de compras por día/mes
     */
    public function montoComprasPorDia()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('compras')
            ->select('DATE(created_at) as fecha, SUM(monto) as total_monto, COUNT(*) as cantidad');

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy('DATE(created_at)')
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'dia');
        }

        return $this->response->setJSON($data);
    }

    public function montoComprasPorMes()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();
        $builder = $db->table('compras')
            ->select("DATE_FORMAT(created_at, '%Y-%m') as fecha, SUM(monto) as total_monto, COUNT(*) as cantidad");

        if ($inicio && $fin) {
            $builder->where('created_at >=', $inicio)
                    ->where('created_at <=', $fin . ' 23:59:59');
        }

        $data = $builder
            ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderBy('fecha', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($data as &$row) {
            $row['fecha'] = formatear_fecha($row['fecha'], 'mes');
        }

        return $this->response->setJSON($data);
    }

    /**
     * Actividad por hora del día (para gráfico radar/polar)
     */
    public function actividadPorHora()
    {
        $inicio = $this->request->getGet('inicio');
        $fin    = $this->request->getGet('fin');

        $db = \Config\Database::connect();

        // Compras por hora
        $builderCompras = $db->table('compras')
            ->select("HOUR(created_at) as hora, COUNT(*) as cantidad");

        if ($inicio && $fin) {
            $builderCompras->where('created_at >=', $inicio)
                          ->where('created_at <=', $fin . ' 23:59:59');
        }

        $compras = $builderCompras
            ->groupBy('HOUR(created_at)')
            ->get()
            ->getResultArray();

        // Canjes por hora
        $builderCanjes = $db->table('canjes')
            ->select("HOUR(created_at) as hora, COUNT(*) as cantidad");

        if ($inicio && $fin) {
            $builderCanjes->where('created_at >=', $inicio)
                         ->where('created_at <=', $fin . ' 23:59:59');
        }

        $canjes = $builderCanjes
            ->groupBy('HOUR(created_at)')
            ->get()
            ->getResultArray();

        // Crear array de 24 horas inicializado en 0
        $horasCompras = array_fill(0, 24, 0);
        $horasCanjes = array_fill(0, 24, 0);

        foreach ($compras as $row) {
            $horasCompras[(int)$row['hora']] = (int)$row['cantidad'];
        }

        foreach ($canjes as $row) {
            $horasCanjes[(int)$row['hora']] = (int)$row['cantidad'];
        }

        return $this->response->setJSON([
            'compras' => $horasCompras,
            'canjes' => $horasCanjes
        ]);
    }

    /**
     * Resumen de KPIs para tarjetas adicionales
     */
    public function kpisResumen()
    {
        $db = \Config\Database::connect();

        // Total canjes
        $totalCanjes = $db->table('canjes')->countAllResults();

        // Puntos canjeados total
        $puntosCanjeados = (int) ($db->table('canjes')
            ->selectSum('puntos_canjeados')
            ->get()->getRow()->puntos_canjeados ?? 0);

        // Monto total de compras
        $montoTotal = (float) ($db->table('compras')
            ->selectSum('monto')
            ->get()->getRow()->monto ?? 0);

        // Promedio de puntos por cliente
        $promedioCliente = (float) ($db->table('clientes')
            ->selectAvg('puntos_acumulados')
            ->where('estado', 1)
            ->get()->getRow()->puntos_acumulados ?? 0);

        // Canjes hoy
        $hoy = date('Y-m-d');
        $canjesHoy = $db->table('canjes')
            ->where('DATE(created_at)', $hoy)
            ->countAllResults();

        return $this->response->setJSON([
            'total_canjes' => $totalCanjes,
            'puntos_canjeados' => $puntosCanjeados,
            'monto_total_compras' => $montoTotal,
            'promedio_puntos_cliente' => round($promedioCliente, 0),
            'canjes_hoy' => $canjesHoy
        ]);
    }
}
