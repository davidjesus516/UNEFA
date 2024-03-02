<?php 

// incluir la clase Usuario
require_once("../../model/model_cierre_pasantia/TutorModel.php");
$cedula = $_POST["search"];

// crear una instancia de la clase Usuario
$usuario = new Tutor();

// llamar al método listarUsuario() para que me retorne todo lo que tiene la bd
$json = $usuario->listarTutor($cedula);

// convertir el resultado a formato JSON
$jsonstring = json_encode($json);

// imprimir el resultado en formato JSON
echo $jsonstring;
?>