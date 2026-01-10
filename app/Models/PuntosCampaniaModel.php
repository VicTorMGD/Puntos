<?php

namespace App\Models;

use CodeIgniter\Model;

class PuntosCampaniaModel extends Model
{
    protected $table      = 'puntos_campania';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'cliente_id',
        'campania_id',
        'puntos_disponibles',
        'puntos_canjeados'
    ];

    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /**
     * Obtiene los puntos de un cliente en una campaña específica
     */
    public function getPuntosCliente(int $clienteId, int $campaniaId): ?array
    {
        return $this->where('cliente_id', $clienteId)
                    ->where('campania_id', $campaniaId)
                    ->first();
    }

    /**
     * Obtiene todos los puntos de un cliente agrupados por campaña
     */
    public function getPuntosClienteConCampanias(int $clienteId): array
    {
        return $this->select('puntos_campania.*, campanias.nombre as campania_nombre, campanias.estado as campania_estado')
                    ->join('campanias', 'campanias.id = puntos_campania.campania_id')
                    ->where('puntos_campania.cliente_id', $clienteId)
                    ->orderBy('campanias.estado', 'ASC') // Activas primero
                    ->orderBy('campanias.id', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene el total de puntos disponibles de un cliente (todas las campañas)
     */
    public function getTotalPuntosDisponibles(int $clienteId): int
    {
        $result = $this->selectSum('puntos_disponibles')
                       ->where('cliente_id', $clienteId)
                       ->first();
        return (int) ($result['puntos_disponibles'] ?? 0);
    }

    /**
     * Agrega puntos a un cliente en una campaña
     */
    public function agregarPuntos(int $clienteId, int $campaniaId, int $puntos): bool
    {
        $registro = $this->getPuntosCliente($clienteId, $campaniaId);

        if ($registro) {
            // Actualizar registro existente
            return $this->update($registro['id'], [
                'puntos_disponibles' => $registro['puntos_disponibles'] + $puntos
            ]);
        } else {
            // Crear nuevo registro
            return $this->insert([
                'cliente_id'         => $clienteId,
                'campania_id'        => $campaniaId,
                'puntos_disponibles' => $puntos,
                'puntos_canjeados'   => 0
            ]) !== false;
        }
    }

    /**
     * Canjea puntos de un cliente en una campaña
     */
    public function canjearPuntos(int $clienteId, int $campaniaId, int $puntos): bool
    {
        $registro = $this->getPuntosCliente($clienteId, $campaniaId);

        if (!$registro || $registro['puntos_disponibles'] < $puntos) {
            return false;
        }

        return $this->update($registro['id'], [
            'puntos_disponibles' => $registro['puntos_disponibles'] - $puntos,
            'puntos_canjeados'   => $registro['puntos_canjeados'] + $puntos
        ]);
    }

    /**
     * Migra puntos de una campaña a otra
     */
    public function migrarPuntos(int $clienteId, int $campaniaOrigen, int $campaniaDestino, int $puntos): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // Restar de la campaña origen
        $origen = $this->getPuntosCliente($clienteId, $campaniaOrigen);
        if (!$origen || $origen['puntos_disponibles'] < $puntos) {
            $db->transRollback();
            return false;
        }

        $this->update($origen['id'], [
            'puntos_disponibles' => $origen['puntos_disponibles'] - $puntos
        ]);

        // Agregar a la campaña destino
        $this->agregarPuntos($clienteId, $campaniaDestino, $puntos);

        $db->transComplete();
        return $db->transStatus();
    }

    /**
     * Ajusta los puntos de un cliente (corrección manual)
     */
    public function ajustarPuntos(int $clienteId, int $campaniaId, int $nuevosPuntos): bool
    {
        $registro = $this->getPuntosCliente($clienteId, $campaniaId);

        if ($registro) {
            return $this->update($registro['id'], [
                'puntos_disponibles' => $nuevosPuntos
            ]);
        } else {
            return $this->insert([
                'cliente_id'         => $clienteId,
                'campania_id'        => $campaniaId,
                'puntos_disponibles' => $nuevosPuntos,
                'puntos_canjeados'   => 0
            ]) !== false;
        }
    }

    /**
     * Elimina los puntos de un cliente en una campaña
     */
    public function eliminarPuntos(int $clienteId, int $campaniaId): bool
    {
        $registro = $this->getPuntosCliente($clienteId, $campaniaId);

        if ($registro) {
            return $this->update($registro['id'], [
                'puntos_disponibles' => 0
            ]);
        }

        return true;
    }
}
