<?php
require("../..\model\carrera.php");
if(isset($_POST)){//si js me manda datos yo hago:
    $Id_Carrera = $_POST["Id_Carrera"];//guardo lo q mando
    $estatus = 0;

    // incluir la clase Usuario
    require_once("../../model\carrera.php");

    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método para buscar un usuario por su codigo
    $json = $usuario->searcheditUsuario($Id_Carrera);

    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
}
?>
