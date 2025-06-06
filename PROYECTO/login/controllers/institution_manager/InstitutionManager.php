<?php
require_once '../../model/InstitutionManager.php';

class InstitutionManagerController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new InstitutionManager();
    }

    public function manejarSolicitud()
    {
        $accion = $_REQUEST['accion'] ?? '';

        switch ($accion) {
            case 'listar':
                $this->listar();
                break;
            case 'buscar':
                $this->buscar();
                break;
            case 'insertar':
                $this->insertar();
                break;
            case 'actualizar':
                $this->actualizar();
                break;
            case 'eliminar':
                $this->eliminar();
                break;
            case 'restaurar':
                $this->restaurar();
                break;
            default:
                echo json_encode(['error' => 'Acción no válida']);
                break;
        }
    }

    private function listar()
    {
        $datos = $this->manager->listarActivos();
        echo json_encode($datos);
    }

    private function buscar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $dato = $this->manager->buscarPorId($id);
            echo json_encode($dato);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->manager->insertar(...$datos);
        echo json_encode(['success' => $resultado]);
    }

    private function actualizar()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->manager->actualizar($id, ...$datos);
        echo json_encode(['success' => $resultado]);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->manager->eliminar($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->manager->restaurar($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function obtenerDatosFormulario()
    {
        return [
            $_POST['cedula'] ?? '',
            $_POST['nombre'] ?? '',
            $_POST['apellido'] ?? '',
            $_POST['telefono'] ?? '',
            $_POST['correo'] ?? '',
            $_POST['segundo_nombre'] ?? null,
            $_POST['segundo_apellido'] ?? null
        ];
    }
}

$controlador = new InstitutionManagerController();
$controlador->manejarSolicitud();
