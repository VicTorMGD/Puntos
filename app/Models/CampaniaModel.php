<?php

namespace App\Models;

use CodeIgniter\Model;

class CampaniaModel extends Model
{
    protected $table      = 'campanias';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'monto_base',
        'puntos_por_monto',
        'puntos_dobles_finsemana',
        'multiplicador_monto_minimo',
        'multiplicador_valor',
        'estado',
        'creado_por',
        'cerrado_por',
        'closed_at'
    ];

    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /**
     * Obtiene la campaña activa actual
     */
    public function getActiva(): ?array
    {
        return $this->where('estado', 'activa')->first();
    }

    /**
     * Obtiene todas las campañas con información del creador
     */
    public function getAllWithCreator(): array
    {
        return $this->select('campanias.*, users.name as creador_nombre')
                    ->join('users', 'users.id = campanias.creado_por')
                    ->orderBy('campanias.id', 'DESC')
                    ->findAll();
    }

    /**
     * Cierra la campaña actual
     */
    public function cerrarCampania(int $campaniaId, int $usuarioId): bool
    {
        return $this->update($campaniaId, [
            'estado'     => 'cerrada',
            'cerrado_por' => $usuarioId,
            'closed_at'  => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Verifica si hay una campaña activa
     */
    public function hayActiva(): bool
    {
        return $this->where('estado', 'activa')->countAllResults() > 0;
    }

    /**
     * Calcula los puntos según las reglas de la campaña
     */
    public function calcularPuntos(float $monto, ?array $campania = null): int
    {
        if (!$campania) {
            $campania = $this->getActiva();
        }

        if (!$campania) {
            return 0;
        }

        $montoBase = (float) $campania['monto_base'];
        $puntosPorMonto = (int) $campania['puntos_por_monto'];

        // Cálculo base: floor(monto / monto_base) * puntos_por_monto
        $puntos = floor($monto / $montoBase) * $puntosPorMonto;

        // Regla: Puntos dobles en fin de semana
        if ($campania['puntos_dobles_finsemana']) {
            $diaSemana = date('N'); // 1=Lunes, 7=Domingo
            if ($diaSemana >= 6) { // Sábado o Domingo
                $puntos *= 2;
            }
        }

        // Regla: Multiplicador por monto mínimo
        if ($campania['multiplicador_monto_minimo'] && $campania['multiplicador_valor']) {
            if ($monto >= (float) $campania['multiplicador_monto_minimo']) {
                $puntos *= (int) $campania['multiplicador_valor'];
            }
        }

        return (int) $puntos;
    }
}
