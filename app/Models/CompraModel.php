<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $table      = 'compras';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'cliente_id',
        'usuario_id',
        'campania_id',
        'monto_compra',
        'puntos_generados'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $returnType    = 'array';

    /**
     * Obtiene las compras de un cliente con detalles de campaña
     */
    public function getComprasCliente(int $clienteId): array
    {
        return $this->select('compras.*, campanias.nombre as campania_nombre, users.name as usuario_nombre')
                    ->join('campanias', 'campanias.id = compras.campania_id', 'left')
                    ->join('users', 'users.id = compras.usuario_id')
                    ->where('compras.cliente_id', $clienteId)
                    ->orderBy('compras.created_at', 'DESC')
                    ->findAll();
    }
}
