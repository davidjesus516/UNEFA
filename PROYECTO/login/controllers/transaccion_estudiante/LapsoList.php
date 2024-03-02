<?php 

// incluir la clase Usuario
require_once("../../model/model_transaccion_estudiante/LapsoModel.php");

// crear una instancia de la clase Usuario
$usuario = new Lapso();

// llamar al método listarUsuario() para que me retorne todo lo que tiene la bd
$json = $usuario->listarLapso();

// convertir el resultado a formato JSON
$jsonstring = json_encode($json);

// imprimir el resultado en formato JSON
echo $jsonstring;
?>