<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\PuntosModel;

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

    // app/Models/ClienteModel.php
    public function show($id)
    {
        $clienteModel = new ClienteModel();

        $cliente = $clienteModel->find($id);
        $puntos  = $clienteModel->getPuntosAcumulados($id);

        return view('clientes/show', [
            'cliente' => $cliente,
            'puntos_acumulados' => $puntos
        ]);
    }

    // public function puntos($id)
    // {
    //     $clienteModel = new ClienteModel();
    //     $puntosModel  = new PuntosModel();
    
    //     $cliente = $clienteModel->find($id);
    
    //     if (!$cliente) {
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente no encontrado');
    //     }
    
    //     $movimientos = $puntosModel->getByCliente($id);
    
    //     return view('clientes/puntos', [
    //         'cliente'     => $cliente,
    //         'movimientos' => $movimientos
    //     ]);
    // }

    public function puntos($id)
    {
        $clienteModel = new ClienteModel();
        $puntosModel  = new PuntosModel();

        $cliente = $clienteModel->find($id);

        if (!$cliente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente no encontrado');
        }

        // Obtener movimientos de puntos del cliente
        $movimientos = $puntosModel
            ->where('cliente_id', $id)
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('clientes/puntos', [
            'cliente'     => $cliente,
            'movimientos' => $movimientos
        ]);
    }
}
