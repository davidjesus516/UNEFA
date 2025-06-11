<?php
require_once '../../model/institution_manager_m.php';

class InstitutionManagerController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new InstitutionManager();
    }

    public function manejarSolicitud()
    {
        $accion = $_REQUEST['accion'] ?? '';

        try {
            switch ($accion) {
                case 'listar':
                    $this->listarResponsables();
                    break;
                case 'insertar':
                    $this->insertar();
                    break;
                case 'buscar':
                    $this->buscar();
                    break;
                case 'actualizar':
                    $this->actualizar();
                    break;
                case 'eliminar':
                    $this->eliminar();
                    break;
                case 'listar_activas':
                    $this->listarActivos();
                    break;
                case 'listar_inactivas':
                    $this->listarInactivos();
                    break;
                case 'restaurar':
                    $this->restaurar();
                    break;
                case 'validar_cedula':
                    $cedula = $_GET['cedula'] ?? '';
                    $id = $_GET['id'] ?? null;
                    $res = $this->modelo->cedulaExiste($cedula, $id);
                    $this->responder($res);
                    break;
                case 'validar_correo':
                    $correo = $_GET['correo'] ?? '';
                    $id = $_GET['id'] ?? null;
                    $res = $this->modelo->correoExiste($correo, $id);
                    $this->responder($res);
                    break;
                default:
                    $this->responder(['error' => 'Acción no válida'], 400);
                    break;
            }
        } catch (Exception $e) {
            $this->responder(['error' => $e->getMessage()], 500);
        }
    }

    private function listarResponsables()
    {
        $responsables = $this->modelo->listarActivos();
        $this->responder($responsables);
    }

    private function insertar()
    {
        $datos = [
            'INSTITUTION_ID' => $_POST['INSTITUTION_ID'],
            'MANAGER_CI' => $_POST['MANAGER_CI'],
            'NAME' => $_POST['NAME'],
            'SECOND_NAME' => $_POST['SECOND_NAME'] ?? null,
            'SURNAME' => $_POST['SURNAME'],
            'SECOND_SURNAME' => $_POST['SECOND_SURNAME'] ?? null,
            'CONTACT_PHONE' => $_POST['CONTACT_PHONE'],
            'EMAIL' => $_POST['EMAIL']
        ];

        $resultado = $this->modelo->insertar($datos);

        // Si el modelo devuelve un array con 'success', úsalo, si no, asume true/false
        if (is_array($resultado) && isset($resultado['success'])) {
            $success = $resultado['success'];
            $error = $resultado['error'] ?? null;
        } else {
            $success = $resultado ? true : false;
            $error = !$success ? 'Error al registrar responsable' : null;
        }

        $this->responder([
            'success' => $success,
            'message' => $success ? 'Responsable registrado exitosamente' : ($error ?? 'Error al registrar responsable')
        ]);
    }

    private function buscar()
    {
        $id = $_GET['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID requerido'], 400);
            return;
        }

        $responsable = $this->modelo->buscar($id);
        if ($responsable) {
            $this->responder($responsable);
        } else {
            $this->responder(['error' => 'Responsable no encontrado'], 404);
        }
    }

    private function actualizar()
    {
        $datos = [
            'MANAGER_ID' => $_POST['MANAGER_ID'] ?? $_POST['id'] ?? null,
            'INSTITUTION_ID' => $_POST['INSTITUTION_ID'],
            'MANAGER_CI' => $_POST['MANAGER_CI'],
            'NAME' => $_POST['NAME'],
            'SECOND_NAME' => $_POST['SECOND_NAME'] ?? null,
            'SURNAME' => $_POST['SURNAME'],
            'SECOND_SURNAME' => $_POST['SECOND_SURNAME'] ?? null,
            'CONTACT_PHONE' => $_POST['CONTACT_PHONE'],
            'EMAIL' => $_POST['EMAIL']
        ];

        // Validación básica
        if (empty($datos['MANAGER_ID'])) {
            $this->responder(['success' => false, 'error' => 'ID requerido'], 400);
        }

        // Llama al modelo con los parámetros correctos
        $resultado = $this->modelo->actualizar($datos);

        $success = $resultado ? true : false;

        $this->responder([
            'success' => $success,
            'message' => $success ? 'Responsable actualizado exitosamente' : 'Error al actualizar responsable'
        ]);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? $_POST['MANAGER_ID'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID requerido'], 400);
            return;
        }

        $resultado = $this->modelo->eliminar($id);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado ? 'Responsable eliminado correctamente' : 'Error al eliminar responsable'
        ]);
    }

    private function responder($datos, $codigoEstado = 200)
    {
        http_response_code($codigoEstado);
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit;
    }
    /**
     * Listar instituciones_manager activas
     */
    private function listarActivos()
    {
        $instituciones_manager = $this->modelo->listarActivos();
        $this->responder($instituciones_manager);
    }

    /**
     * Listar instituciones_manager inactivas
     */
    private function listarInactivos()
    {
        $instituciones_manager = $this->modelo->listarInactivos();
        $this->responder($instituciones_manager);
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? $_POST['MANAGER_ID'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID requerido'], 400);
            return;
        }

        $resultado = $this->modelo->restaurar($id);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado ? 'Responsable restaurado correctamente' : 'Error al restaurar responsable'
        ]);
    }
}

// Uso del controlador
$controlador = new InstitutionManagerController();
$controlador->manejarSolicitud();
