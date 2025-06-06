<?php

require("../../model/carrera.php");

if(isset($_POST)){//si el js me manda yo hago:
    $Nombre_Carrera =  mb_strtoupper($_POST["Nombre_Carrera"]);
    $Codigo =  $_POST["Codigo"];
    $MINIMUM_GRADE =  $_POST["MINIMUM_GRADE"];
    $CAREER_INTERNSHIP_TYPES =  $_POST["CAREER_INTERNSHIP_TYPES"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    if($usuario->insertarUsuario($Nombre_Carrera,$Codigo,$MINIMUM_GRADE,$CAREER_INTERNSHIP_TYPES)){
        $row = array(
        'message' => '    
        <dialog id="message">
        <h2>Registro Completado</h2>
        <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        <div class="success-checkmark">
        <div class="check-icon">
            <span class="icon-line line-tip"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
        </div>
        </div>
        </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
}else{
    $row = array(
                'message' =>'     
                <dialog id="message">
            <h2>Ha ocurrido un error en el registro.</h2>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
        <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
            </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
}}
//guia de uso para insertarUsuario($nombre, $codigo, $status)
?>