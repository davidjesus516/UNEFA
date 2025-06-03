<?php
require("../../model/periodo.php");
if(isset($_POST)){//si js me manda datos yo hago:
    $codigo = $_POST["PERIOD_ID"];//guardo lo q mando
    $estatus = 0;

    // incluir la clase Usuario
    require_once("../../model/periodo.php");

    // crear una instancia de la clase Usuario
    $usuario = new Periodo();

    // llamar al método para buscar un usuario por su codigo
    $json = $usuario->obtenerPorID($codigo);

    // convertir el resultado a formato JSON
    $jsonstring = json_encode($json);

    // imprimir el resultado en formato JSON
    echo $jsonstring;
}
?>
