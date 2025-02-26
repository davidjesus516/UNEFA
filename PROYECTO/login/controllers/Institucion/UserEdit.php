<?php

require("../../model/Institucion.php");

if(isset($_POST)){
    $id = $_POST["id"];
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
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editar($id, $l_rif, $rif, $nombre, $direccion, $telefono_empresa,$n_pasantes,$carrera,$estatus);
    echo "Usuario Editado";//le respondo al js
}
?>