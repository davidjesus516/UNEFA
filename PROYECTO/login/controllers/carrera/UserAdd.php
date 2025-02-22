<?php

require("..\..\model\carrera.php");

if(isset($_POST)){//si el js me manda yo hago:
    $Nombre_Carrera =  $_POST["Nombre_Carrera"];
    $Codigo =  $_POST["Codigo"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $usuario->insertarUsuario($Nombre_Carrera,$Codigo);
    echo "Nuevo usuario añadido";//le respondo a js
}
//guia de uso para insertarUsuario($nombre, $codigo, $status)
?>