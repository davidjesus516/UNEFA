<?php
// Asegúrate que no haya espacios ni saltos de línea antes de esta línea
header('Content-Type: application/json');

// Configuración para desarrollo (quitar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ruta correcta a tu modelo (verifica la ruta absoluta)
require_once __DIR__ . '/../../model/periodo.php';

try {
    // Verificar método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido', 405);
    }

    // Verificar datos recibidos
    if (!isset($_POST['PERIOD_ID'], $_POST['newStatus'])) {
        throw new Exception('Datos incompletos', 400);
    }

    // Validar y limpiar datos
    $PERIOD_ID = filter_input(INPUT_POST, 'PERIOD_ID', FILTER_VALIDATE_INT);
    $newStatus = filter_input(INPUT_POST, 'newStatus', FILTER_VALIDATE_INT);

    if (!$PERIOD_ID || !$newStatus) {
        throw new Exception('Datos inválidos', 400);
    }

    // Validar estado permitido
    if ($newStatus < 1 || $newStatus > 3) {
        throw new Exception('Estado no válido', 400);
    }

    // Instanciar modelo
    $periodo = new Periodo();

    // Cambiar estado
    $result = $periodo->cambiarEstadoPeriodo($PERIOD_ID, $newStatus);

    if ($result !== true) {
        throw new Exception($result ?: 'Error al cambiar estado');
    }

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Estado actualizado correctamente',
        'newStatus' => $newStatus
    ]);

} catch (Exception $e) {
    // Manejo de errores
    http_response_code($e->getCode() >= 400 ? $e->getCode() : 500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'errorCode' => $e->getCode() ?: 500
    ]);
}

exit; // No incluir ?> para evitar espacios en blanco