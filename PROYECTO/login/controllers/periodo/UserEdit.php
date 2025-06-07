<?php
require_once '../../model/periodo.php';

header('Content-Type: application/json');

try {
    // Validación de datos obligatorios
    if (!isset($_POST['PERIOD_ID'], $_POST['DESCRIPTION'], $_POST['START_DATE'], $_POST['END_DATE'])) {
        throw new Exception('Faltan datos obligatorios para la edición');
    }

    $periodo = new Periodo();

    // Verificar duplicados excluyendo el registro actual
    $existe = $periodo->buscarNombre($_POST['DESCRIPTION'], $_POST['PERIOD_ID']);
    if (count($existe) > 0) {
        throw new Exception('Ya existe otro período con la misma descripción (año y turno)');
    }

    // Validar fechas
    $startDate = new DateTime($_POST['START_DATE']);
    $endDate = new DateTime($_POST['END_DATE']);
    
    if ($startDate >= $endDate) {
        throw new Exception('La fecha de inicio debe ser anterior a la fecha de fin');
    }

    // Actualizar el período
    $resultado = $periodo->editarPeriodo(
        $_POST['PERIOD_ID'],
        $_POST['DESCRIPTION'],
        $_POST['START_DATE'],
        $_POST['END_DATE'],
        $_POST['PERIOD_STATUS'] ?? 1,
        $_POST['STATUS'] ?? 1
    );

    if ($resultado === true) {
        echo json_encode([
            'success' => true,
            'message' => 'Período académico actualizado exitosamente'
        ]);
    } else {
        throw new Exception($resultado !== false ? $resultado : 'Error desconocido al actualizar');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}