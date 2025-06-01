<?php
require_once '../../model/periodo.php';

$model = new Periodo();
$datos = $model->listar(); // crearemos este método para traer TODO

echo json_encode($datos);
?>
