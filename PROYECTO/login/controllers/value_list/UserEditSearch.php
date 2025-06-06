<?php
header('Content-Type: application/json');

try {
    if(!isset($_POST['id']) || !isset($_POST['type'])) {
        throw new Exception("Parámetros requeridos no recibidos");
    }

    $id = (int)$_POST["id"];
    $type = $_POST["type"];

    require("../../model/ListManager.php");
    
    $listManager = new ListManager();
    $data = null;
    
    if($type === 'list') {
        $data = $listManager->getListById($id);
    } elseif($type === 'value') {
        $data = $listManager->getValueListById($id);
    } else {
        throw new Exception("Tipo de búsqueda no válido");
    }

    if(!$data) {
        throw new Exception("Registro no encontrado");
    }

    echo json_encode($data);

} catch(Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
?>