<?php

require("../../model/tutor_inst.php");

if(isset($_POST)){//si el js me manda yo hago:
    $id = $_POST["id"];//guardo los datos que envio
    $cedula =  $_POST["cedula"];
    $nacionalidad =  $_POST["nacionalidad"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $genero = $_POST["genero"];
    $tlf = $_POST["tlf"];
    $cargo = $_POST["cargo"];
    $e_mail = $_POST["email"];
    $profesion = $_POST["profesion"];
    $empresa = $_POST["empresa"];
    $estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->insertarUsuario($cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$cargo,$profesion,$empresa);
    if ($result === true) {
        echo 1;
        return $result;
    } else {
        // Mostrar mensaje de error en el frontend
        echo 0;
        return $result;
    }
}
?>