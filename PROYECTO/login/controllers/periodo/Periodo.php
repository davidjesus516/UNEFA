<?php
require_once '../../model/Periodo.php';

class PeriodoController
{
    private $periodo;

    public function __construct()
    {
        $this->periodo = new Periodo();
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
        $activos = $this->periodo->listarActivos();
        $inactivos = $this->periodo->listarInactivos();
        echo json_encode([
            'activos' => $activos,
            'inactivos' => $inactivos
        ]);
    }

    private function buscar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $dato = $this->periodo->obtenerPorID($id);
            echo json_encode($dato);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->periodo->insertarPeriodo(...$datos);
        echo json_encode(['success' => $resultado]);
    }

    private function actualizar()
    {
        $PERIOD_ID = $_POST['id'] ?? null;
        if (!$PERIOD_ID) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->periodo->editarPeriodo($PERIOD_ID, ...$datos);
        echo json_encode(['success' => $resultado]);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->periodo->eliminarPeriodo($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->periodo->restaurarPeriodo($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function obtenerDatosFormulario()
    {
        return [
            $_POST['lapso_academico'] ?? '',
            $_POST['codigo_pasantia'] ?? '',
            $_POST['fecha_inicio'] ?? '',
            $_POST['fecha_fin'] ?? '',
            $_POST['estatus_periodo'] ?? '',
            $_POST['estatus'] ?? 1,
            $_POST['descripcion'] ?? ''
        ];
    }
}

$controlador = new PeriodoController();
$controlador->manejarSolicitud();