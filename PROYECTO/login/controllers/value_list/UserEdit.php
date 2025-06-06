<?php
require("../../model/ListManager.php");

header('Content-Type: application/json');

try {
    if(!isset($_POST['id']) || !isset($_POST['type'])) {

        throw new Exception("Datos insuficientes para la operación");
    }

    $id = (int)$_POST["id"];
    $type = $_POST["type"];
    $modif_user_id = (int)$_POST["modif_user_id"] ?? 0;
    $listManager = new ListManager();
    $result = false;

    if($type === 'list') {
        if(!isset($_POST['name'])) {
            throw new Exception("Nombre de lista requerido");
        }
        $name = trim($_POST["name"]);
        $result = $listManager->updateList($id, $name, $modif_user_id);
        $message = $result ? "Lista actualizada correctamente" : "Error al actualizar la lista";
        
    } elseif($type === 'value') {
        if(!isset($_POST['name']) || !isset($_POST['list_id'])) {
            throw new Exception("Datos incompletos para valor de lista");
        }
        $name = trim($_POST["name"]);
        $abbreviation = isset($_POST["abbreviation"]) ? trim($_POST["abbreviation"]) : null;
        $list_id = (int)$_POST["list_id"];
        $result = $listManager->updateValueList($id, $name, $abbreviation, $list_id, $modif_user_id);
        $message = $result ? "Valor de lista actualizado correctamente" : "Error al actualizar el valor";
        
    } else {
        throw new Exception("Tipo de operación no válido");
    }

    echo json_encode([
        'success' => $result,
        'message' => $message
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>