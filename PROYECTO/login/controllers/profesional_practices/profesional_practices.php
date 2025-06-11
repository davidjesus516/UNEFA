<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../model/profesional_practices.php';



class ProfesionalPracticesController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ProfesionalPractices();
    }

    /**
     * Maneja las solicitudes HTTP y dirige a los métodos correspondientes
     */
    public function manejarSolicitud()
    {
        $accion = $_REQUEST['accion'] ?? '';

        try {
            switch ($accion) {
                case 'buscar_por_cedula':
                    $this->buscarPorCedula();
                    break;
                case 'cargar_responsables':
                    $this->cargarResponsables();
                    break;
                case 'listar_activos': // <-- Agregado
                    $this->listarActivos();
                    break;
                case 'listar_inactivos': // <-- Agregado
                    $this->listarInactivos();
                    break;
                case 'listar_periodos':
                    $this->listarPeriodos();
                    break;
                case 'listar_preinscripciones_activos':
                    $this->listarPreinscripcionesActivos();
                    break;
                case 'listar_preinscripciones_inactivos':
                    $this->listarPreinscripcionesInactivos();
                    break;
                case 'insertar_preinscripcion':
                    $this->insertarPreinscripcion();
                    break;
                case 'actualizar_preinscripcion':
                    $this->actualizarPreinscripcion();
                    break;
                case 'buscar_preinscripcion_por_id':
                    $this->buscarPreinscripcionPorId();
                    break;
                case 'eliminar_preinscripcion':
                    $this->eliminarPreinscripcion();
                    break;
                case 'activar_preinscripcion':
                    $this->activarPreinscripcion();
                    break;
                default:
                    $this->responder(['error' => 'Acción no válida'], 400);
                    break;
            }
        } catch (Exception $e) {
            $this->responder(['error' => $e->getMessage()], 500);
        }
    }

    /** 
     * Buscar estudiante por cédula
     */
    private function buscarPorCedula()
    {
        $cedula = $this->obtenerValor('cedula', true);
        $datosEstudiante = $this->modelo->buscarPorCedula($cedula);

        if ($datosEstudiante) {
            $datosEstudiante['combos'] = $this->modelo->profesionalPracticesCombos($datosEstudiante['CAREER_ID']);
            $this->responder($datosEstudiante);
        } else {
            $this->responder(['error' => 'Estudiante no encontrado'], 404);
        }
    }
    private function cargarResponsables()
    {
        $institucionId = $this->obtenerValor('institucion_id', true);
        $responsables = $this->modelo->cargarResponsables($institucionId);

        if ($responsables) {
            $this->responder($responsables);
        } else {
            $this->responder(['error' => 'No se encontraron responsables'], 404);
        }
    }

    /**
     * Listar inscripciones activas
     */
    private function listarActivos()
    {
        $activos = $this->modelo->listarActivos();
        if (empty($activos)) {
            $this->responder(['mensaje' => 'No hay inscripciones activas'], 404);
            return;
        }
        $this->responder($activos);
    }
    /**
     * lisar inscripciones inactivas
     */
    private function listarInactivos()
    {
        $inactivos = $this->modelo->listarInactivos();
        if (empty($inactivos)) {
            $this->responder(['mensaje' => 'No hay inscripciones inactivas'], 404);
            return;
        }
        $this->responder($inactivos);
    }
    /**
     * Listar periodos
     */
    private function listarPeriodos()
    {
        $periodos = $this->modelo->listarPeriodos();
        if (empty($periodos)) {
            $this->responder(['mensaje' => 'No hay periodos disponibles'], 404);
            return;
        }
        $this->responder($periodos);
    }

    private function listarPreinscripcionesActivos()
    {
        $activos = $this->modelo->listar_preinscripciones_activos();
        if (empty($activos)) {
            $this->responder(['mensaje' => 'No hay preinscripciones activas'], 404);
            return;
        }
        $this->responder($activos);
    }

    private function listarPreinscripcionesInactivos()
    {
        $inactivos = $this->modelo->listar_preinscripciones_inactivos();
        if (empty($inactivos)) {
            $this->responder(['mensaje' => 'No hay preinscripciones inactivas'], 404);
            return;
        }
        $this->responder($inactivos);
    }

    // NUEVOS MÉTODOS CRUD

    private function insertarPreinscripcion()
    {
        $datos = [
            'estudiante_id' => $this->obtenerValor('id_estudiante', true),
            'periodo' => $this->obtenerValor('periodo', true),
            'tipo_practica' => $this->obtenerValor('tipo_practica', true),
            'matricula' => $this->obtenerValor('matricula', true),
            'documentos' => $this->obtenerValor('documentos', true)
        ];
        $resultado = $this->modelo->insertarPreinscripcion($datos);
        if ($resultado) {
            $this->responder(['success' => true, 'message' => 'Preinscripción registrada correctamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo registrar la preinscripción'], 500);
        }
    }

    private function actualizarPreinscripcion()
    {
        $id = $this->obtenerValor('id', true);
        $datos = [
            'estudiante_id' => $this->obtenerValor('id_estudiante', true),
            'periodo' => $this->obtenerValor('periodo', true),
            'tipo_practica' => $this->obtenerValor('tipo_practica', true),
            'matricula' => $this->obtenerValor('matricula', true),
            'documentos' => $this->obtenerValor('documentos', true)
        ];
        $resultado = $this->modelo->actualizarPreinscripcion($id, $datos);
        if ($resultado) {
            $this->responder(['success' => true, 'message' => 'Preinscripción actualizada correctamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo actualizar la preinscripción'], 500);
        }
    }

    private function buscarPreinscripcionPorId()
    {
        $id = $this->obtenerValor('id', true);
        $data = $this->modelo->buscarPreinscripcionPorId($id);
        if ($data) {
            $this->responder($data);
        } else {
            $this->responder(['error' => 'No encontrada'], 404);
        }
    }

    private function eliminarPreinscripcion()
    {
        $id = $this->obtenerValor('id', true);
        $ok = $this->modelo->cambiarEstadoPreinscripcion($id, 0);
        if ($ok) {
            $this->responder(['success' => true, 'message' => 'Inscripción eliminada exitosamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo eliminar la inscripción'], 500);
        }
    }

    private function activarPreinscripcion()
    {
        $id = $this->obtenerValor('id', true);
        $ok = $this->modelo->cambiarEstadoPreinscripcion($id, 1);
        if ($ok) {
            $this->responder(['success' => true, 'message' => 'Inscripción activada exitosamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo activar la inscripción'], 500);
        }
    }

    /**
     * Obtiene y valida los datos del formulario
     */
    private function obtenerDatosFormulario()
    {
        return [
            'cedula' => $this->obtenerValor('cedula', true),
            'estudiante_id' => $this->obtenerValor('estudiante_id', true),
            'tutor_academico_id' => $this->obtenerValor('tutor_academico_id', true),
            'tutor_metodologico_id' => $this->obtenerValor('tutor_metodologico_id', true),
            'institucion_id' => $this->obtenerValor('institucion_id', true),
            'tipos_pasantia' => $_POST['tipos_pasantia'] ?? []
        ];
    }

    /**
     * Obtiene un valor del POST/GET con validación básica
     */
    private function obtenerValor($campo, $requerido = false)
    {
        $valor = $_POST[$campo] ?? $_GET[$campo] ?? null;
        
        if ($requerido && empty($valor)) {
            throw new Exception("El campo $campo es requerido");
        }
        
        return $valor;
    }

    /**
     * Envía una respuesta JSON con el código de estado HTTP
     */
    private function responder($datos, $codigoEstado = 200)
    {
        http_response_code($codigoEstado);
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit;
    }
}

// Uso del controlador
$controlador = new ProfesionalPracticesController();
$controlador->manejarSolicitud();