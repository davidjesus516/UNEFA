<?php 

// incluir la clase Usuario
require_once("../../model/model_transaccion_estudiante/EmpresaModel.php");
$rif = $_POST["search"];

// crear una instancia de la clase Usuario
$usuario = new Empresa();

// llamar al método listarUsuario() para que me retorne todo lo que tiene la bd
$json = $usuario->listarEmpresa($rif);

// convertir el resultado a formato JSON
$jsonstring = json_encode($json);

// imprimir el resultado en formato JSON
echo $jsonstring;
?>