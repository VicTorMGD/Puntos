<?php

namespace App\Models;

use CodeIgniter\Model;

class AjustePuntosModel extends Model
{
    protected $table      = 'ajustes_puntos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'cliente_id',
        'campania_id',
        'puntos_antes',
        'puntos_despues',
        'tipo',
        'observacion',
        'usuario_id'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No tiene updated_at
    protected $returnType    = 'array';

    /**
     * Registra un ajuste de puntos
     */
    public function registrarAjuste(
        int $clienteId,
        int $campaniaId,
        int $puntosAntes,
        int $puntosDespues,
        string $tipo,
        string $observacion,
        int $usuarioId
    ): int {
        $this->insert([
            'cliente_id'     => $clienteId,
            'campania_id'    => $campaniaId,
            'puntos_antes'   => $puntosAntes,
            'puntos_despues' => $puntosDespues,
            'tipo'           => $tipo,
            'observacion'    => $observacion,
            'usuario_id'     => $usuarioId
        ]);

        return $this->getInsertID();
    }

    /**
     * Obtiene los ajustes de un cliente
     */
    public function getAjustesCliente(int $clienteId): array
    {
        return $this->select('ajustes_puntos.*, campanias.nombre as campania_nombre, users.name as usuario_nombre')
                    ->join('campanias', 'campanias.id = ajustes_puntos.campania_id')
                    ->join('users', 'users.id = ajustes_puntos.usuario_id')
                    ->where('ajustes_puntos.cliente_id', $clienteId)
                    ->orderBy('ajustes_puntos.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene el historial de ajustes (para administración)
     */
    public function getHistorialAjustes(int $limit = 100): array
    {
        return $this->select('ajustes_puntos.*,
                              campanias.nombre as campania_nombre,
                              users.name as usuario_nombre,
                              CONCAT(clientes.nombres, " ", clientes.apellidos) as cliente_nombre,
                              clientes.numero_documento as cliente_documento')
                    ->join('campanias', 'campanias.id = ajustes_puntos.campania_id')
                    ->join('users', 'users.id = ajustes_puntos.usuario_id')
                    ->join('clientes', 'clientes.id = ajustes_puntos.cliente_id')
                    ->orderBy('ajustes_puntos.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
