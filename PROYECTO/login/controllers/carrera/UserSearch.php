<?php
if (isset($_POST['codigo']))
{
    $codigo = $_POST["codigo"];

// incluir la clase Usuario
require_once("../../model/carrera.php");

// crear una instancia de la clase Usuario
$usuario = new Usuario();

// llamar al método buscarUsuario() para buscar un usuario por su cédula
$json = $usuario->buscarCodigo("$codigo");

    if ($json !== null && $json !== 0) {
    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
}
}

if (isset($_POST['nombre'])){ 
    $codigo = $_POST["nombre"];
    // incluir la clase Usuario
    require_once("../../model\carrera.php");
    
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método buscarUsuario() para buscar un usuario por su cédula
    $json = $usuario->buscarNombre("$codigo");
    // verificar si la respuesta es nula o 0
    if ($json !== null && $json !== 0) {
    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
    }
  // si la respuesta es nula o 0, no enviamos nada
}
?>
