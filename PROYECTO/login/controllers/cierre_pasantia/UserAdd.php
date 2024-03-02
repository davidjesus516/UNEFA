<?php

require("../../model/model_cierre_pasantia/UserModel.php");

if(isset($_POST)){//si el js me manda yo hago:
    $lapso = $_POST["lapso"];//guardo los datos que envio
    $carrera =  $_POST["carrera"];
    $estudiante = $_POST["estudiante"];
    $empresa = $_POST["empresa"];
    $docente = $_POST["docente"];
    $tutor = $_POST["tutor"];
    $estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $usuario->insertarUsuario($lapso,$carrera,$estudiante,$empresa,$docente,$tutor,$estatus);
    echo "Nuevo usuario añadido";//le respondo a js
}
?>