<?php

namespace App\Models;

use CodeIgniter\Model;

class PuntosModel extends Model
{
    protected $table      = 'puntos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'cliente_id',
        'compra_id',
        'puntos',
        'tipo',
        'descripcion'
    ];

    protected $useTimestamps = false;

    /**
     * Registra un movimiento de puntos
     */
    public function registrar(
        int $clienteId,
        int $puntos,
        ?int $compraId = null,
        string $tipo = 'GANADO',
        ?string $descripcion = null
    ): int {
        $this->insert([
            'cliente_id' => $clienteId,
            'compra_id'  => $compraId,
            'puntos'     => $puntos,
            'tipo'       => $tipo,
            'descripcion'=> $descripcion
        ]);

        return $this->getInsertID();
    }

    /**
     * Historial de puntos por cliente
     */
    public function getByCliente(int $clienteId): array
    {
        return $this->where('cliente_id', $clienteId)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}
