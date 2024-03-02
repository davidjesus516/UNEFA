<?php

require("../..\model\carrera.php");

if(isset($_POST)){
    $ID = $_POST["id"];
    $codigo = $_POST["codigo"];
    $nombre =  $_POST["nombre"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($ID,$codigo,$nombre,1);
    echo "Usuario Editado";//le respondo al js
}
//editarUsuario($ID, $nombre , $codigo, $status)
?>