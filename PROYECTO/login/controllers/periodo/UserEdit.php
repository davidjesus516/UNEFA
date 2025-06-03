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
    if (!is_numeric($PERIOD_ID)) {$row = array(
                'message' =>'     
                <dialog id="message">
            <h2>ID inválido.</h2>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            <button aria-label="close" class="x">❌</button>
            </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
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
         $row = array(
        'message' => '    
        <dialog id="message">
        <h2>Registro Completado</h2>
        <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        <div class="success-checkmark">
        <div class="check-icon">
            <span class="icon-line line-tip"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
        </div>
        </div>
        </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
}else{
    $row = array(
                'message' =>'     
                <dialog id="message">
            <h2>Ha ocurrido un error en el registro.</h2>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            <button aria-label="close" class="x">❌</button>
            </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
}
} else {
   $row = array(
                'message' =>'     
                <dialog id="message">
            <h2>Faltan datos requeridos.</h2>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            <button aria-label="close" class="x">❌</button>
            </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
}
