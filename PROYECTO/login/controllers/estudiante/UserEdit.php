<?php

require("../../model/estudiante.php");

if(isset($_POST)){
    $Id_Estudiantes =  ($_POST["Id_Estudiantes"]);
    $Ci_Estudiantes =  ($_POST["Ci_Estudiantes"]);
    $Primer_Nombre = mb_strtoupper($_POST["Primer_Nombre"]);
    $Segundo_Nombre = mb_strtoupper($_POST["Segundo_Nombre"]);
    $Primer_Apellido = mb_strtoupper($_POST["Primer_Apellido"]);
    $Segundo_Apellido = mb_strtoupper($_POST["Segundo_Apellido"]);
    $Telefono = $_POST["Telefono"];  
    $Correo = mb_strtoupper( $_POST["Correo"]);  
    $Id_Matricula = $_POST["Id_Matricula"];  
    $IdPracticas_Profesionales = mb_strtoupper($_POST["IdPracticas_Profesionales"]);   
    $Estatus = 1;
    // crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método editarUsuario() para editar el Usuario Por Su Cedula
    $usuario->editarUsuario($Ci_Estudiantes,
    $Primer_Nombre,
    $Segundo_Nombre,
    $Primer_Apellido,
    $Segundo_Apellido,
    $Telefono,
    $Correo,
    $Id_Matricula,
    $IdPracticas_Profesionales, 
    $Estatus);
    echo "Usuario Editado";//le respondo al js
}
?>