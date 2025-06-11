<?php
require_once '../../model/tipo_practica_m.php';

class TipoPracticaController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new TipoPractica();
    }

    public function manejarSolicitud()
    {
        $accion = $_REQUEST['accion'] ?? '';

        try {
            switch ($accion) {
                case 'listar_activos':
                    $this->listarActivos();
                    break;
                case 'listar_inactivos':
                    $this->listarInactivos();
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
                case 'buscar_para_editar':
                    $this->buscarParaEditar();
                    break;
                default:
                    $this->responder(['error' => 'Acción no válida'], 400);
                    break;
            }
        } catch (Exception $e) {
            $this->responder(['error' => $e->getMessage()], 500);
        }
    }

    private function listarActivos()
    {
        $practicas = $this->modelo->listarActivos();
        error_log('Prácticas activas: ' . json_encode($practicas));
        $this->responder($practicas);
    }

    private function listarInactivos()
    {
        $practicas = $this->modelo->listarInactivos();
        $this->responder($practicas);
    }

    private function insertar()
    {
        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->modelo->insertar($datos);

        if ($resultado) {
            $this->responder(['success' => true, 'message' => 'Tipo de práctica registrado exitosamente']);
        } else {
            $this->responder(['error' => 'Error al registrar el tipo de práctica'], 500);
        }
    }

    private function actualizar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de tipo de práctica requerido'], 400);
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $resultado = $this->modelo->actualizar($id, $datos);

        $this->responder([
            'success' => $resultado,
            'message' => $resultado
                ? 'Tipo de práctica actualizado correctamente'
                : 'Error al actualizar el tipo de práctica'
        ]);
    }

    private function eliminar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            error_log('ID de tipo de práctica no proporcionado.');
            $this->responder(['error' => 'ID de tipo de práctica requerido'], 400);
            return;
        }

        $resultado = $this->modelo->eliminar($id);
        if (!$resultado) {
            error_log('Error al ejecutar el método eliminar en el modelo.');
        }

        $this->responder([
            'success' => $resultado,
            'message' => $resultado
                ? 'Tipo de práctica desactivado correctamente'
                : 'Error al desactivar el tipo de práctica'
        ]);
    }

    private function restaurar()
    {
        $id = $_POST['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de tipo de práctica requerido'], 400);
            return;
        }

        $resultado = $this->modelo->restaurar($id);
        $this->responder([
            'success' => $resultado,
            'message' => $resultado
                ? 'Tipo de práctica restaurado correctamente'
                : 'Error al restaurar el tipo de práctica'
        ]);
    }

    private function buscarParaEditar()
    {
        $id = $_GET['id'] ?? null;
        if (empty($id)) {
            $this->responder(['error' => 'ID de tipo de práctica requerido'], 400);
            return;
        }

        $practica = $this->modelo->buscarPorId($id);
        if ($practica) {
            $this->responder([$practica]);
        } else {
            $this->responder(['error' => 'Tipo de práctica no encontrado'], 404);
        }
    }

    private function obtenerDatosFormulario()
    {
        return [
            'nombre' => $_POST['nombre'] ?? '',
            'prioridad' => $_POST['prioridad'] ?? ''
        ];
    }

    private function responder($datos, $codigoEstado = 200)
    {
        http_response_code($codigoEstado);
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit;
    }
}

// Uso del controlador
$controlador = new TipoPracticaController();
$controlador->manejarSolicitud();