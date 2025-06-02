<?php
// 🔐 Iniciar sesión y cargar modelo
session_start();
require_once('../../model/periodo.php');

// 🛡️ Validar que se recibió el ID por POST
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $periodo = new Periodo();
        $resultado = $periodo->obtenerPorID($id); // retorna array

        // ✅ Retornar como JSON
        header('Content-Type: application/json');
        echo json_encode($resultado); // debe ser un array (incluso si es de 1 registro)
    } catch (Exception $e) {
        // ⚠️ En caso de error interno
        http_response_code(500);
        echo json_encode([
            'error' => 'Error en el servidor: ' . $e->getMessage()
        ]);
    }
} else {
    // ❌ No se recibió un ID válido
    http_response_code(400);
    echo json_encode([
        'error' => 'Parámetro ID inválido o no enviado'
    ]);
}
