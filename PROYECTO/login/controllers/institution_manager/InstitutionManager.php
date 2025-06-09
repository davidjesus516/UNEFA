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
            'institucion_id' => $_POST['institucion_id'],
            'cedula' => $_POST['cedula'],
            'nombre' => $_POST['nombre'],
            'segundo_nombre' => $_POST['segundo_nombre'] ?? null,
            'apellido' => $_POST['apellido'],
            'segundo_apellido' => $_POST['segundo_apellido'] ?? null,
            'telefono' => $_POST['telefono'],
            'correo' => $_POST['correo']
        ];

        $resultado = $this->modelo->insertar($datos);

        $this->responder([
            'success' => $resultado,
            'message' => $resultado ? 'Responsable registrado exitosamente' : 'Error al registrar responsable'
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
            'id' => $_POST['id'],
            'institucion_id' => $_POST['institucion_id'],
            'cedula' => $_POST['cedula'],
            'nombre' => $_POST['nombre'],
            'segundo_nombre' => $_POST['segundo_nombre'] ?? null,
            'apellido' => $_POST['apellido'],
            'segundo_apellido' => $_POST['segundo_apellido'] ?? null,
            'telefono' => $_POST['telefono'],
            'correo' => $_POST['correo']
        ];

        $resultado = $this->modelo->actualizar($datos);

        $this->responder([
            'success' => $resultado,
            'message' => $resultado ? 'Responsable actualizado exitosamente' : 'Error al actualizar responsable'
        ]);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
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
}

// Uso del controlador
$controlador = new InstitutionManagerController();
$controlador->manejarSolicitud();
