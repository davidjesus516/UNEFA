<?php
require("../../model/estudiante.php");
if(isset($_POST)){//si js me manda datos yo hago:
    $id = $_POST["id"];//guardo lo q mando

    // incluir la clase Usuario
    require_once("../../model/estudiante.php");

    // crear una instancia de la clase Usuario
    $usuario = new Student();

    // llamar al método para buscar un usuario por su codigo
    $json = $usuario->getStudentbyId($id);

    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
}
?>
