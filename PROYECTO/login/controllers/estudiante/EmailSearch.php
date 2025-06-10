<?php
$email = $_POST["email"];
$id = isset($_POST["id"]) ? $_POST["id"] : null;
$edit = isset($_POST["edit"]) ? $_POST["edit"] : false;

// incluir la clase Student
require_once("../../model/estudiante.php");

// crear una instancia de la clase Student
$usuario = new Student();

// llamar al método para buscar por correo
if ($edit && $id) {
    // Si está editando, buscar el correo en otros registros
    $json = $usuario->getStudentByEmailExceptId($email, $id);
} else {
    // Si es registro nuevo, buscar el correo en toda la tabla
    $json = $usuario->getStudentByEmail($email);
}

// verificar si la respuesta es nula o 0
if ($json !== null && $json !== 0) {
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
// si la respuesta es nula o 0, no enviamos nada
?>