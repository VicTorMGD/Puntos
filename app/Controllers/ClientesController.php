<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\PuntosModel;
use App\Models\PuntosCampaniaModel;
use App\Models\CanjeModel;
use App\Models\AjustePuntosModel;

class ClientesController extends BaseController
{
    public function index()
    {
        $clienteModel = new ClienteModel();

        $clientes = $clienteModel->getClientesConPuntos();

        // Obtener top 5 clientes con más puntos para el gráfico
        $top5Clientes = $clienteModel->select('id, nombres, apellidos, puntos_acumulados as total')
            ->where('estado', 1)
            ->orderBy('puntos_acumulados', 'DESC')
            ->limit(5)
            ->findAll();

        return view('clientes/index', [
            'clientes' => $clientes,
            'top5Clientes' => $top5Clientes
        ]);
    }
    public function edit($id)
    {
        $cliente = (new ClienteModel())
            ->where('id', $id)
            ->where('estado', 1)
            ->first();

        if (!$cliente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente no encontrado');
        }

        return view('clientes/edit', compact('cliente'));
    }

    public function update($id)
    {
        $model = new ClienteModel();

        // Verificar que el cliente existe y está activo
        $cliente = $model
            ->where('id', $id)
            ->where('estado', 1)
            ->first();

        if (!$cliente) {
            return redirect()->to('clientes')
                ->with('error', 'Cliente no encontrado');
        }

        // Validaciones completas
        $validationRules = [
            'numero_documento' => [
                'rules' => 'required|numeric|exact_length[8]',
                'errors' => [
                    'required' => 'El número de documento es obligatorio',
                    'numeric' => 'El número de documento debe ser numérico',
                    'exact_length' => 'El DNI debe tener 8 dígitos'
                ]
            ],
            'nombres' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'El nombre es obligatorio',
                    'min_length' => 'El nombre debe tener al menos 2 caracteres',
                    'max_length' => 'El nombre no puede exceder 100 caracteres'
                ]
            ],
            'apellidos' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'Los apellidos son obligatorios',
                    'min_length' => 'Los apellidos deben tener al menos 2 caracteres',
                    'max_length' => 'Los apellidos no pueden exceder 100 caracteres'
                ]
            ],
            'telefono' => [
                'rules' => 'permit_empty|numeric|min_length[7]|max_length[9]',
                'errors' => [
                    'numeric' => 'El teléfono debe ser numérico',
                    'min_length' => 'El teléfono debe tener al menos 7 dígitos',
                    'max_length' => 'El teléfono no puede exceder 9 dígitos'
                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email|max_length[100]',
                'errors' => [
                    'valid_email' => 'El email no es válido',
                    'max_length' => 'El email no puede exceder 100 caracteres'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error de validación')
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        // Verificar si el DNI ya existe en otro cliente activo
        $dniExistente = $model
            ->where('numero_documento', $data['numero_documento'])
            ->where('id !=', $id)
            ->where('estado', 1)
            ->first();

        if ($dniExistente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El número de documento ya está registrado en otro cliente');
        }

        try {
            $model->update($id, [
                'tipo_documento'   => 'DNI',
                'numero_documento' => trim($data['numero_documento']),
                'nombres'          => trim($data['nombres']),
                'apellidos'        => trim($data['apellidos']),
                'telefono'         => isset($data['telefono']) ? trim($data['telefono']) : null,
                'email'            => isset($data['email']) ? trim($data['email']) : null
            ]);

            return redirect()->to('clientes')
                ->with('success', 'Cliente actualizado exitosamente');

        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar cliente: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el cliente. Intente nuevamente.');
        }
    }


    public function delete($id)
    {
        $model = new ClienteModel();

        // Verificar que el cliente existe
        $cliente = $model->find($id);

        if (!$cliente) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Cliente no encontrado'
            ]);
        }

        try {
            // Soft delete: cambiar estado a 0
            $resultado = $model->update($id, ['estado' => 0]);

            if ($resultado) {
                log_message('info', "Cliente ID {$id} eliminado (soft delete)");
                return $this->response->setJSON([
                    'success' => true,
                    'msg' => 'Cliente eliminado exitosamente'
                ]);
            } else {
                log_message('error', "Error al eliminar cliente ID {$id}");
                return $this->response->setJSON([
                    'success' => false,
                    'msg' => 'Error al eliminar el cliente'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar cliente: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Error al eliminar el cliente'
            ]);
        }
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

        // Validación de datos
        $validationRules = [
            'numero_documento' => [
                'rules' => 'required|numeric|exact_length[8]',
                'errors' => [
                    'required' => 'El número de documento es obligatorio',
                    'numeric' => 'El número de documento debe ser numérico',
                    'exact_length' => 'El DNI debe tener 8 dígitos'
                ]
            ],
            'nombres' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'El nombre es obligatorio',
                    'min_length' => 'El nombre debe tener al menos 2 caracteres',
                    'max_length' => 'El nombre no puede exceder 100 caracteres'
                ]
            ],
            'apellidos' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'Los apellidos son obligatorios',
                    'min_length' => 'Los apellidos deben tener al menos 2 caracteres',
                    'max_length' => 'Los apellidos no pueden exceder 100 caracteres'
                ]
            ],
            'telefono' => [
                'rules' => 'permit_empty|numeric|min_length[7]|max_length[9]',
                'errors' => [
                    'numeric' => 'El teléfono debe ser numérico',
                    'min_length' => 'El teléfono debe tener al menos 7 dígitos',
                    'max_length' => 'El teléfono no puede exceder 9 dígitos'
                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email|max_length[100]',
                'errors' => [
                    'valid_email' => 'El email no es válido',
                    'max_length' => 'El email no puede exceder 100 caracteres'
                ]
            ]
        ];
        
        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Error de validación',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $model = new \App\Models\ClienteModel();

        // Verificar si el cliente ya existe (activo o eliminado)
        $clienteExistente = $model->where('numero_documento', $data['numero_documento'])->first();

        try {
            // Si existe y está activo (estado = 1), no permitir duplicado
            if ($clienteExistente && $clienteExistente['estado'] == 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'msg' => 'Ya existe un cliente activo con este número de documento'
                ]);
            }

            // Si existe pero está eliminado (estado = 0), reactivarlo con nuevos datos
            if ($clienteExistente && $clienteExistente['estado'] == 0) {
                $model->update($clienteExistente['id'], [
                    'tipo_documento'   => 'DNI',
                    'numero_documento' => trim($data['numero_documento']),
                    'nombres'          => trim($data['nombres']),
                    'apellidos'        => trim($data['apellidos']),
                    'telefono'         => isset($data['telefono']) ? trim($data['telefono']) : null,
                    'email'            => isset($data['email']) ? trim($data['email']) : null,
                    'estado'           => 1,
                    'puntos_acumulados' => 0
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'cliente_id' => $clienteExistente['id'],
                    'msg' => 'Cliente reactivado exitosamente'
                ]);
            }

            // Si no existe, crear nuevo cliente
            $id = $model->insert([
                'tipo_documento'   => 'DNI',
                'numero_documento' => trim($data['numero_documento']),
                'nombres'          => trim($data['nombres']),
                'apellidos'        => trim($data['apellidos']),
                'telefono'         => isset($data['telefono']) ? trim($data['telefono']) : null,
                'email'            => isset($data['email']) ? trim($data['email']) : null,
                'estado'           => 1,
                'puntos_acumulados' => 0
            ]);

            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'msg' => 'Error al registrar el cliente'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'cliente_id' => $id,
                'msg' => 'Cliente registrado exitosamente'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error al guardar cliente: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Error al guardar el cliente. Intente nuevamente.'
            ]);
        }
    }

    // MOstrar el detalle del cliente
    public function show($id)
    {
        $clienteModel = new ClienteModel();

        $cliente = $clienteModel
            ->where('id', $id)
            ->where('estado', 1)
            ->first();

        if (!$cliente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente no encontrado');
        }

        $puntos = $clienteModel->getPuntosAcumulados($id);

        return view('clientes/show', [
            'cliente' => $cliente,
            'puntos_acumulados' => $puntos
        ]);
    }

   

    public function puntos($id)
    {
        $clienteModel = new ClienteModel();
        $puntosModel  = new PuntosModel();
        $puntosCampaniaModel = new PuntosCampaniaModel();
        $canjeModel = new CanjeModel();
        $ajusteModel = new AjustePuntosModel();

        $cliente = $clienteModel
            ->where('id', $id)
            ->where('estado', 1)
            ->first();

        if (!$cliente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente no encontrado');
        }

        // Obtener puntos por campaña
        $puntosPorCampania = $puntosCampaniaModel->getPuntosClienteConCampanias($id);

        // Obtener movimientos de puntos del cliente (historial original)
        $movimientos = $puntosModel
            ->where('cliente_id', $id)
            ->orderBy('id', 'DESC')
            ->findAll();

        // Obtener canjes del cliente
        $canjes = $canjeModel
            ->select('canjes.*, campanias.nombre as campania_nombre, users.name as usuario_nombre')
            ->join('campanias', 'campanias.id = canjes.campania_id')
            ->join('users', 'users.id = canjes.usuario_id')
            ->where('canjes.cliente_id', $id)
            ->orderBy('canjes.id', 'DESC')
            ->findAll();

        // Obtener ajustes del cliente
        $ajustes = $ajusteModel
            ->select('ajustes_puntos.*, campanias.nombre as campania_nombre, users.name as usuario_nombre')
            ->join('campanias', 'campanias.id = ajustes_puntos.campania_id')
            ->join('users', 'users.id = ajustes_puntos.usuario_id')
            ->where('ajustes_puntos.cliente_id', $id)
            ->orderBy('ajustes_puntos.id', 'DESC')
            ->findAll();

        return view('clientes/puntos', [
            'cliente'            => $cliente,
            'movimientos'        => $movimientos,
            'puntosPorCampania'  => $puntosPorCampania,
            'canjes'             => $canjes,
            'ajustes'            => $ajustes
        ]);
    }
}
