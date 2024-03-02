<?php
require("../../model/model_profesion/UserModel.php");
if(isset($_POST)){//si js me manda datos yo hago:
    $codigo = $_POST["id"];//guardo lo q mando
    $estatus = 0;

    // incluir la clase Usuario
    require_once("../../model/model_profesion/UserModel.php");

    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método para buscar un usuario por su codigo
    $json = $usuario->searcheditUsuario($codigo);

    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
}
?>
