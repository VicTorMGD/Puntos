<?php

namespace App\Services;

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

     public function registrarCompra(
        int $clienteId,
        int $usuarioId,
        float $monto,
        string $moneda = 'PEN'
    ): array {

        $db = db_connect();
        $db->transStart();

        // 🔹 regla de puntos (escalable)
        $factor = 2; // luego saldrá de configuracion_puntos
        $puntos = (int) floor($monto / $factor);

        $compraModel  = new CompraModel();
        $clienteModel = new ClienteModel();

        $compraId = $compraModel->insert([
            'cliente_id'       => $clienteId,
            'usuario_id'       => $usuarioId,
            'monto_compra'     => $monto,
            'puntos_generados' => $puntos,
            'moneda'           => $moneda
        ]);

        if (!$compraId) {
            throw new \Exception('No se pudo registrar la compra');
        }

        $clienteModel->where('id', $clienteId)
            ->set('puntos_acumulados', 'puntos_acumulados + ' . $puntos, false)
            ->update();

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new \Exception('Error en la transacción');
        }

        return [
            'puntos'    => $puntos,
            'compra_id' => $compraId
        ];
    }
}
