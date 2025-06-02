<?php
require_once("../../model/periodo.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $PERIOD_ID = $_POST["PERIOD_ID"] ?? null;

    if ($PERIOD_ID) {
        $periodo = new Periodo();
        $resultado = $periodo->eliminarPeriodo($PERIOD_ID);
        echo $resultado ? 1 : 0;
    } else {
        echo "ID no proporcionado";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Método no permitido";
}
