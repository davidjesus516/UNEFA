<?php

require("../../model/estudiante.php");

if(isset($_POST)){//si el js me manda yo hago:
    
    $cedula =  ($_POST["cedula"]);
    $nacionalidad = mb_strtoupper($_POST["nacionalidad"]);  
    $nombre = mb_strtoupper($_POST["nombre"]);
    $apellido = mb_strtoupper($_POST["apellido"]);
    $genero = mb_strtoupper($_POST["genero"]);   
    $tlf = $_POST["tlf"];  
    $e_mail = mb_strtoupper( $_POST["e_mail"]);  
    $rango_militar = mb_strtoupper($_POST["rango_militar"]);  
    $carrera = $_POST["carrera"];  
    $turno = mb_strtoupper($_POST["turno"]);   
    $estatus = 1;
    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->insertarUsuario($cedula,$nacionalidad,$nombre,$apellido,$genero,$tlf,$e_mail,$rango_militar,$carrera,$turno,$estatus);
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