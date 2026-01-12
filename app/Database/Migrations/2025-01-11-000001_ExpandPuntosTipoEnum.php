<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migración para expandir el ENUM de puntos.tipo
 *
 * Tipos anteriores: GANADO, USADO, AJUSTE
 * Tipos nuevos: GANADO, USADO, AJUSTE, CANJEADO, AJUSTE_POSITIVO, AJUSTE_NEGATIVO, ELIMINADO, MIGRACION
 *
 * IMPORTANTE: Si la migración automática falla, ejecutar manualmente en phpMyAdmin:
 *
 * ALTER TABLE puntos MODIFY COLUMN tipo ENUM('GANADO', 'USADO', 'AJUSTE', 'CANJEADO', 'AJUSTE_POSITIVO', 'AJUSTE_NEGATIVO', 'ELIMINADO', 'MIGRACION') NOT NULL DEFAULT 'GANADO';
 *
 * -- Opcionalmente, actualizar registros existentes para usar los nuevos tipos:
 * UPDATE puntos SET tipo = 'CANJEADO' WHERE tipo = 'USADO';
 * UPDATE puntos SET tipo = 'AJUSTE_POSITIVO' WHERE tipo = 'AJUSTE' AND puntos > 0;
 * UPDATE puntos SET tipo = 'AJUSTE_NEGATIVO' WHERE tipo = 'AJUSTE' AND puntos <= 0;
 */
class ExpandPuntosTipoEnum extends Migration
{
    public function up()
    {
        // Expandir ENUM manteniendo los tipos antiguos por compatibilidad
        $sql = "ALTER TABLE puntos MODIFY COLUMN tipo ENUM('GANADO', 'USADO', 'AJUSTE', 'CANJEADO', 'AJUSTE_POSITIVO', 'AJUSTE_NEGATIVO', 'ELIMINADO', 'MIGRACION') NOT NULL DEFAULT 'GANADO'";
        $this->db->query($sql);

        // Migrar datos existentes a los nuevos tipos (opcional)
        $this->db->query("UPDATE puntos SET tipo = 'CANJEADO' WHERE tipo = 'USADO'");
        $this->db->query("UPDATE puntos SET tipo = 'AJUSTE_POSITIVO' WHERE tipo = 'AJUSTE' AND puntos > 0");
        $this->db->query("UPDATE puntos SET tipo = 'AJUSTE_NEGATIVO' WHERE tipo = 'AJUSTE' AND puntos <= 0");
    }

    public function down()
    {
        // Revertir a los tipos anteriores
        $this->db->query("UPDATE puntos SET tipo = 'USADO' WHERE tipo = 'CANJEADO'");
        $this->db->query("UPDATE puntos SET tipo = 'AJUSTE' WHERE tipo IN ('AJUSTE_POSITIVO', 'AJUSTE_NEGATIVO', 'ELIMINADO', 'MIGRACION')");

        $sql = "ALTER TABLE puntos MODIFY COLUMN tipo ENUM('GANADO', 'USADO', 'AJUSTE') NOT NULL DEFAULT 'GANADO'";
        $this->db->query($sql);
    }
}
