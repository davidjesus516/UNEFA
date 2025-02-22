<?php
if (isset($_POST['Codigo']))
{
    $Codigo = $_POST["Codigo"];

// incluir la clase Usuario
require_once("../../model/carrera.php");

// crear una instancia de la clase Usuario
$usuario = new Usuario();

// llamar al método buscarUsuario() para buscar un usuario por su cédula
$json = $usuario->buscarCodigo($Codigo);

    if ($json !== null && $json !== 0) {
    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
}
}

if (isset($_POST['Nombre_Carrera'])){ 
    $Nombre_Carrera = $_POST["Nombre_Carrera"];
    // incluir la clase Usuario
    require_once("../../model/carrera.php");
    
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método buscarUsuario() para buscar un usuario por su cédula
    $json = $usuario->buscarNombre($Nombre_Carrera);
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
