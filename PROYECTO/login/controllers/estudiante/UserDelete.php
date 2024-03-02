<?php
// incluir la clase Usuario
require_once("../../model/estudiante.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $cedula = $_POST["id"];//guardo lo que mando
    $estatus = 0;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método eliminarUsuario() para eliminar un nuevo Usuario
    $usuario->eliminarUsuario($cedula,$estatus);
    echo "Usuario Eliminado";//le respondo a js
}
?>