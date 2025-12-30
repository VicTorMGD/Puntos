<?php
namespace App\Models;
use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipo_documento','numero_documento','nombres','apellidos',
        'telefono','email','puntos_acumulados','estado'
    ];

    public function incrementarPuntos(int $clienteId, int $puntos)
    {
        return $this->set('puntos_acumulados', "puntos_acumulados + $puntos", false)
                    ->where('id', $clienteId)
                    ->update();
    }

    // app/Models/ClienteModel.php
    public function getPuntosAcumulados(int $clienteId): int
    {
        return (int) $this->db->table('puntos')
            ->selectSum('puntos')
            ->where('cliente_id', $clienteId)
            ->get()
            ->getRow()
            ->puntos ?? 0;
    }

}
