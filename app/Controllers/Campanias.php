<?php

namespace App\Controllers;

use App\Models\CampaniaModel;
use App\Models\PuntosCampaniaModel;
use App\Models\AjustePuntosModel;
use App\Services\AuditoriaService;

class Campanias extends BaseController
{
    protected $campaniaModel;
    protected $puntosCampaniaModel;
    protected $auditoriaService;

    public function __construct()
    {
        $this->campaniaModel = new CampaniaModel();
        $this->puntosCampaniaModel = new PuntosCampaniaModel();
        $this->auditoriaService = new AuditoriaService();
    }

    /**
     * Verifica que el usuario sea administrador
     */
    private function checkAdmin()
    {
        if (session()->get('role') !== 'administrador') {
            return redirect()->to('/dashboard')->with('error', 'Acceso no autorizado. Solo administradores pueden gestionar campañas.');
        }
        return null;
    }

    /**
     * Lista todas las campañas
     */
    public function index()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $data = [
            'title' => 'Gestión de Campañas',
            'campanias' => $this->campaniaModel->getAllWithCreator(),
            'campaniaActiva' => $this->campaniaModel->getActiva()
        ];

        return view('campanias/index', $data);
    }

    /**
     * Formulario para crear nueva campaña
     */
    public function create()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        // Verificar si hay una campaña activa
        $campaniaActiva = $this->campaniaModel->getActiva();

        $data = [
            'title' => 'Nueva Campaña',
            'campaniaActiva' => $campaniaActiva
        ];

        return view('campanias/create', $data);
    }

    /**
     * Guarda una nueva campaña
     */
    public function store()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'monto_base' => 'required|decimal|greater_than[0]',
            'puntos_por_monto' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Si hay campaña activa, cerrarla primero
        $campaniaActiva = $this->campaniaModel->getActiva();
        if ($campaniaActiva) {
            $this->campaniaModel->cerrarCampania($campaniaActiva['id'], session()->get('user_id'));

            // Registrar en auditoría
            $this->auditoriaService->registrar(
                'campanias',
                'cerrar',
                'campanias',
                $campaniaActiva['id'],
                $campaniaActiva,
                ['estado' => 'cerrada']
            );
        }

        // Crear nueva campaña
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'monto_base' => $this->request->getPost('monto_base'),
            'puntos_por_monto' => $this->request->getPost('puntos_por_monto'),
            'puntos_dobles_finsemana' => $this->request->getPost('puntos_dobles_finsemana') ? 1 : 0,
            'multiplicador_monto_minimo' => $this->request->getPost('multiplicador_monto_minimo') ?: null,
            'multiplicador_valor' => $this->request->getPost('multiplicador_valor') ?: null,
            'estado' => 'activa',
            'creado_por' => session()->get('user_id')
        ];

        $this->campaniaModel->insert($data);
        $nuevaCampaniaId = $this->campaniaModel->getInsertID();

        // Registrar en auditoría
        $this->auditoriaService->registrarCreacion('campanias', 'campanias', $nuevaCampaniaId, $data);

        return redirect()->to('/campanias')->with('success', 'Campaña creada exitosamente.');
    }

    /**
     * Formulario para editar una campaña
     */
    public function edit($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $campania = $this->campaniaModel->find($id);

        if (!$campania) {
            return redirect()->to('/campanias')->with('error', 'Campaña no encontrada.');
        }

        // Solo se puede editar la campaña activa
        if ($campania['estado'] !== 'activa') {
            return redirect()->to('/campanias')->with('error', 'Solo se puede editar la campaña activa.');
        }

        $data = [
            'title' => 'Editar Campaña',
            'campania' => $campania
        ];

        return view('campanias/edit', $data);
    }

    /**
     * Actualiza una campaña
     */
    public function update($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $campania = $this->campaniaModel->find($id);

        if (!$campania) {
            return redirect()->to('/campanias')->with('error', 'Campaña no encontrada.');
        }

        if ($campania['estado'] !== 'activa') {
            return redirect()->to('/campanias')->with('error', 'Solo se puede editar la campaña activa.');
        }

        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'monto_base' => 'required|decimal|greater_than[0]',
            'puntos_por_monto' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $datosNuevos = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'monto_base' => $this->request->getPost('monto_base'),
            'puntos_por_monto' => $this->request->getPost('puntos_por_monto'),
            'puntos_dobles_finsemana' => $this->request->getPost('puntos_dobles_finsemana') ? 1 : 0,
            'multiplicador_monto_minimo' => $this->request->getPost('multiplicador_monto_minimo') ?: null,
            'multiplicador_valor' => $this->request->getPost('multiplicador_valor') ?: null
        ];

        $this->campaniaModel->update($id, $datosNuevos);

        // Registrar en auditoría
        $this->auditoriaService->registrarEdicion('campanias', 'campanias', $id, $campania, $datosNuevos);

        return redirect()->to('/campanias')->with('success', 'Campaña actualizada exitosamente.');
    }

    /**
     * Cierra una campaña y permite decidir qué hacer con los puntos
     */
    public function cerrar($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $campania = $this->campaniaModel->find($id);

        if (!$campania) {
            return redirect()->to('/campanias')->with('error', 'Campaña no encontrada.');
        }

        if ($campania['estado'] !== 'activa') {
            return redirect()->to('/campanias')->with('error', 'Esta campaña ya está cerrada.');
        }

        // Cerrar la campaña
        $this->campaniaModel->cerrarCampania($id, session()->get('user_id'));

        // Registrar en auditoría
        $this->auditoriaService->registrar(
            'campanias',
            'cerrar',
            'campanias',
            $id,
            $campania,
            ['estado' => 'cerrada']
        );

        return redirect()->to('/campanias')->with('success', 'Campaña cerrada exitosamente. Crea una nueva campaña para continuar.');
    }

    /**
     * Vista para gestionar migración de puntos al cerrar campaña
     */
    public function gestionarPuntos($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $campania = $this->campaniaModel->find($id);

        if (!$campania) {
            return redirect()->to('/campanias')->with('error', 'Campaña no encontrada.');
        }

        // Obtener clientes con puntos en esta campaña
        $clientesConPuntos = $this->puntosCampaniaModel
            ->select('puntos_campania.*, clientes.nombres, clientes.apellidos, clientes.numero_documento')
            ->join('clientes', 'clientes.id = puntos_campania.cliente_id')
            ->where('puntos_campania.campania_id', $id)
            ->where('puntos_campania.puntos_disponibles >', 0)
            ->findAll();

        // Obtener campaña activa (si existe)
        $campaniaActiva = $this->campaniaModel->getActiva();

        $data = [
            'title' => 'Gestionar Puntos - ' . $campania['nombre'],
            'campania' => $campania,
            'clientesConPuntos' => $clientesConPuntos,
            'campaniaActiva' => $campaniaActiva
        ];

        return view('campanias/gestionar_puntos', $data);
    }

    /**
     * Migra los puntos de un cliente de una campaña cerrada a la activa
     */
    public function migrarPuntosCliente()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $clienteId = $this->request->getPost('cliente_id');
        $campaniaOrigenId = $this->request->getPost('campania_origen_id');
        $accion = $this->request->getPost('accion'); // 'migrar' o 'eliminar'

        $campaniaActiva = $this->campaniaModel->getActiva();
        $puntosCliente = $this->puntosCampaniaModel->getPuntosCliente($clienteId, $campaniaOrigenId);

        if (!$puntosCliente) {
            return $this->response->setJSON(['success' => false, 'message' => 'No se encontraron puntos para este cliente.']);
        }

        $puntosAntes = $puntosCliente['puntos_disponibles'];
        $ajustePuntosModel = new AjustePuntosModel();

        if ($accion === 'migrar' && $campaniaActiva) {
            // Migrar puntos a la campaña activa
            $this->puntosCampaniaModel->migrarPuntos($clienteId, $campaniaOrigenId, $campaniaActiva['id'], $puntosAntes);

            // Registrar ajuste
            $ajustePuntosModel->registrarAjuste(
                $clienteId,
                $campaniaOrigenId,
                $puntosAntes,
                0,
                'migracion',
                "Puntos migrados a campaña: {$campaniaActiva['nombre']}",
                session()->get('user_id')
            );

            $this->auditoriaService->registrarAccion('campanias', 'migrar_puntos', 'puntos_campania', $clienteId, [
                'puntos' => $puntosAntes,
                'campania_origen' => $campaniaOrigenId,
                'campania_destino' => $campaniaActiva['id']
            ]);

            return $this->response->setJSON(['success' => true, 'message' => "Se migraron {$puntosAntes} puntos a la campaña activa."]);

        } elseif ($accion === 'eliminar') {
            // Eliminar puntos
            $this->puntosCampaniaModel->eliminarPuntos($clienteId, $campaniaOrigenId);

            // Registrar ajuste
            $ajustePuntosModel->registrarAjuste(
                $clienteId,
                $campaniaOrigenId,
                $puntosAntes,
                0,
                'eliminacion',
                "Puntos eliminados por cierre de campaña",
                session()->get('user_id')
            );

            $this->auditoriaService->registrarAccion('campanias', 'eliminar_puntos', 'puntos_campania', $clienteId, [
                'puntos_eliminados' => $puntosAntes,
                'campania' => $campaniaOrigenId
            ]);

            return $this->response->setJSON(['success' => true, 'message' => "Se eliminaron {$puntosAntes} puntos."]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Acción no válida o no hay campaña activa para migrar.']);
    }
}
