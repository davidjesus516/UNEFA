<?php
require_once '../../model/periodo.php';

if (!isset($_POST['PERIOD_ID'])) {
    echo json_encode([]);
    exit;
}

$periodo = new Periodo();
$result = $periodo->obtenerPorID($_POST['PERIOD_ID']);

echo json_encode($result);