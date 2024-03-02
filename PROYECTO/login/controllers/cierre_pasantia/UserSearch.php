<?php
require_once("../../model/model_cierre_pasantia/UserModel.php");

if ($_POST["search"]==!null) {
    $id = $_POST["search"];

    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método filtrarInscripcion() para buscar una inscripción por su id
    $json = $usuario->filtrarInscripcion($id);

    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
} else {
    // Si el valor de 'search' no está definido, no hacemos nada y detenemos la ejecución del controlador
    
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método listarUsuario() para que me retorne todo lo que tiene la bd
    $json = $usuario->listarUsuarios();

    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;

}
?>