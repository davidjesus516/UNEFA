<?php
require("../../model/ListManager.php");

try {
    if(!isset($_POST['id']) || !isset($_POST['type'])) {
        throw new Exception("Datos insuficientes");
    }

    $id = (int)$_POST["id"];
    $type = $_POST["type"];
    $elim_user_id = (int)$_POST["elim_user_id"] ?? 0;
    
    $listManager = new ListManager();
    $success = false;
    
    if($type === 'list') {
        $success = $listManager->deleteList($id, $elim_user_id);
    } elseif($type === 'value') {
        $success = $listManager->deleteValueList($id, $elim_user_id);
    } else {
        throw new Exception("Tipo de operación inválida");
    }
    
    if($success) {
        echo '
        <h1>Registro Eliminado</h1>
        <button id="close" aria-label="close" class="x">❌</button>
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>';
    } else {
        throw new Exception("Error al eliminar el registro");
    }

} catch(Exception $e) {
    echo '
    <h1>Error</h1>
    <button id="close" aria-label="close" class="x">❌</button>
    <div class="error-message">
        <p>'.$e->getMessage().'</p>
    </div>';
}
?>