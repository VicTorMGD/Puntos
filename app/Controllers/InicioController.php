<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\CampaniaModel;

class InicioController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $campaniaModel = new CampaniaModel();

        // Obtener estadísticas rápidas para mostrar en los accesos directos
        $data = [
            'title' => 'Inicio',
            'userName' => session()->get('user_name') ?? session()->get('username') ?? 'Usuario',
            'userRole' => session()->get('role') ?? 'usuario',
            'totalClientes' => $db->table('clientes')->where('estado', 1)->countAllResults(),
            'campaniaActiva' => $campaniaModel->getActiva(),
            'comprasHoy' => $db->table('compras')
                ->where('DATE(created_at)', date('Y-m-d'))
                ->countAllResults(),
            'canjesHoy' => $db->table('canjes')
                ->where('DATE(created_at)', date('Y-m-d'))
                ->countAllResults()
        ];

        return view('inicio/index', $data);
    }
}
