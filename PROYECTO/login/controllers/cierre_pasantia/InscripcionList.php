<?php 

// incluir la clase Usuario
require_once("../../model/model_cierre_pasantia/InscripcionModel.php");
$codigo = $_POST["search"];

// crear una instancia de la clase Usuario
$usuario = new Inscripcion();

// llamar al método listarUsuario() para que me retorne todo lo que tiene la bd
$json = $usuario->listarInscripcion($codigo);

// convertir el resultado a formato JSON
$jsonstring = json_encode($json);

// imprimir el resultado en formato JSON
echo $jsonstring;
?>