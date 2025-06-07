<?php 

// incluir la clase Usuario
require_once("../../model/Tipo_Practica.php");

// crear una instancia de la clase Usuario
$usuario = new Tipo_Practica();

// llamar al método listarUsuario() para que me retorne todo lo que tiene la bd
$json = $usuario->listar_a();

// convertir el resultado a formato JSON
$jsonstring = json_encode($json);

// imprimir el resultado en formato JSON
echo $jsonstring;
?>