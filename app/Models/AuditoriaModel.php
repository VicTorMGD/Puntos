<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $table      = 'auditoria';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id',
        'modulo',
        'accion',
        'tabla_afectada',
        'registro_id',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No tiene updated_at
    protected $returnType    = 'array';

    /**
     * Registra una acción en el log de auditoría
     */
    public function registrar(
        int $usuarioId,
        string $modulo,
        string $accion,
        ?string $tablaAfectada = null,
        ?int $registroId = null,
        ?array $datosAnteriores = null,
        ?array $datosNuevos = null
    ): int {
        $this->insert([
            'usuario_id'       => $usuarioId,
            'modulo'           => $modulo,
            'accion'           => $accion,
            'tabla_afectada'   => $tablaAfectada,
            'registro_id'      => $registroId,
            'datos_anteriores' => $datosAnteriores ? json_encode($datosAnteriores) : null,
            'datos_nuevos'     => $datosNuevos ? json_encode($datosNuevos) : null,
            'ip_address'       => $_SERVER['REMOTE_ADDR'] ?? null
        ]);

        return $this->getInsertID();
    }

    /**
     * Obtiene el historial de auditoría con filtros
     */
    public function getHistorial(array $filtros = [], int $limit = 100): array
    {
        $builder = $this->select('auditoria.*, users.name as usuario_nombre')
                        ->join('users', 'users.id = auditoria.usuario_id')
                        ->orderBy('auditoria.created_at', 'DESC');

        if (!empty($filtros['modulo'])) {
            $builder->where('auditoria.modulo', $filtros['modulo']);
        }

        if (!empty($filtros['accion'])) {
            $builder->where('auditoria.accion', $filtros['accion']);
        }

        if (!empty($filtros['usuario_id'])) {
            $builder->where('auditoria.usuario_id', $filtros['usuario_id']);
        }

        if (!empty($filtros['fecha_desde'])) {
            $builder->where('auditoria.created_at >=', $filtros['fecha_desde']);
        }

        if (!empty($filtros['fecha_hasta'])) {
            $builder->where('auditoria.created_at <=', $filtros['fecha_hasta']);
        }

        return $builder->limit($limit)->findAll();
    }

    /**
     * Obtiene las acciones de un módulo específico
     */
    public function getAccionesModulo(string $modulo, int $limit = 50): array
    {
        return $this->select('auditoria.*, users.name as usuario_nombre')
                    ->join('users', 'users.id = auditoria.usuario_id')
                    ->where('auditoria.modulo', $modulo)
                    ->orderBy('auditoria.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Obtiene los módulos únicos registrados
     */
    public function getModulos(): array
    {
        return $this->distinct()
                    ->select('modulo')
                    ->orderBy('modulo', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene las acciones únicas registradas
     */
    public function getAcciones(): array
    {
        return $this->distinct()
                    ->select('accion')
                    ->orderBy('accion', 'ASC')
                    ->findAll();
    }
}
