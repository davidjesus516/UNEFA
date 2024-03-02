<?php

require_once("../../model/tutor_a.php");

if(isset($_POST)){
    $id = $_POST["id"];//guardo los datos que envio
    $cedula =  $_POST["cedula"];
    $nacionalidad =  mb_strtoupper($_POST["nacionalidad"]);
    $nombre = mb_strtoupper($_POST["nombre"]);
    $apellido = mb_strtoupper($_POST["apellido"]);
    $genero = ($_POST["genero"]);
    $tlf = $_POST["tlf"];
    $e_mail =  mb_strtoupper($_POST["e_mail"]);
    $carrera =  $_POST["carrera"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($id,$cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$carrera);
    echo "Usuario Editado";//le respondo al js
}
?>