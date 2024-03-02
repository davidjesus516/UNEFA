<?php

require("../..\model\carrera.php");

if(isset($_POST)){//si el js me manda yo hago:
    $nombre =  $_POST["nombre"];
    $codigo =  $_POST["codigo"];
    $estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $usuario->insertarUsuario($nombre,$codigo,$estatus);
    echo "Nuevo usuario añadido";//le respondo a js
}
//guia de uso para insertarUsuario($nombre, $codigo, $status)
?>