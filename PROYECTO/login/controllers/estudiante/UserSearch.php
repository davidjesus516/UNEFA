<?php
$cedula = $_POST["search"];
// incluir la clase Usuario
require_once("../../model/estudiante.php");

// crear una instancia de la clase Usuario
$usuario = new Student();

// llamar al método getStudentbyCI() para buscar un usuario por su cédula
$json = $usuario->getStudentbyCI($cedula);

// verificar si la respuesta es nula o 0
if ($json !== null && $json !== 0) {
  // convertir el resultado a formato JSON
  $jsonstring = json_encode($json);

  // imprimir el resultado en formato JSON
  echo $jsonstring;
}
// si la respuesta es nula o 0, no enviamos nada

?>
