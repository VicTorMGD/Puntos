<?php

if (!function_exists('formatear_fecha')) {
    /**
     * Formatea fechas al estándar peruano
     *
     * @param string $fecha Fecha en formato YYYY-MM-DD o YYYY-MM
     * @param string $tipo 'dia' o 'mes'
     * @return string Fecha formateada DD/MM/YYYY o MM/YYYY
     */
    function formatear_fecha($fecha, $tipo = 'dia') {
        if (empty($fecha)) {
            return '';
        }

        if ($tipo === 'mes') {
            // Formato: 2025-01 → 01/2025
            $partes = explode('-', $fecha);
            if (count($partes) === 2) {
                return $partes[1] . '/' . $partes[0];
            }
        } else {
            // Formato: 2025-01-15 → 15/01/2025
            $partes = explode('-', $fecha);
            if (count($partes) === 3) {
                return $partes[2] . '/' . $partes[1] . '/' . $partes[0];
            }
        }

        return $fecha; // Si no se puede formatear, retorna original
    }
}

if (!function_exists('revertir_fecha')) {
    /**
     * Convierte fecha DD/MM/YYYY a YYYY-MM-DD (para queries)
     *
     * @param string $fecha Fecha en formato DD/MM/YYYY
     * @return string Fecha en formato YYYY-MM-DD
     */
    function revertir_fecha($fecha) {
        if (empty($fecha)) {
            return '';
        }

        $partes = explode('/', $fecha);
        if (count($partes) === 3) {
            return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
        }

        return $fecha;
    }
}
