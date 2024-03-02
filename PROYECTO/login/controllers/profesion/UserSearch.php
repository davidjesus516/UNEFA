<?php
require("../../model/model_profesion/UserModel.php");
$codigo = $_POST["search"];

// incluir la clase Usuario
require_once("../../model/model_profesion/UserModel.php");

// crear una instancia de la clase Usuario
$usuario = new Usuario();

// llamar al método buscarUsuario() para buscar un usuario por su cédula
$json = $usuario->buscarUsuario("$codigo");

// convertir el resultado a formato JSON
$jsonstring = json_encode($json);

// imprimir el resultado en formato JSON
echo $jsonstring;
?>
