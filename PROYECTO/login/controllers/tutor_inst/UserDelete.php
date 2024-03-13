<?php

require("../../model/tutor_inst.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $cedula = $_POST["id"];//guardo lo que mando
    $estatus = 0;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método eliminarUsuario() para eliminar un nuevo Usuario
    $usuario->cambiarEstatus($cedula,$estatus);
    echo "Usuario Eliminado";//le respondo a js
}
?>