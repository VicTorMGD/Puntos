<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionPuntosModel extends Model
{
    protected $table = 'configuracion_puntos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'monto_base',
        'puntos_equivalentes',
        'estado'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Obtiene la configuración activa
     */
    public function getActiva()
    {
        return $this->where('estado', 1)->first();
    }
}
