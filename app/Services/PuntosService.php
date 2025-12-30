<?php

namespace App\Services;

use App\Models\PuntosModel;
use App\Models\ClienteModel;
use App\Models\CompraModel;
use App\Models\MovimientoPuntosModel;
use App\Models\ConfiguracionPuntosModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PuntosService
{
    protected $db;
    protected $clienteModel;
    protected $compraModel;
    protected $movimientoModel;
    protected $configModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->clienteModel = new ClienteModel();
        $this->compraModel = new CompraModel();
        $this->movimientoModel = new MovimientoPuntosModel();
        $this->configModel = new ConfiguracionPuntosModel();
    }

    public function registrarCompra(int $clienteId, int $usuarioId, float $monto): int
    {
        // Regla de negocio (S/ 2 = 1 punto)
        $puntos = (int) floor($monto / 2);

        $compraModel  = new CompraModel();
        $puntosModel  = new PuntosModel();
        $clienteModel = new ClienteModel();

        // 1️⃣ Registrar compra
        $compraId = $compraModel->insert([
            'cliente_id'       => $clienteId,
            'usuario_id'       => $usuarioId,
            'monto_compra'     => $monto,
            'puntos_generados' => $puntos
        ]);

        // 2️⃣ Registrar historial de puntos
        $puntosModel->insert([
            'cliente_id' => $clienteId,
            'compra_id'  => $compraId,
            'puntos'     => $puntos,
            'tipo'       => 'GANADO',
            'descripcion'=> 'Compra realizada'
        ]);

        // 3️⃣ 🔥 ACTUALIZAR puntos acumulados del cliente
        $cliente = $clienteModel->find($clienteId);

        if ($cliente) {
            $clienteModel->update($clienteId, [
                'puntos_acumulados' => ($cliente['puntos_acumulados'] ?? 0) + $puntos
            ]);
        }

        return $puntos;
    }

    public function calcularPuntos(float $monto): int
    {
        // 1 punto por cada 2 soles, solo parte entera
        return (int) floor($monto / 2);
    }

    public function registrarMovimiento(
        int $clienteId,
        float $monto,
        int $compraId
    ): int {
        $puntos = $this->calcularPuntos($monto);

        if ($puntos <= 0) {
            return 0;
        }

        // 1️⃣ Registrar movimiento en historial de puntos
        $puntosModel = new PuntosModel();
        $puntosModel->registrar(
            $clienteId,
            $puntos,
            $compraId,
            'GANADO',
            'Compra registrada'
        );

        // 2️⃣ 🔥 ACTUALIZAR puntos acumulados del cliente
        $cliente = $this->clienteModel->find($clienteId);
        
        if ($cliente) {
            $this->clienteModel->update($clienteId, [
                'puntos_acumulados' => ($cliente['puntos_acumulados'] ?? 0) + $puntos
            ]);
        }

        return $puntos;
    }
}
