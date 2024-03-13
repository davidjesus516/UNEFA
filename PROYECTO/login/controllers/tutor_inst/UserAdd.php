<?php

require("../../model/tutor_inst.php");

if(isset($_POST)){//si el js me manda yo hago:
    $id = $_POST["id"];//guardo los datos que envio
    $cedula =  $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $genero = $_POST["genero"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $rif = $_POST["rif"] . $_POST["rif2"];
    $direccion = $_POST["direccion"];
    $profesion = $_POST["profesion"];
    $empresa = $_POST["empresa"];
    $estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->insertarUsuario($cedula,$nombre,$apellido,$genero,$fecha_nacimiento,$rif,$direccion,$profesion,$empresa,$estatus);
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