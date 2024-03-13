<?php

require("../../model/empresa.php");

if(isset($_POST)){//si el js me manda yo hago:
    $rif = $_POST["rif"] . $_POST["rif2"];//guardo los datos que envio
    $nombre =  $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $nombre_contacto = $_POST["nombre_contacto"];
    $telefono_contacto = $_POST["telefono_contacto"] . $_POST["telefono_contacto2"];
    $telefono_empresa = $_POST["telefono_empresa"] . $_POST["telefono_empresa2"];
    $estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->insertarUsuario($rif,$nombre,$direccion,$nombre_contacto,$telefono_contacto,$telefono_empresa,$estatus);
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