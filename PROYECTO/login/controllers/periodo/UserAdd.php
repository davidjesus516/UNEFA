<?php
require_once '../../model/periodo.php';

try {
    // Verifica datos obligatorios
    if (!isset($_POST['DESCRIPTION'], $_POST['START_DATE'], $_POST['END_DATE'])) {
        throw new Exception('Faltan datos obligatorios');
    }

    $periodo = new Periodo();

    // Verificar duplicados
    $existe = $periodo->buscarNombre($_POST['DESCRIPTION']);
    if (count($existe) > 0) {
        throw new Exception('Este período ya existe');
    }

    // Cambia la llamada al método insertarPeriodo:
    $insertado = $periodo->insertarPeriodo(
        $_POST['DESCRIPTION'],
        $_POST['START_DATE'],
        $_POST['END_DATE'],
        $_POST['PERIOD_STATUS'] ?? 1,
        $_POST['STATUS'] ?? 1
    );

    if ($insertado !== true) {
        throw new Exception($insertado); // Esto mostrará el mensaje de error de MySQL
    }

    // Éxito
    echo json_encode([
        'message' => '<dialog id="message">
            <h2>Registro Completado</h2>
            <div class="success-checkmark">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
            </div>
            <button aria-label="close" class="x">❌</button>
        </dialog>'
    ]);
} catch (Exception $e) {
    // Mostrar error detallado
    echo json_encode([
        'message' => '<dialog id="message">
            <h2>Error: ' . htmlspecialchars($e->getMessage()) . '</h2>
            <div class="error-banmark">
                <div class="ban-icon">
                    <span class="icon-line line-long-invert"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
            </div>
            <button aria-label="close" class="x">❌</button>
        </dialog>'
    ]);
}
