<?php

require("../../model/lapso.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $codigo = $_POST["id"];//guardo lo que mando
    $estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método eliminarUsuario() para eliminar un nuevo Usuario
    $usuario->activarUsuario($estatus,$codigo);
    echo "Usuario Eliminado";//le respondo a js
}
?>