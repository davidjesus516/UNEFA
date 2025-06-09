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