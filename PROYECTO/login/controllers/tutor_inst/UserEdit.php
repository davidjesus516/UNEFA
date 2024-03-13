<?php

require("../../model/tutor_inst.php");

if(isset($_POST)){
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
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($id,$cedula,$nacionalidad,$nombre,$apellido,$genero,$tlf,$e_mail,$cargo,$profesion,$empresa);
    echo "Usuario Editado";//le respondo al js
}
?>