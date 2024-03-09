<?php

require("../../model/periodo.php");

if(isset($_POST)){
    $codigo = $_POST["codigo"];
    $nombre =  $_POST["nombre"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($codigo,$nombre);
    echo "Usuario Editado";//le respondo al js
}
?>