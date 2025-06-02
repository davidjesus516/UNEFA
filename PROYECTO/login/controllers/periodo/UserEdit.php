<?php
session_start();
require_once('../../model/periodo.php');

// Verifica que todos los campos estén presentes
if (
    isset($_POST['PERIOD_ID']) &&
    isset($_POST['ACADEMIC_LAPSE']) &&
    isset($_POST['T_INTERNSHIPS_CODE']) &&
    isset($_POST['START_DATE']) &&
    isset($_POST['END_DATE']) &&
    isset($_POST['PERIOD_STATUS']) &&
    isset($_POST['STATUS'])
) {
    $PERIOD_ID = $_POST['PERIOD_ID'];
    $ACADEMIC_LAPSE = trim($_POST['ACADEMIC_LAPSE']);
    $T_INTERNSHIPS_CODE = trim($_POST['T_INTERNSHIPS_CODE']);
    $START_DATE = $_POST['START_DATE'];
    $END_DATE = $_POST['END_DATE'];
    $PERIOD_STATUS = trim($_POST['PERIOD_STATUS']);
    $STATUS = trim($_POST['STATUS']);

    // Validación básica (puedes extender según tus necesidades)
    if (!is_numeric($PERIOD_ID)) {
        echo "ID inválido";
        exit;
    }

    $periodo = new Periodo();
    $resultado = $periodo->editarPeriodo(
        $PERIOD_ID,
        $ACADEMIC_LAPSE,
        $T_INTERNSHIPS_CODE,
        $START_DATE,
        $END_DATE,
        $PERIOD_STATUS,
        $STATUS
    );

    if ($resultado) {
        echo 1; // Éxito
    } else {
        echo 0; // Error o no se editó
    }
} else {
    echo "Faltan datos requeridos";
}
