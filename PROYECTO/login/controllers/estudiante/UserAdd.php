<?php

require("../../model/estudiante.php");

if(isset($_POST)){//si el js me manda yo hago:
    
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
    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->insertarUsuario
    ($Ci_Estudiantes,
    $Primer_Nombre,
    $Segundo_Nombre,
    $Primer_Apellido,
    $Segundo_Apellido,
    $Telefono,
    $Correo,
    $Id_Matricula,
    $IdPracticas_Profesionales, 
    $Estatus);
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