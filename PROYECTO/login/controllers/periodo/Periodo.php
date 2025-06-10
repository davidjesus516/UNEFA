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
        $accion = $_GET['accion'] ?? $_POST['accion'] ?? null;

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
            case 'cambiarEstado':
                $this->cambiarEstado();
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
        if ($resultado === true) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => $resultado]);
        }
    }

    private function actualizar()
    {
        $PERIOD_ID = $_POST['id'] ?? null;
        if (!$PERIOD_ID) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        error_log("editarPeriodo: " . print_r(func_get_args(), true));
        $resultado = $this->periodo->editarPeriodo($PERIOD_ID, ...$datos);

        if ($resultado === true) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => $resultado]);
        }
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

    private function cambiarEstado()
    {
        $PERIOD_ID = $_POST['id'] ?? null;
        $newStatus = $_POST['newStatus'] ?? null;

        if (!$PERIOD_ID || !$newStatus) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            return;
        }

        $resultado = $this->periodo->cambiarEstadoPeriodo($PERIOD_ID, $newStatus);

        if ($resultado === true) {
            echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => $resultado]);
        }
    }

    private function obtenerDatosFormulario()
    {
        return [
            $_POST['DESCRIPTION'] ?? '',      // Lapso académico (ej: 2025-I)
            $_POST['START_DATE'] ?? '',       // Fecha de inicio
            $_POST['END_DATE'] ?? '',         // Fecha de fin
            $_POST['PERIOD_STATUS'] ?? 1,     // Estatus del periodo
            $_POST['STATUS'] ?? 1             // Estatus general
        ];
    }
}

$controlador = new PeriodoController();
$controlador->manejarSolicitud();