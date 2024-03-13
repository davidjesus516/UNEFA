<?php

require("../../model/tutor_inst.php");

if(isset($_POST)){
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
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($id,$cedula,$nombre,$apellido,$genero,$fecha_nacimiento,$rif,$direccion,$profesion,$empresa);
    echo "Usuario Editado";//le respondo al js
}
?>