<?php
require("../../model/model_empresa/UserModel.php");
$rif = $_POST["search"];

// incluir la clase Usuario
require_once("../../model/model_empresa/UserModel.php");

// crear una instancia de la clase Usuario
$usuario = new Usuario();

// llamar al método buscarUsuario() para buscar un usuario por su cédula
$json = $usuario->buscarUsuario("$rif");

// convertir el resultado a formato JSON
$jsonstring = json_encode($json);

// imprimir el resultado en formato JSON
echo $jsonstring;
?>
