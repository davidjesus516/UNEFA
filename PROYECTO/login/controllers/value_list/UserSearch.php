<?php
require_once("../../model/ListManager.php");

$searchTerm = trim($_POST["search"] ?? '');
$searchType = $_POST["type"] ?? 'name'; // 'name' o 'abbreviation'

$listManager = new ListManager();

if ($searchType === 'name') {
    $results = [
        'lists' => $listManager->getListByName($searchTerm),
        'values' => $listManager->getValueListByName($searchTerm)
    ];
} elseif ($searchType === 'abbreviation') {
    $results = [
        'values' => $listManager->getValueListByAbbreviation($searchTerm)
    ];
}

header('Content-Type: application/json');
echo json_encode(array_filter($results));
?>