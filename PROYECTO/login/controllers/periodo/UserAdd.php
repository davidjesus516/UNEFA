<?php

require("../../model/periodo.php");

if(isset($_POST)){//si el js me manda yo hago:
    $nombre =  $_POST["nombre"];
    $estatus = $_POST["estatus"];
    if ($estatus == 1) {
        $desactivar = new Usuario();
        $desactivar->desactivarLapsos();
        echo "se desactivo los demas usuarios";
    }
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $usuario->insertarUsuario($nombre,$estatus);
    echo "Nuevo usuario añadido";//le respondo a js
}
?>