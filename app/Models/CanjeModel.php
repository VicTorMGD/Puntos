<?php

namespace App\Models;

use CodeIgniter\Model;

class CanjeModel extends Model
{
    protected $table      = 'canjes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'cliente_id',
        'campania_id',
        'puntos_canjeados',
        'observacion',
        'usuario_id'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No tiene updated_at
    protected $returnType    = 'array';

    /**
     * Registra un nuevo canje
     */
    public function registrarCanje(int $clienteId, int $campaniaId, int $puntos, ?string $observacion, int $usuarioId): int
    {
        $this->insert([
            'cliente_id'      => $clienteId,
            'campania_id'     => $campaniaId,
            'puntos_canjeados' => $puntos,
            'observacion'     => $observacion,
            'usuario_id'      => $usuarioId
        ]);

        return $this->getInsertID();
    }

    /**
     * Obtiene los canjes de un cliente
     */
    public function getCanjesCliente(int $clienteId): array
    {
        return $this->select('canjes.*, campanias.nombre as campania_nombre, users.name as usuario_nombre')
                    ->join('campanias', 'campanias.id = canjes.campania_id')
                    ->join('users', 'users.id = canjes.usuario_id')
                    ->where('canjes.cliente_id', $clienteId)
                    ->orderBy('canjes.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene un canje con todos sus detalles
     */
    public function getCanjeConDetalles(int $canjeId): ?array
    {
        return $this->select('canjes.*,
                              campanias.nombre as campania_nombre,
                              users.name as usuario_nombre,
                              clientes.nombres as cliente_nombres,
                              clientes.apellidos as cliente_apellidos,
                              clientes.numero_documento as cliente_documento')
                    ->join('campanias', 'campanias.id = canjes.campania_id')
                    ->join('users', 'users.id = canjes.usuario_id')
                    ->join('clientes', 'clientes.id = canjes.cliente_id')
                    ->where('canjes.id', $canjeId)
                    ->first();
    }

    /**
     * Obtiene el historial de canjes (para administración)
     */
    public function getHistorialCanjes(int $limit = 100): array
    {
        return $this->select('canjes.*,
                              campanias.nombre as campania_nombre,
                              users.name as usuario_nombre,
                              CONCAT(clientes.nombres, " ", clientes.apellidos) as cliente_nombre,
                              clientes.numero_documento as cliente_documento')
                    ->join('campanias', 'campanias.id = canjes.campania_id')
                    ->join('users', 'users.id = canjes.usuario_id')
                    ->join('clientes', 'clientes.id = canjes.cliente_id')
                    ->orderBy('canjes.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
