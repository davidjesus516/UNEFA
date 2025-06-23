<?php

if (!defined('ROLES_PHP_INCLUDED')) {
    define('ROLES_PHP_INCLUDED', true);

    /**
     * Devuelve un array de selectores CSS para los elementos que deben ocultarse según el rol del usuario.
     *
     * @param int $roleId El ID del rol del usuario.
     * @return array Un array de selectores CSS.
     */
    function getSelectorsToHideByRole($roleId)
    {
        // Define los selectores a ocultar para el rol ASISTENTE.
        // Estos serán también los selectores por defecto para roles no reconocidos o nulos.
        $assistantRestrictions = [
            // --- Elementos de Acción Generales ---
            '.primary',                 // Botones "Nuevo", "Agregar"
            '.formulario__btn',         // Botones "Guardar" en formularios
            '.task-edit',               // Botones de editar en tablas
            '.task-delete',             // Botones de eliminar/desactivar en tablas
            '.task-restore',            // Botones de restaurar/activar en tablas
            '.task-note',               // Botones "Culminar"
            '.botonera-modal-large',    // Contenedor de botones en modales grandes (ej. Seguimiento)
            '.task-status',             // Botones de cambio de estado (ej. "Completado")
            '.status-completed'         // Botones específicos de estado "Completado"
        ];

        // Rol 1 (ADMINISTRADOR) tiene acceso a todo.
        if ($roleId == 1) {
            return [];
        }

        // Para el Rol 2 (ASISTENTE) o cualquier otro rol no reconocido/nulo,
        // aplicamos las restricciones del asistente por seguridad.
        return $assistantRestrictions;
    }
}