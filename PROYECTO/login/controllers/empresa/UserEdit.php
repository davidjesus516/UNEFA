<?php

require("../../model/model_empresa/UserModel.php");

if(isset($_POST)){
    $id = $_POST["id"];
    $rif =  $_POST["rif"] . $_POST["rif2"];
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $nombre_contacto = $_POST["nombre_contacto"];
    $telefono_contacto = $_POST["telefono_contacto"] . $_POST["telefono_contacto2"];
    $telefono_empresa = $_POST["telefono_empresa"] . $_POST["telefono_empresa2"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($id, $rif, $nombre, $direccion, $nombre_contacto, $telefono_contacto, $telefono_empresa);
    echo "Usuario Editado";//le respondo al js
}
?>