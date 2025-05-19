<?php
// incluir la clase Usuario
require_once("../../model/estudiante.php");

if(isset($_POST)){// si js me manda datos yo hago:
    $id = $_POST["id"];//guardo lo que mando
    $Estatus = 0;
    // crear una instancia de la clase Usuario
    $usuario = new Student();
    // llamar al método eliminarUsuario() para eliminar un nuevo Usuario
    $usuario->deleteStudent($id);
    echo "Usuario Eliminado";//le respondo a js
}
?>