<?php
namespace App\Models;
use CodeIgniter\Model;

class MovimientoPuntosModel extends Model
{
    protected $table = 'movimientos_puntos';
    protected $allowedFields = [
        'cliente_id','tipo','puntos','referencia_id','descripcion'
    ];
}
