<?php

require_once("../../model/tutor_a.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $id = $_POST["id"];//guardo lo que mando
    $estatus = 0;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método cambiarEstatus() para eliminar un nuevo Usuario
    $usuario->cambiarEstatus($id,$estatus);
    echo "Usuario Eliminado";//le respondo a js
}
?>