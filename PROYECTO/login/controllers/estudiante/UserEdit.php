<?php

require("../../model/estudiante.php");

if(isset($_POST)){
    $id = $_POST["id"];//guardo los datos que envio
    $cedula =  $_POST["cedula"];
    $nacionalidad = mb_strtoupper($_POST["nacionalidad"]);  
    $nombre = mb_strtoupper($_POST["nombre"]);
    $apellido = mb_strtoupper($_POST["apellido"]);
    $genero = mb_strtoupper($_POST["genero"]);   
    $tlf = $_POST["tlf"];  
    $e_mail = mb_strtoupper( $_POST["e_mail"]);  
    $rango_militar = $_POST["rango_militar"];  
    $carrera = $_POST["carrera"];  
    $turno = $_POST["turno"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($id,$cedula,$nacionalidad,$nombre,$apellido,$genero,$tlf,$e_mail,$rango_militar,$carrera,$turno);
    echo "Usuario Editado";//le respondo al js
}
?>