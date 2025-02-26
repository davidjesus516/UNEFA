<?php
// incluir la clase Usuario
require_once("../../model/estudiante.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $Ci_Estudiantes = $_POST["Id_Estudiantes"];//guardo lo que mando
    $Estatus = 0;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método eliminarUsuario() para eliminar un nuevo Usuario
    $usuario->eliminarUsuario($Ci_Estudiantes,$Estatus);
    echo "Usuario Eliminado";//le respondo a js
}
?>