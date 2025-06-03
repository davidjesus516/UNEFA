<?php
// ⏱️ Inicialización de sesión y zona horaria
session_start();
date_default_timezone_set("America/Caracas");

// 🔗 Importar el modelo
require_once("../model/periodo.php");

// 📥 Validar método HTTP
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 📦 Obtener el ID desde el POST
    $PERIOD_ID = $_POST["PERIOD_ID"] ?? null;

    if (!is_null($PERIOD_ID) && is_numeric($PERIOD_ID)) {
        // 🧠 Instanciar el modelo
        $periodo = new Periodo();

        // 🧨 Ejecutar la eliminación lógica (STATUS = 0)
        $resultado = $periodo->eliminarPeriodo($PERIOD_ID);

        // 📤 Devolver respuesta
        echo $resultado ? 1 : 0;
    } else {
        http_response_code(400); // Bad Request
        echo "ID inválido o no proporcionado";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Método no permitido";
}
