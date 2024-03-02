<?php

require("../../model/model_transaccion_estudiante/UserModel.php");

if(isset($_POST)){
    $id = $_POST["id"];//guardo los datos que envio
    $cedula =  $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $genero = $_POST["genero"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $rif = $_POST["rif"];
    $direccion = $_POST["direccion"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($id,$cedula,$nombre,$apellido,$genero,$fecha_nacimiento,$rif,$direccion);
    echo "Usuario Editado";//le respondo al js
}
?>