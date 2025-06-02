<?php
require_once '../../model/periodo.php';

// Verifica si todos los datos necesarios están presentes
if (
    isset($_POST['ACADEMIC_LAPSE'], $_POST['T_INTERNSHIPS_CODE'], $_POST['START_DATE'], $_POST['END_DATE'], $_POST['PERIOD_STATUS'], $_POST['STATUS'])
) {
    $ACADEMIC_LAPSE = $_POST['ACADEMIC_LAPSE'];
    $T_INTERNSHIPS_CODE = $_POST['T_INTERNSHIPS_CODE'];
    $START_DATE = $_POST['START_DATE'];
    $END_DATE = $_POST['END_DATE'];
    $PERIOD_STATUS = $_POST['PERIOD_STATUS'];
    $STATUS = $_POST['STATUS'];

    $periodo = new Periodo();

    // Verificamos si ya existe el mismo ACADEMIC_LAPSE para evitar duplicados
    $existe = $periodo->buscarNombre($ACADEMIC_LAPSE);
    if (count($existe) > 0) {
        echo 0; // Ya existe
        exit;
    }

    $insertado = $periodo->insertarPeriodo($ACADEMIC_LAPSE, $T_INTERNSHIPS_CODE, $START_DATE, $END_DATE, $PERIOD_STATUS, $STATUS);

    if ($insertado) {
        echo 1; // Éxito
    } else {
        echo -1; // Error inesperado
    }
} else {
    echo 'Faltan datos obligatorios';
}
?>
