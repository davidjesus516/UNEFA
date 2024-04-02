<?php

require("../../model/empresa.php");

if(isset($_POST)){//si el js me manda yo hago:
    $nombre =  $_POST["nombre"];
    $l_rif =  $_POST["l_rif"];
    $rif =  $_POST["rif"];
    $direccion =  $_POST["direccion"];
    $telefono_empresa =  $_POST["telefono"];
    $n_pasantes =  $_POST["n_pasantes"];
    $carrera =  $_POST["carrera"];
    $estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->insertar($l_rif,$rif,$nombre,$direccion,$telefono_empresa,$n_pasantes,$carrera,$estatus);
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