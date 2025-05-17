<?php

require("../../model/periodo.php");

if(isset($_POST)){//si el js me manda yo hago:
    $DESCRIPTION =  mb_strtoupper($_POST["DESCRIPTION"]);
    $T_INTERNSHIPS_CODE =  $_POST["T_INTERNSHIPS_CODE"]; 
    $START_DATE =  $_POST["START_DATE"];
    $END_DATE =  $_POST["END_DATE"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $usuario->insertarUsuario($DESCRIPTION,$T_INTERNSHIPS_CODE,$START_DATE,$END_DATE);
    echo "Nuevo Periodo añadido";//le respondo a js
}
//guia de uso para insertarUsuario($nombre, $codigo, $status)
?>