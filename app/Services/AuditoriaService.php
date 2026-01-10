<?php

namespace App\Services;

use App\Models\AuditoriaModel;

class AuditoriaService
{
    protected $auditoriaModel;

    public function __construct()
    {
        $this->auditoriaModel = new AuditoriaModel();
    }

    /**
     * Registra una acción en el log de auditoría
     *
     * @param string $modulo Nombre del módulo (ej: 'campanias', 'canjes', 'compras')
     * @param string $accion Acción realizada (ej: 'crear', 'editar', 'eliminar', 'canjear')
     * @param string|null $tablaAfectada Tabla de la base de datos afectada
     * @param int|null $registroId ID del registro afectado
     * @param array|null $datosAnteriores Datos antes del cambio
     * @param array|null $datosNuevos Datos después del cambio
     * @return int ID del registro de auditoría creado
     */
    public function registrar(
        string $modulo,
        string $accion,
        ?string $tablaAfectada = null,
        ?int $registroId = null,
        ?array $datosAnteriores = null,
        ?array $datosNuevos = null
    ): int {
        $usuarioId = session()->get('user_id');

        if (!$usuarioId) {
            return 0; // No registrar si no hay usuario autenticado
        }

        return $this->auditoriaModel->registrar(
            $usuarioId,
            $modulo,
            $accion,
            $tablaAfectada,
            $registroId,
            $datosAnteriores,
            $datosNuevos
        );
    }

    /**
     * Registra la creación de un registro
     */
    public function registrarCreacion(string $modulo, string $tabla, int $registroId, array $datos): int
    {
        // Limpiar datos sensibles
        $datosLimpios = $this->limpiarDatosSensibles($datos);

        return $this->registrar(
            $modulo,
            'crear',
            $tabla,
            $registroId,
            null,
            $datosLimpios
        );
    }

    /**
     * Registra la edición de un registro
     */
    public function registrarEdicion(string $modulo, string $tabla, int $registroId, array $datosAnteriores, array $datosNuevos): int
    {
        // Limpiar datos sensibles
        $anterioresLimpios = $this->limpiarDatosSensibles($datosAnteriores);
        $nuevosLimpios = $this->limpiarDatosSensibles($datosNuevos);

        return $this->registrar(
            $modulo,
            'editar',
            $tabla,
            $registroId,
            $anterioresLimpios,
            $nuevosLimpios
        );
    }

    /**
     * Registra la eliminación de un registro
     */
    public function registrarEliminacion(string $modulo, string $tabla, int $registroId, array $datos): int
    {
        // Limpiar datos sensibles
        $datosLimpios = $this->limpiarDatosSensibles($datos);

        return $this->registrar(
            $modulo,
            'eliminar',
            $tabla,
            $registroId,
            $datosLimpios,
            null
        );
    }

    /**
     * Registra una acción personalizada
     */
    public function registrarAccion(string $modulo, string $accion, ?string $tabla = null, ?int $registroId = null, ?array $datos = null): int
    {
        $datosLimpios = $datos ? $this->limpiarDatosSensibles($datos) : null;

        return $this->registrar(
            $modulo,
            $accion,
            $tabla,
            $registroId,
            null,
            $datosLimpios
        );
    }

    /**
     * Limpia datos sensibles antes de guardar en auditoría
     */
    protected function limpiarDatosSensibles(array $datos): array
    {
        $camposSensibles = ['password', 'session_token', 'token', 'secret'];

        foreach ($camposSensibles as $campo) {
            if (isset($datos[$campo])) {
                $datos[$campo] = '***OCULTO***';
            }
        }

        return $datos;
    }

    /**
     * Obtiene el historial de auditoría
     */
    public function getHistorial(array $filtros = [], int $limit = 100): array
    {
        return $this->auditoriaModel->getHistorial($filtros, $limit);
    }

    /**
     * Obtiene las acciones de un módulo específico
     */
    public function getAccionesModulo(string $modulo, int $limit = 50): array
    {
        return $this->auditoriaModel->getAccionesModulo($modulo, $limit);
    }
}
