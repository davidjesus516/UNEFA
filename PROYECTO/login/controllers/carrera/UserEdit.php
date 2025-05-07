<?php

require("../..\model\carrera.php");

if(isset($_POST)){
    $Id_Carrera = $_POST["Id_Carrera"];
    $Codigo = $_POST["Codigo"];
    $Nombre_Carrera = mb_strtoupper($_POST["Nombre_Carrera"]);
    $MINIMUM_GRADE = $_POST["MINIMUM_GRADE"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($Id_Carrera,$Nombre_Carrera,$Codigo,$MINIMUM_GRADE);
    echo "Usuario Editado";//le respondo al js
}
?>