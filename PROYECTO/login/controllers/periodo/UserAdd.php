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
    if (count($existe) > 0) {$row = array(
                'message' =>'     
                <dialog id="message">
            <h2>Ya existe.</h2>
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

    $insertado = $periodo->insertarPeriodo($ACADEMIC_LAPSE, $T_INTERNSHIPS_CODE, $START_DATE, $END_DATE, $PERIOD_STATUS, $STATUS);

    if ($insertado) {
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
} else {$row = array(
                'message' =>'     
                <dialog id="message">
            <h2>Faltan datos obligatorios.</h2>
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
