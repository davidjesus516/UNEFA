<?php
require_once '../../model/periodo.php';

$model = new Periodo();
$datos = $model->listarActivos(); // crearemos este método para traer de la tabla segun el status

echo json_encode($datos);
?>
