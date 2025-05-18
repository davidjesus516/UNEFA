<?php

require("../..\model\carrera.php");

if(isset($_POST)){
    $Id_Carrera = $_POST["Id_Carrera"];
    $Codigo = $_POST["Codigo"];
    $Nombre_Carrera = mb_strtoupper($_POST["Nombre_Carrera"]);
    $MINIMUM_GRADE = $_POST["MINIMUM_GRADE"];
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    if($usuario->editarUsuario($Id_Carrera,$Nombre_Carrera,$Codigo,$MINIMUM_GRADE)){
    $row = array(
        'message' => '    
        <dialog id="message">
        <h2>Registro Editado</h2>
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
    echo $jsonstring;}
}
?>