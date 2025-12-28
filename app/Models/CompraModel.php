<?php
namespace App\Models;
use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $table = 'compras';
    protected $allowedFields = [
        'cliente_id','usuario_id','monto_compra','puntos_generados'
    ];
}
