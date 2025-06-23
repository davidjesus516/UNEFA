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
                case 'buscar_preinscripcion_activa_por_cedula':
                    $this->buscarPreinscripcionActivaPorCedula();
                    break;
                case 'buscar_reprobada_por_cedula':
                    $this->buscarReprobadaPorCedula();
                    break;
                case 'cargar_responsables':
                    $this->cargarResponsables();
                    break;
                case 'listar_inscripciones_activos': // <-- Agregado
                    $this->listarInscripcionesActivos();
                    break;
                case 'listar_inscripciones_inactivos': // <-- Agregado
                    $this->listarInscripcionesInactivos();
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
                case 'listar_culminadas_aprobadas':
                    $this->listarCulminadasAprobadas();
                    break;
                case 'listar_culminadas_reprobadas':
                    $this->listarCulminadasReprobadas();
                    break;
                case 'inscribir_practica':
                    $this->inscribirPractica();
                    break;
                case 'actualizar_estado_culminacion':
                    $this->actualizarEstadoCulminacion();
                    break;
                case 'buscar_inscripcion_por_id':
                    $this->buscarInscripcionPorId();
                    break;
                case 'culminar_inscripcion':
                    $this->culminarInscripcion();
                    break;
                case 'eliminar_inscripcion':
                    $this->eliminarInscripcion();
                    break;
                case 'activar_inscripcion':
                    $this->activarInscripcion();
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

    private function buscarPreinscripcionActivaPorCedula()
    {
        $cedula = $this->obtenerValor('cedula', true);
        $datosPreinscripcion = $this->modelo->buscarPreinscripcionActivaPorCedula($cedula);

        if ($datosPreinscripcion) {
            $datosPreinscripcion['combos'] = $this->modelo->profesionalPracticesCombos($datosPreinscripcion['CAREER_ID'], $datosPreinscripcion['INTERNSHIP_TYPE_ID']);
            $this->responder($datosPreinscripcion);
        } else {
            $this->responder(['error' => 'No se encontró una preinscripción activa para este estudiante.'], 404);
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
    private function listarInscripcionesActivos()
    {
        $activos = $this->modelo->listarInscripcionesActivos();
        if (empty($activos)) {
            $this->responder(['mensaje' => 'No hay inscripciones activas'], 404);
            return;
        }
        $this->responder($activos);
    }
    /**
     * lisar inscripciones inactivas
     */
    private function listarInscripcionesInactivos()
    {
        $inactivos = $this->modelo->listarInscripcionesInactivos();
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
            'reprobado_practice_id' => $this->obtenerValor('reprobado_practice_id', false)
        ];
        $resultado = $this->modelo->insertarPreinscripcion($datos);
        if ($resultado === "DUPLICATE_PREINSCRIPTION") {
            $this->responder(['success' => false, 'error' => 'Este estudiante ya tiene una preinscripción (activa o inactiva) para el período seleccionado. Puede reactivarla si es necesario.'], 409);
        } elseif ($resultado === "STUDENT_ALREADY_IN_PROGRESS") {
            $this->responder(['success' => false, 'error' => 'No se puede preinscribir. El estudiante ya tiene una práctica profesional activa o en curso.'], 409);
        } elseif ($resultado === "PERIOD_NOT_GREATER_THAN_FAILED") {
            $this->responder(['success' => false, 'error' => 'No se puede preinscribir. El período de la nueva práctica debe ser posterior al período de la práctica reprobada.'], 409);
        } elseif ($resultado === "INVALID_NEW_PERIOD") {
            $this->responder(['success' => false, 'error' => 'El período seleccionado no es válido.'], 400);
        } elseif (strpos($resultado, 'PRIORITY_VIOLATION_NEEDS_') === 0) {
            $requiredPriority = str_replace('PRIORITY_VIOLATION_NEEDS_', '', $resultado);
            $this->responder(['success' => false, 'error' => "No se puede registrar esta práctica. El estudiante debe haber culminado y aprobado la práctica de prioridad {$requiredPriority} primero."], 409);
        } elseif ($resultado === "PERIOD_MUST_BE_DIFFERENT") {
            $this->responder(['success' => false, 'error' => 'El período de la nueva preinscripción debe ser diferente al período de la práctica reprobada.'], 409);
        } elseif ($resultado === "INVALID_REPROBADO_PRACTICE_ID") {
            $this->responder(['success' => false, 'error' => 'ID de práctica reprobada inválido o no corresponde a una práctica reprobada.'], 400);
        } elseif ($resultado === "PRIORITY_ALREADY_REGISTERED") {
            $this->responder(['success' => false, 'error' => 'No se puede registrar. El estudiante ya tiene un registro para este nivel de práctica.'], 409);
        } elseif ($resultado) {
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
            'reprobado_practice_id' => $this->obtenerValor('reprobado_practice_id', false)
        ];
        $resultado = $this->modelo->actualizarPreinscripcion($id, $datos); // Pass $id for update check
        if ($resultado === "DUPLICATE_PREINSCRIPTION") {
            $this->responder(['success' => false, 'error' => 'No se puede actualizar. Este estudiante ya tiene otra preinscripción (activa o inactiva) para el período de destino.'], 409);
        } elseif ($resultado === "STUDENT_ALREADY_INSCRIBED") {
            $this->responder(['success' => false, 'error' => 'No se puede actualizar. El estudiante tiene otra práctica profesional en curso o culminada no aprobada.'], 409); // This message is still valid for hasActiveNonApprovedPractice
        } elseif (strpos($resultado, 'PRIORITY_VIOLATION_NEEDS_') === 0) { // This is for canRegisterForPracticeType
            $requiredPriority = str_replace('PRIORITY_VIOLATION_NEEDS_', '', $resultado);
            $this->responder(['success' => false, 'error' => "No se puede actualizar a esta práctica. El estudiante debe haber culminado y aprobado la práctica de prioridad {$requiredPriority} primero."], 409);
        } elseif ($resultado === "PRIORITY_ALREADY_REGISTERED") {
            $this->responder(['success' => false, 'error' => 'No se puede actualizar. El estudiante ya tiene otro registro para este nivel de práctica.'], 409);
        } elseif ($resultado) {
        } elseif ($resultado === "PERIOD_MUST_BE_DIFFERENT") {
            $this->responder(['success' => false, 'error' => 'El período de la nueva preinscripción debe ser diferente al período de la práctica reprobada.'], 409);
        } elseif ($resultado === "INVALID_REPROBADO_PRACTICE_ID") {
            $this->responder(['success' => false, 'error' => 'ID de práctica reprobada inválido o no corresponde a una práctica reprobada.'], 400);
            $this->responder(['success' => true, 'message' => 'Preinscripción actualizada correctamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo actualizar la preinscripción'], 500);
        }
    }

    private function buscarPreinscripcionPorId()
    {
        $id = $this->obtenerValor('id', true);
        $data = $this->modelo->buscarPreinscripcionPorId($id);
        $data['combos'] = $this->modelo->profesionalPracticesCombos($data['CAREER_ID']);
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
            $this->responder(['success' => true, 'message' => 'Preinscripción eliminada exitosamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo eliminar la Preinscripción'], 500);
        }
    }

    private function activarPreinscripcion()
    {
        $id = $this->obtenerValor('id', true);

        // Obtener los detalles de la preinscripción que se va a activar
        $preinscripcion = $this->modelo->buscarPreinscripcionPorId($id);
        if (!$preinscripcion) {
            $this->responder(['success' => false, 'error' => 'La preinscripción no existe.'], 404);
            return;
        }

        // Validar que no exista otra preinscripción ACTIVA para el mismo estudiante y período
        if ($this->modelo->checkDuplicateActivePreinscripcion($preinscripcion['STUDENTS_ID'], $preinscripcion['PERIOD_ID'])) {
            $this->responder(['success' => false, 'error' => 'No se puede activar. Ya existe otra preinscripción activa para este estudiante en el mismo período.'], 409);
            return;
        }

        // Validar que el estudiante no esté ya inscrito o haya culminado en CUALQUIER período
        if ($this->modelo->hasActiveNonApprovedPractice($preinscripcion['STUDENTS_ID'])) { // Keep this check for activating old pre-registrations
            $this->responder(['success' => false, 'error' => 'No se puede activar. El estudiante tiene otra práctica profesional en curso o culminada no aprobada.'], 409);
            return;
        }

        $ok = $this->modelo->cambiarEstadoPreinscripcion($id, 1);
        if ($ok) {
            $this->responder(['success' => true, 'message' => 'Preinscripción activada exitosamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo activar la Preinscripción'], 500);
        }
    }

    private function listarCulminadasAprobadas()
    {
        $data = $this->modelo->listarCulminadasAprobadas();
        if (empty($data)) {
            $this->responder(['mensaje' => 'No hay preinscripciones culminadas aprobadas'], 404);
            return;
        }
        $this->responder($data);
    }

    private function listarCulminadasReprobadas()
    {
        $data = $this->modelo->listarCulminadasReprobadas();
        if (empty($data)) {
            $this->responder(['mensaje' => 'No hay preinscripciones culminadas reprobadas'], 404);
            return;
        }
        $this->responder($data);
    }

    private function inscribirPractica()
    {
        $datos = [
            'id' => $this->obtenerValor('id_form', true),
            'tutor_academico' => $this->obtenerValor('tutor_academico', true),
            'tutor_metodologico' => $this->obtenerValor('tutor_metodologico', true),
            'institucion' => $this->obtenerValor('institucion', true),
            'responsable' => $this->obtenerValor('responsable_institucion', true)
        ];

        if ($datos['tutor_academico'] === $datos['tutor_metodologico']) {
            $this->responder(['success' => false, 'error' => 'El tutor académico y el tutor metodológico no pueden ser la misma persona.'], 400);
            return;
        }

        $resultado = false;
        $currentPracticeId = $datos['id'];

        // Si se proporcionó un ID de práctica profesional (es una edición o una inscripción desde preinscripción)
        if (!empty($currentPracticeId)) {
            // Obtener el estado actual de la práctica (1: Preinscrito, 2: Inscrito, 3: Culminado)
            $practiceStatus = $this->modelo->getPracticeStatusById($currentPracticeId);

            // Si el estado es 1 (Preinscrito), se convierte en una inscripción formal.
            if ($practiceStatus == 1) {
                $resultado = $this->modelo->inscribirPractica($datos);

            // Si el estado es 2 (Inscrito), se actualizan los detalles de la inscripción existente.
            } elseif ($practiceStatus == 2) {
                $resultado = $this->modelo->actualizarInscripcion($datos);
            }
            // Si el estado es diferente (ej. 3 - Culminado), no se hace nada y $resultado permanece `false`.
        }

        if ($resultado) {
            $this->responder(['success' => true, 'message' => 'Inscripción registrada correctamente.']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo registrar la inscripción.'], 500);
        }
    }

    private function buscarInscripcionPorId()
    {
        $id = $this->obtenerValor('id', true);
        $data = $this->modelo->buscarInscripcionPorId($id);
        if ($data) {
            // También necesitamos los combos para poblar los selects
            $data['combos'] = $this->modelo->profesionalPracticesCombos($data['CAREER_ID']);
            // Y los responsables de la institución seleccionada
            if (!empty($data['INSTITUTION_ID'])) {
                $data['combos']['responsables'] = $this->modelo->cargarResponsables($data['INSTITUTION_ID']);
            }
            $this->responder($data);
        } else {
            $this->responder(['error' => 'Inscripción no encontrada'], 404);
        }
    }


    private function actualizarEstadoCulminacion()
    {
        $id = $this->obtenerValor('id', true);
        $intershipStatus = $this->obtenerValor('intership_status', true);

        // Validación básica para el estado de la pasantía
        if (!in_array($intershipStatus, [2, 3])) {
            $this->responder(['success' => false, 'error' => 'Estado de pasantía no válido.'], 400);
            return;
        }

        $resultado = $this->modelo->actualizarEstadoCulminacion($id, $intershipStatus);

        if ($resultado) {
            $this->responder(['success' => true, 'message' => 'Estado de culminación actualizado correctamente.']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo actualizar el estado de culminación.'], 500);
        }
    }

    private function culminarInscripcion()
    {
        $id = $this->obtenerValor('id', true);
        $intershipStatus = $this->obtenerValor('intership_status', true);

        // Validación básica para el estado
        if (!in_array($intershipStatus, [2, 3])) {
            $this->responder(['success' => false, 'error' => 'Estado de pasantía no válido.'], 400);
            return;
        }

        $resultado = $this->modelo->culminarInscripcion($id, $intershipStatus);

        if ($resultado) {
            $this->responder(['success' => true, 'message' => 'La práctica ha sido culminada exitosamente.']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo culminar la práctica. Puede que ya no esté en estado "Inscrito".'], 500);
        }
    }

    private function eliminarInscripcion()
    {
        $id = $this->obtenerValor('id', true);
        // Reutiliza el método del modelo que solo cambia el STATUS
        $ok = $this->modelo->cambiarEstadoPreinscripcion($id, 0);
        if ($ok) {
            $this->responder(['success' => true, 'message' => 'Inscripción eliminada exitosamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo eliminar la Inscripción'], 500);
        }
    }

    private function activarInscripcion()
    {
        $id = $this->obtenerValor('id', true);
        // Reutiliza el método del modelo que solo cambia el STATUS
        $ok = $this->modelo->cambiarEstadoPreinscripcion($id, 1);
        if ($ok) {
            $this->responder(['success' => true, 'message' => 'Inscripción activada exitosamente']);
        } else {
            $this->responder(['success' => false, 'error' => 'No se pudo activar la Inscripción'], 500);
        }
    }

    private function buscarReprobadaPorCedula() {
        $cedula = $this->obtenerValor('cedula', true);
        // First, get the student ID from the CI
        $studentData = $this->modelo->buscarPorCedula($cedula);
        if ($studentData && $studentData['STUDENTS_ID']) {
            // Then, use the student ID to find the latest reprobado practice
            $datosReprobada = $this->modelo->getLatestReprobadoPracticeDetails($studentData['STUDENTS_ID']);
            if ($datosReprobada) {
                $this->responder($datosReprobada);
            } else {
                $this->responder(['error' => 'No se encontró una práctica reprobada para este estudiante.'], 404);
            }
        } else {
            $this->responder(['error' => 'Estudiante no encontrado.'], 404);
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