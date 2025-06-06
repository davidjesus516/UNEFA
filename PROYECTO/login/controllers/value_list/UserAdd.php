<?php
require("../../model/ListManager.php");

session_start();

header('Content-Type: application/json');

try {
    if(!isset($_POST)) {
        throw new Exception("No se recibieron datos POST");
    }

    $listManager = new ListManager();
    $response = ['success' => false, 'message' => ''];

    // Determinar qué tipo de operación se está realizando
    if(isset($_POST['name']) && isset($_SESSION['USER_ID'])) {
        // Operación con listas (t-list)
        $name = trim($_POST["name"]);
        $modif_user_id = (int) $_SESSION['USER_ID'];
        
        if(empty($name)) {
            throw new Exception("El nombre de la lista no puede estar vacío");
        }

        if(isset($_POST['id']) && !empty($_POST['id'])) {
            // Actualizar lista existente
            $list_id = (int)$_POST["id"];
            $result = $listManager->updateList($list_id, $name, $modif_user_id);
            $message = $result ? "Lista actualizada correctamente" : "Error al actualizar la lista";
        } else {
            // Insertar nueva lista
            $result = $listManager->insertList($name, $modif_user_id);
            $message = $result ? "Lista creada correctamente" : "La lista ya existe o hubo un error";
        }
        
        $response = ['success' => $result, 'message' => $message];
    } 
    elseif(isset($_POST['value_name']) && isset($_POST['list_id']) && isset($_SESSION['USER_ID'])) {
        // Operación con valores de lista (t-value_list)
        $name = trim($_POST["value_name"]);
        $abbreviation = isset($_POST["abbreviation"]) ? trim($_POST["abbreviation"]) : null;
        $list_id = (int)$_POST["list_id"];
        $modif_user_id = (int) $_SESSION['USER_ID'];
        
        if(empty($name)) {
            throw new Exception("El nombre del valor no puede estar vacío");
        }

        if(isset($_POST['id']) && !empty($_POST['id'])) {
            // Actualizar valor existente
            $value_list_id = (int)$_POST["id"];
            $result = $listManager->updateValueList($value_list_id, $name, $abbreviation, $list_id, $modif_user_id);
            $message = $result ? "Valor actualizado correctamente" : "Error al actualizar el valor";
        } else {
            // Insertar nuevo valor
            $result = $listManager->insertValueList($name, $abbreviation, $list_id, $modif_user_id);
            $message = $result ? "Valor creado correctamente" : "El valor ya existe o hubo un error";
        }
        
        $response = ['success' => $result, 'message' => $message];
    } else {
        throw new Exception("Datos insuficientes para la operación");
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>