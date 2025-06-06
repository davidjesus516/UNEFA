<?php
require_once("../../model/ListManager.php");

$listManager = new ListManager();

$type = $_GET['type'] ?? 'all'; // 'lists', 'values' o 'all'
$status = $_GET['status'] ?? 1; // 1=activos, 0=inactivos, null=todos

$response = [];

if($type === 'lists' || $type === 'all') {
    $response['lists'] = ($status !== null) 
        ? array_filter($listManager->getAllLists(), fn($item) => $item['STATUS'] == $status)
        : $listManager->getAllLists();
}

if($type === 'values' || $type === 'all') {
    $response['value_lists'] = ($status !== null)
        ? array_filter($listManager->getAllValueLists(), fn($item) => $item['STATUS'] == $status)
        : $listManager->getAllValueLists();
}

header('Content-Type: application/json');
echo json_encode($response);
?>