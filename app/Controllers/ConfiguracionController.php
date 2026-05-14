<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;

class ConfiguracionController extends BaseController
{
    protected $configuracionModel;

    public function __construct()
    {
        $this->configuracionModel = new ConfiguracionModel();
    }

    public function index()
    {
        $tickets = $this->configuracionModel->getModulo('tickets');

        $data = [
            'observacion_texto'       => $tickets['observacion_texto'] ?? '',
            'observacion_en_compra'   => $tickets['observacion_en_compra'] ?? '0',
            'observacion_en_canje'    => $tickets['observacion_en_canje'] ?? '0',
            'observacion_en_consulta' => $tickets['observacion_en_consulta'] ?? '0',
        ];

        return view('configuracion/index', $data);
    }

    public function guardar()
    {
        $modelo = $this->configuracionModel;

        $texto   = $this->request->getPost('observacion_texto') ?? '';
        $compra  = $this->request->getPost('observacion_en_compra')   ? '1' : '0';
        $canje   = $this->request->getPost('observacion_en_canje')    ? '1' : '0';
        $consulta = $this->request->getPost('observacion_en_consulta') ? '1' : '0';

        $modelo->setValor('tickets', 'observacion_texto',       $texto);
        $modelo->setValor('tickets', 'observacion_en_compra',   $compra);
        $modelo->setValor('tickets', 'observacion_en_canje',    $canje);
        $modelo->setValor('tickets', 'observacion_en_consulta', $consulta);

        return redirect()->to('configuracion')->with('success', 'Configuración guardada correctamente');
    }
}