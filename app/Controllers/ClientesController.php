<?php

namespace App\Controllers;

use App\Models\ClienteModel;

class ClientesController extends BaseController
{
    public function index()
    {
        return view('clientes/index');
    }
    
    public function buscarPorDocumento()
    {
        $dni = trim($this->request->getPost('dni'));

        if ($dni === '') {
            return $this->response->setJSON(['success' => false]);
        }

        $cliente = (new ClienteModel())
            ->where('numero_documento', $dni)
            ->where('estado', 1)
            ->first();

        if ($cliente) {
            return $this->response->setJSON([
                'success' => true,
                'cliente' => $cliente
            ]);
        }

        return $this->response->setJSON(['success' => false]);
    }

    public function guardar()
    {
        $data = $this->request->getPost();

        $model = new \App\Models\ClienteModel();

        if ($model->where('numero_documento', $data['numero_documento'])->first()) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Cliente ya existe'
            ]);
        }

        $id = $model->insert([
            'tipo_documento'   => 'DNI',
            'numero_documento' => $data['numero_documento'],
            'nombres'          => $data['nombres'],
            'apellidos'        => $data['apellidos'],
            'telefono'         => $data['telefono'],
            'email'            => $data['email']
        ]);

        return $this->response->setJSON([
            'success' => true,
            'cliente_id' => $id
        ]);
    }

}
