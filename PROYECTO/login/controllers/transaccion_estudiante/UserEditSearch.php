<?php
require("../../model/model_transaccion_estudiante/UserModel.php");
if(isset($_POST)){//si js me manda datos yo hago:
    $id = $_POST["id"];//guardo lo q mando

    // incluir la clase Usuario
    require_once("../../model/model_transaccion_estudiante/UserModel.php");

    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método para buscar un usuario por su codigo
    $json = $usuario->searcheditUsuario($id);

    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
}
?>
