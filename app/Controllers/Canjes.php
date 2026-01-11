<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\CampaniaModel;
use App\Models\PuntosCampaniaModel;
use App\Models\CanjeModel;
use App\Models\AjustePuntosModel;
use App\Models\PuntosModel;
use App\Services\AuditoriaService;

class Canjes extends BaseController
{
    protected $clienteModel;
    protected $campaniaModel;
    protected $puntosCampaniaModel;
    protected $canjeModel;
    protected $ajustePuntosModel;
    protected $puntosModel;
    protected $auditoriaService;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->campaniaModel = new CampaniaModel();
        $this->puntosCampaniaModel = new PuntosCampaniaModel();
        $this->canjeModel = new CanjeModel();
        $this->ajustePuntosModel = new AjustePuntosModel();
        $this->puntosModel = new PuntosModel();
        $this->auditoriaService = new AuditoriaService();
    }

    /**
     * Vista principal de canje de puntos
     */
    public function index()
    {
        $data = [
            'title' => 'Canje de Puntos',
            'campaniaActiva' => $this->campaniaModel->getActiva()
        ];

        return view('canjes/index', $data);
    }

    /**
     * Busca un cliente y retorna sus puntos por campaña
     */
    public function buscarCliente()
    {
        $documento = $this->request->getPost('documento');

        if (empty($documento)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ingrese el número de documento'
            ]);
        }

        $cliente = $this->clienteModel->where('numero_documento', $documento)
                                       ->where('estado', 1)
                                       ->first();

        if (!$cliente) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cliente no encontrado o inactivo'
            ]);
        }

        // Obtener puntos por campaña
        $puntosPorCampania = $this->puntosCampaniaModel->getPuntosClienteConCampanias($cliente['id']);

        // Calcular total de puntos disponibles
        $totalPuntos = 0;
        foreach ($puntosPorCampania as $pc) {
            $totalPuntos += $pc['puntos_disponibles'];
        }

        return $this->response->setJSON([
            'success' => true,
            'cliente' => [
                'id' => $cliente['id'],
                'nombres' => $cliente['nombres'],
                'apellidos' => $cliente['apellidos'],
                'numero_documento' => $cliente['numero_documento'],
                'puntos_acumulados' => $cliente['puntos_acumulados']
            ],
            'puntos_por_campania' => $puntosPorCampania,
            'total_puntos' => $totalPuntos
        ]);
    }

    /**
     * Registra un canje de puntos
     */
    public function registrar()
    {
        $clienteId = (int) $this->request->getPost('cliente_id');
        $campaniaId = (int) $this->request->getPost('campania_id');
        $puntosCanjear = (int) $this->request->getPost('puntos');
        $observacion = $this->request->getPost('observacion');

        // Validaciones
        if ($clienteId <= 0 || $campaniaId <= 0 || $puntosCanjear <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Datos inválidos'
            ]);
        }

        // Verificar cliente
        $cliente = $this->clienteModel->find($clienteId);
        if (!$cliente || $cliente['estado'] != 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cliente no encontrado o inactivo'
            ]);
        }

        // Verificar puntos disponibles
        $puntosCliente = $this->puntosCampaniaModel->getPuntosCliente($clienteId, $campaniaId);
        if (!$puntosCliente || $puntosCliente['puntos_disponibles'] < $puntosCanjear) {
            $disponibles = $puntosCliente['puntos_disponibles'] ?? 0;
            return $this->response->setJSON([
                'success' => false,
                'message' => "Puntos insuficientes. Disponibles: {$disponibles}"
            ]);
        }

        // Obtener nombre de la campaña para la descripción
        $campania = $this->campaniaModel->find($campaniaId);
        $campaniaNombre = $campania ? $campania['nombre'] : 'Campaña #' . $campaniaId;

        $db = db_connect();
        $db->transStart();

        try {
            // 1. Registrar el canje
            $canjeId = $this->canjeModel->registrarCanje(
                $clienteId,
                $campaniaId,
                $puntosCanjear,
                $observacion,
                session()->get('user_id')
            );

            // 2. Actualizar puntos en puntos_campania
            $this->puntosCampaniaModel->canjearPuntos($clienteId, $campaniaId, $puntosCanjear);

            // 3. Actualizar cache de puntos del cliente
            $this->clienteModel->update($clienteId, [
                'puntos_acumulados' => $cliente['puntos_acumulados'] - $puntosCanjear
            ]);

            // 4. Registrar en historial de puntos (tabla puntos)
            $descripcionCanje = "Canje - {$campaniaNombre}";
            if ($observacion) {
                $descripcionCanje .= " ({$observacion})";
            }
            $this->puntosModel->registrar(
                $clienteId,
                $puntosCanjear,
                null,
                'CANJEADO',
                $descripcionCanje
            );

            // 5. Registrar en auditoría
            $this->auditoriaService->registrarAccion('canjes', 'canjear', 'canjes', $canjeId, [
                'cliente_id' => $clienteId,
                'campania_id' => $campaniaId,
                'puntos_canjeados' => $puntosCanjear,
                'observacion' => $observacion
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al procesar el canje'
                ]);
            }

            // Obtener puntos restantes
            $puntosRestantes = $this->puntosCampaniaModel->getPuntosCliente($clienteId, $campaniaId);

            return $this->response->setJSON([
                'success' => true,
                'message' => "Canje exitoso de {$puntosCanjear} puntos",
                'canje_id' => $canjeId,
                'puntos_restantes' => $puntosRestantes['puntos_disponibles'] ?? 0
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Ajusta los puntos de un cliente (corrección manual)
     */
    public function ajustar()
    {
        $clienteId = (int) $this->request->getPost('cliente_id');
        $campaniaId = (int) $this->request->getPost('campania_id');
        $nuevosPuntos = (int) $this->request->getPost('nuevos_puntos');
        $observacion = $this->request->getPost('observacion');

        // Validaciones
        if ($clienteId <= 0 || $campaniaId <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Datos inválidos'
            ]);
        }

        if (empty($observacion)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debe ingresar una observación para el ajuste'
            ]);
        }

        if ($nuevosPuntos < 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Los puntos no pueden ser negativos'
            ]);
        }

        // Obtener puntos actuales
        $puntosActuales = $this->puntosCampaniaModel->getPuntosCliente($clienteId, $campaniaId);
        $puntosAntes = $puntosActuales['puntos_disponibles'] ?? 0;

        if ($puntosAntes == $nuevosPuntos) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Los puntos son iguales, no hay cambio que realizar'
            ]);
        }

        // Obtener nombre de la campaña para la descripción
        $campania = $this->campaniaModel->find($campaniaId);
        $campaniaNombre = $campania ? $campania['nombre'] : 'Campaña #' . $campaniaId;
        $diferencia = $nuevosPuntos - $puntosAntes;

        $db = db_connect();
        $db->transStart();

        try {
            // 1. Ajustar puntos en puntos_campania
            $this->puntosCampaniaModel->ajustarPuntos($clienteId, $campaniaId, $nuevosPuntos);

            // 2. Registrar el ajuste
            $this->ajustePuntosModel->registrarAjuste(
                $clienteId,
                $campaniaId,
                $puntosAntes,
                $nuevosPuntos,
                'correccion',
                $observacion,
                session()->get('user_id')
            );

            // 3. Actualizar cache del cliente
            $cliente = $this->clienteModel->find($clienteId);
            $this->clienteModel->update($clienteId, [
                'puntos_acumulados' => $cliente['puntos_acumulados'] + $diferencia
            ]);

            // 4. Registrar en historial de puntos (tabla puntos)
            $tipoAjuste = $diferencia >= 0 ? 'AJUSTE_POSITIVO' : 'AJUSTE_NEGATIVO';
            $descripcionAjuste = "Ajuste - {$campaniaNombre}: {$puntosAntes} -> {$nuevosPuntos} ({$observacion})";
            $this->puntosModel->registrar(
                $clienteId,
                abs($diferencia),
                null,
                $tipoAjuste,
                $descripcionAjuste
            );

            // 5. Registrar en auditoría
            $this->auditoriaService->registrarAccion('canjes', 'ajustar', 'puntos_campania', $clienteId, [
                'campania_id' => $campaniaId,
                'puntos_antes' => $puntosAntes,
                'puntos_despues' => $nuevosPuntos,
                'observacion' => $observacion
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al procesar el ajuste'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => "Ajuste realizado: {$puntosAntes} -> {$nuevosPuntos} puntos",
                'puntos_nuevos' => $nuevosPuntos
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Genera el ticket de canje
     */
    public function ticket($canjeId)
    {
        $canje = $this->canjeModel->getCanjeConDetalles($canjeId);

        if (!$canje) {
            return redirect()->to('/canjes')->with('error', 'Canje no encontrado');
        }

        $data = [
            'title' => 'Comprobante de Canje',
            'canje' => $canje
        ];

        return view('canjes/ticket', $data);
    }

    /**
     * Historial de canjes de un cliente
     */
    public function historial($clienteId)
    {
        $cliente = $this->clienteModel->find($clienteId);

        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'Cliente no encontrado');
        }

        $data = [
            'title' => 'Historial de Canjes - ' . $cliente['nombres'] . ' ' . $cliente['apellidos'],
            'cliente' => $cliente,
            'canjes' => $this->canjeModel->getCanjesCliente($clienteId),
            'ajustes' => $this->ajustePuntosModel->getAjustesCliente($clienteId)
        ];

        return view('canjes/historial', $data);
    }
}
