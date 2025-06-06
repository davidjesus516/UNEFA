<?php
require_once '../../model/Tutor.php';

class TutorController
{
    private $tutor;

    public function __construct()
    {
        $this->tutor = new Tutor();
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
        $datos = $this->tutor->listarActivos();
        echo json_encode($datos);
    }

    private function buscar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $dato = $this->tutor->buscarPorId($id);
            echo json_encode($dato);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->tutor->insertar(...$datos);
        echo json_encode(['success' => $resultado]);
    }

    private function actualizar()
    {
        $TUTOR_ID = $_POST['id'] ?? null;
        if (!$TUTOR_ID) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->tutor->actualizar($TUTOR_ID, ...$datos);
        echo json_encode(['success' => $resultado]);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        $user = $_POST['user_id'] ?? 1;

        if ($id) {
            $resultado = $this->tutor->eliminar($id, $user);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        $user = $_POST['user_id'] ?? 1;

        if ($id) {
            $resultado = $this->tutor->restaurar($id, $user);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function obtenerDatosFormulario()
    {
        return [
            $_POST['cedula'] ?? '',
            $_POST['primer_nombre'] ?? '',
            $_POST['primer_apellido'] ?? '',
            $_POST['telefono'] ?? '',
            $_POST['sexo'] ?? '',
            $_POST['correo'] ?? '',
            $_POST['profesion'] ?? '',
            $_POST['condicion'] ?? '',
            $_POST['dedicacion'] ?? '',
            $_POST['categoria'] ?? '',
            $_POST['user_id'] ?? 1,
            $_POST['segundo_nombre'] ?? null,
            $_POST['segundo_apellido'] ?? null,
        ];
    }
}

$controlador = new TutorController();
$controlador->manejarSolicitud();
