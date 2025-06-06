<?php
require_once '../../model/ListManager.php';

class ListManagerController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new ListManager();
    }

    public function manejar()
    {
        $accion = $_REQUEST['accion'] ?? '';

        switch ($accion) {
            case 'getValoresPorLista':
                $this->getValoresPorLista();
                break;
            default:
                echo json_encode(['error' => 'Acción inválida']);
                break;
        }
    }

    private function getValoresPorLista()
    {
        $listId = $_GET['list_id'] ?? null;

        if (!$listId || !is_numeric($listId)) {
            echo json_encode(['error' => 'ID de lista inválido']);
            return;
        }

        $valores = $this->manager->getValueListsByListId($listId);
        echo json_encode($valores);
    }
}

$controller = new ListManagerController();
$controller->manejar();
