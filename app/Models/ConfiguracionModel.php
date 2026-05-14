<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table      = 'configuraciones';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'modulo',
        'clave',
        'valor',
        'tipo',
        'descripcion'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType    = 'array';

    /**
     * Obtiene el valor de una configuración por módulo y clave
     */
    public function getValor(string $modulo, string $clave, $default = null)
    {
        $row = $this->where('modulo', $modulo)
                    ->where('clave', $clave)
                    ->first();

        return $row ? $row['valor'] : $default;
    }

    /**
     * Obtiene todas las configuraciones de un módulo como array clave => valor
     */
    public function getModulo(string $modulo): array
    {
        $rows = $this->where('modulo', $modulo)->findAll();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['clave']] = $row['valor'];
        }

        return $result;
    }

    /**
     * Guarda o actualiza una configuración
     */
    public function setValor(string $modulo, string $clave, string $valor): void
    {
        $existing = $this->where('modulo', $modulo)
                         ->where('clave', $clave)
                         ->first();

        if ($existing) {
            $this->update($existing['id'], ['valor' => $valor]);
        } else {
            $this->insert([
                'modulo' => $modulo,
                'clave'  => $clave,
                'valor'  => $valor
            ]);
        }
    }
}