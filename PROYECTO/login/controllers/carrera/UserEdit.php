<?php

require("../..\model\carrera.php");

if(isset($_POST)){
    $Id_Carrera = $_POST["Id_Carrera"];
    $Codigo = $_POST["Codigo"];
    $Nombre_Carrera =  $_POST["Nombre_Carrera"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($Id_Carrera,$Nombre_Carrera,$Codigo);
    echo "Usuario Editado";//le respondo al js
}
?>