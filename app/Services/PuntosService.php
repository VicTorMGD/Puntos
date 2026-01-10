<?php

namespace App\Services;

use App\Models\PuntosModel;
use App\Models\ClienteModel;
use App\Models\CompraModel;
use App\Models\CampaniaModel;
use App\Models\PuntosCampaniaModel;
use App\Services\AuditoriaService;

class PuntosService
{
    protected $db;
    protected $clienteModel;
    protected $compraModel;
    protected $campaniaModel;
    protected $puntosCampaniaModel;
    protected $auditoriaService;

    public function __construct()
    {
        $this->db = db_connect();
        $this->clienteModel = new ClienteModel();
        $this->compraModel = new CompraModel();
        $this->campaniaModel = new CampaniaModel();
        $this->puntosCampaniaModel = new PuntosCampaniaModel();
        $this->auditoriaService = new AuditoriaService();
    }

    /**
     * Registra una compra y calcula los puntos según la campaña activa
     */
    public function registrarCompra(int $clienteId, int $usuarioId, float $monto): array
    {
        // Obtener campaña activa
        $campania = $this->campaniaModel->getActiva();

        if (!$campania) {
            return [
                'success' => false,
                'message' => 'No hay campaña activa. Contacte al administrador.',
                'puntos' => 0,
                'compra_id' => null
            ];
        }

        // Calcular puntos según las reglas de la campaña
        $puntos = $this->calcularPuntos($monto, $campania);

        $this->db->transStart();

        try {
            // 1. Registrar compra con campaña
            $this->compraModel->insert([
                'cliente_id'       => $clienteId,
                'usuario_id'       => $usuarioId,
                'campania_id'      => $campania['id'],
                'monto_compra'     => $monto,
                'puntos_generados' => $puntos
            ]);
            $compraId = $this->compraModel->getInsertID();

            // 2. Registrar en historial de puntos (tabla puntos - mantener compatibilidad)
            $puntosModel = new PuntosModel();
            $puntosModel->insert([
                'cliente_id'  => $clienteId,
                'compra_id'   => $compraId,
                'puntos'      => $puntos,
                'tipo'        => 'GANADO',
                'descripcion' => 'Compra - ' . $campania['nombre']
            ]);

            // 3. Agregar puntos a la tabla puntos_campania
            $this->puntosCampaniaModel->agregarPuntos($clienteId, $campania['id'], $puntos);

            // 4. Actualizar puntos acumulados del cliente (cache)
            $cliente = $this->clienteModel->find($clienteId);
            if ($cliente) {
                $this->clienteModel->update($clienteId, [
                    'puntos_acumulados' => ($cliente['puntos_acumulados'] ?? 0) + $puntos
                ]);
            }

            // 5. Registrar en auditoría
            $this->auditoriaService->registrarAccion('compras', 'registrar', 'compras', $compraId, [
                'cliente_id' => $clienteId,
                'monto' => $monto,
                'puntos' => $puntos,
                'campania_id' => $campania['id'],
                'campania_nombre' => $campania['nombre']
            ]);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return [
                    'success' => false,
                    'message' => 'Error al registrar la compra.',
                    'puntos' => 0,
                    'compra_id' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'Compra registrada exitosamente.',
                'puntos' => $puntos,
                'compra_id' => $compraId,
                'campania' => $campania['nombre']
            ];

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error al registrar compra: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Error al registrar la compra: ' . $e->getMessage(),
                'puntos' => 0,
                'compra_id' => null
            ];
        }
    }

    /**
     * Calcula los puntos según las reglas de la campaña
     */
    public function calcularPuntos(float $monto, ?array $campania = null): int
    {
        if (!$campania) {
            $campania = $this->campaniaModel->getActiva();
        }

        if (!$campania) {
            return 0;
        }

        $montoBase = (float) $campania['monto_base'];
        $puntosPorMonto = (int) $campania['puntos_por_monto'];

        // Cálculo base: floor(monto / monto_base) * puntos_por_monto
        $puntos = floor($monto / $montoBase) * $puntosPorMonto;

        // Regla: Puntos dobles en fin de semana
        if ($campania['puntos_dobles_finsemana']) {
            $diaSemana = date('N'); // 1=Lunes, 7=Domingo
            if ($diaSemana >= 6) { // Sábado o Domingo
                $puntos *= 2;
            }
        }

        // Regla: Multiplicador por monto mínimo
        if ($campania['multiplicador_monto_minimo'] && $campania['multiplicador_valor']) {
            if ($monto >= (float) $campania['multiplicador_monto_minimo']) {
                $puntos *= (int) $campania['multiplicador_valor'];
            }
        }

        return (int) $puntos;
    }

    /**
     * Obtiene la información de la campaña activa
     */
    public function getCampaniaActiva(): ?array
    {
        return $this->campaniaModel->getActiva();
    }

    /**
     * Obtiene los puntos de un cliente por campaña
     */
    public function getPuntosClientePorCampania(int $clienteId): array
    {
        return $this->puntosCampaniaModel->getPuntosClienteConCampanias($clienteId);
    }

    /**
     * Obtiene el total de puntos disponibles de un cliente
     */
    public function getTotalPuntosCliente(int $clienteId): int
    {
        return $this->puntosCampaniaModel->getTotalPuntosDisponibles($clienteId);
    }

    /**
     * Método legacy para compatibilidad - registrar movimiento
     */
    public function registrarMovimiento(int $clienteId, float $monto, int $compraId): int
    {
        $campania = $this->campaniaModel->getActiva();
        $puntos = $this->calcularPuntos($monto, $campania);

        if ($puntos <= 0) {
            return 0;
        }

        // Registrar en historial de puntos
        $puntosModel = new PuntosModel();
        $puntosModel->insert([
            'cliente_id'  => $clienteId,
            'compra_id'   => $compraId,
            'puntos'      => $puntos,
            'tipo'        => 'GANADO',
            'descripcion' => $campania ? 'Compra - ' . $campania['nombre'] : 'Compra registrada'
        ]);

        // Agregar a puntos_campania si hay campaña activa
        if ($campania) {
            $this->puntosCampaniaModel->agregarPuntos($clienteId, $campania['id'], $puntos);
        }

        // Actualizar cache del cliente
        $cliente = $this->clienteModel->find($clienteId);
        if ($cliente) {
            $this->clienteModel->update($clienteId, [
                'puntos_acumulados' => ($cliente['puntos_acumulados'] ?? 0) + $puntos
            ]);
        }

        return $puntos;
    }
}
