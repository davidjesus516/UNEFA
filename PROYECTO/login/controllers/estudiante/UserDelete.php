<?php
// incluir la clase Usuario
require_once("../../model/estudiante.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $Id_Estudiantes = $_POST["Id_Estudiantes"];//guardo lo que mando
    $Estatus = 0;
    // crear una instancia de la clase Usuario
    $usuario = new Student();
    // llamar al método eliminarUsuario() para eliminar un nuevo Usuario
    $usuario->deleteStudent($Id_Estudiantes);
    echo "Usuario Eliminado";//le respondo a js
}
?>