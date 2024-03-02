<?php

require_once("../../model/tutor_a.php");

if(isset($_POST)){//si el js me manda yo hago:
    $id = $_POST["id"];//guardo los datos que envio
    $cedula =  $_POST["cedula"];
    $nacionalidad =  mb_strtoupper($_POST["nacionalidad"]);
    $nombre = mb_strtoupper($_POST["nombre"]);
    $apellido = mb_strtoupper($_POST["apellido"]);
    $genero = ($_POST["genero"]);
    $tlf = $_POST["tlf"];
    $e_mail =  mb_strtoupper($_POST["e_mail"]);
    $carrera =  $_POST["carrera"];
    $estatus = 1;

    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // Llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->insertarUsuario($cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$carrera);
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