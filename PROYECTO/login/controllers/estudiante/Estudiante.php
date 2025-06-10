<?php
require_once '../../model/estudiante.php';

class EstudianteController
{
    private $estudiante;

    public function __construct()
    {
        $this->estudiante = new Student();
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
            default:
                echo json_encode(['error' => 'Acción no válida']);
                break;
        }
    }

    private function listar()
    {
        $todos = $this->estudiante->getAllStudents();
        $activos = array_filter($todos, function($e) { return $e['STATUS'] == 1 || $e['STATUS'] === "1"; });
        $inactivos = array_filter($todos, function($e) { return $e['STATUS'] == 0 || $e['STATUS'] === "0"; });
        echo json_encode([
            'activos' => array_values($activos),
            'inactivos' => array_values($inactivos)
        ]);
    }

    private function buscar()
    {
        $id = $_GET['id'] ?? $_POST['id'] ?? null;
        if ($id) {
            $dato = $this->estudiante->getStudentbyId($id);
            echo json_encode($dato);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->estudiante->insertStudent(...$datos);
        if ($resultado === true) {
            echo json_encode(['success' => true, 'message' => 'Estudiante registrado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo registrar el estudiante']);
        }
    }

    private function actualizar()
    {
        $STUDENTS_ID = $_POST['STUDENTS_ID'] ?? null;
        if (!$STUDENTS_ID) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            return;
        }
        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->estudiante->updateStudent($STUDENTS_ID, ...$datos);
        if ($resultado === true) {
            echo json_encode(['success' => true, 'message' => 'Estudiante actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el estudiante']);
        }
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->estudiante->deleteStudent($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $resultado = $this->estudiante->recoverStudent($id);
            echo json_encode(['success' => $resultado]);
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    private function obtenerDatosFormulario()
    {
        return [
            $_POST['STUDENTS_CI'] ?? '',
            $_POST['NAME'] ?? '',
            $_POST['SECOND_NAME'] ?? '',
            $_POST['SURNAME'] ?? '',
            $_POST['SECOND_SURNAME'] ?? '',
            $_POST['GENDER'] ?? '',
            $_POST['BIRTHDATE'] ?? '',
            $_POST['CONTACT_PHONE'] ?? '',
            $_POST['EMAIL'] ?? '',
            $_POST['ADDRESS'] ?? '',
            $_POST['MARITAL_STATUS'] ?? '',
            $_POST['SEMESTER'] ?? '',
            $_POST['SECTION'] ?? '',
            $_POST['REGIME'] ?? '',
            $_POST['STUDENT_TYPE'] ?? '',
            $_POST['MILITARY_RANK'] ?? '',
            $_POST['EMPLOYMENT'] ?? '',
            $_POST['CAREER_ID'] ?? ''
        ];
    }
}

$controlador = new EstudianteController();
$controlador->manejarSolicitud();