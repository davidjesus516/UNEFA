<?php
require_once("conexion.php");

class ProfesionalPractices
{
    private $conexion;
    private $pdo;

    /**
 * Constructor de la clase. Inicializa la conexión a la base de datos.
     */
    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }
    
    /**
 * Busca un estudiante por su número de cédula.
 * @param string $cedula La cédula del estudiante a buscar (ej. "V-12345678").
     * @return array|null Un array con los datos del estudiante si se encuentra, o null si no.
     */
    public function buscarPorCedula($cedula) {
        $consulta = "SELECT s.`STUDENTS_ID`, CONCAT(s.`NAME`,' ',s.`SECOND_NAME`,' ',s.`SURNAME`,' ',s.`SECOND_SURNAME`) AS `NOMBRE_COMPLETO`, 
                        s.`CAREER_ID`, CONCAT(c.`CAREER_ABBREVIATION`,'-',s.`SEMESTER`,'-',s.`SECTION`,'-',s.`REGIME`) AS ENROLLMENT 
                     FROM `t-students` s LEFT JOIN `t-career` c ON s.`CAREER_ID` = c.`CAREER_ID` 
                     WHERE s.`STUDENTS_CI` = :cedula AND s.`STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula', $cedula);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    /**
 * Busca una preinscripción activa (PRACTICES_STATUS = 1) por la cédula del estudiante.
 * @param string $cedula La cédula del estudiante (ej. "V-12345678").
     * @return array|null Un array con los datos de la preinscripción si se encuentra, o null si no.
     */
    public function buscarPreinscripcionActivaPorCedula($cedula) {
        $consulta = "SELECT
                        pp.PROFESSIONAL_PRACTICE_ID,
                        s.STUDENTS_ID,
                        CONCAT(s.NAME, ' ', s.SECOND_NAME, ' ', s.SURNAME, ' ', s.SECOND_SURNAME) AS NOMBRE_COMPLETO,
                        it.NAME AS TIPO_PRACTICA,
                        s.CAREER_ID
                    FROM `t-professional_practices` pp
                    JOIN `t-students` s ON pp.STUDENTS_ID = s.STUDENTS_ID
                    JOIN `t-internship_type` it ON pp.INTERNSHIP_TYPE_ID = it.INTERNSHIP_TYPE_ID
                    WHERE s.STUDENTS_CI = :cedula
                      AND pp.PRACTICES_STATUS = 1 AND pp.STATUS = 1"; // 1 = PRE INSCRIPCION ACTIVA
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula', $cedula);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    /**
 * Carga los responsables (tutores institucionales) de una institución específica.
 * @param int $institucionId El ID de la institución.
     * @return array Un array con la lista de responsables.
     */
    public function cargarResponsables($institucionId) {
        $consulta = "SELECT * FROM `t-institution_manager` WHERE `INSTITUTION_ID` = :institucionId AND `STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':institucionId', $institucionId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
 * Obtiene los datos necesarios para los combos (selects) del formulario de prácticas profesionales.
 * @param int $carrera El ID de la carrera para filtrar los tipos de práctica.
 * @return array Un array asociativo con 'internship_types', 'tutores' e 'instituciones'.
     */
    public function profesionalPracticesCombos($carrera) {
        $consulta = "SELECT i.`INTERNSHIP_TYPE_ID`, i.`NAME`, i.`PRIORITY` FROM `t-career_internship_type` c LEFT JOIN `t-internship_type` i ON c.`INTERNSHIP_TYPE_ID` = i.`INTERNSHIP_TYPE_ID` WHERE c.`CAREER_ID` = :carrera";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':carrera', $carrera);
        $statement->execute();
        $internshipTypes = $statement->fetchAll(PDO::FETCH_ASSOC);
        $consulta2 = "SELECT * FROM `t-tutors` WHERE `STATUS` = 1";
        $statement2 = $this->pdo->prepare($consulta2);
        $statement2->execute();
        $tutores = $statement2->fetchAll(PDO::FETCH_ASSOC);
        $consulta3 = "SELECT * FROM `t-institution` WHERE `STATUS` = 1";
        $statement3 = $this->pdo->prepare($consulta3);
        $statement3->execute();
        $instituciones = $statement3->fetchAll(PDO::FETCH_ASSOC);
        $combo = [];
        $combo['internship_types'] = $internshipTypes;
        $combo['tutores'] = $tutores;
        $combo['instituciones'] = $instituciones;
        return $combo;

    }

    /**
 * Verifica si ya existe una preinscripción activa para un estudiante en un período determinado.
 * @param int $studentId El ID del estudiante.
 * @param int $periodId El ID del período.
 * @param int|null $currentId El ID de la preinscripción actual que se está actualizando (opcional, para excluirla de la verificación).
 * @return bool Devuelve true si se encuentra un duplicado activo, de lo contrario false.
     */
    public function checkDuplicateActivePreinscripcion($studentId, $periodId, $currentId = null) {
        $sql = "SELECT COUNT(*) FROM `t-professional_practices`
                WHERE `STUDENTS_ID` = :student_id
                AND `PERIOD_ID` = :period_id
                AND `STATUS` = 1
                AND `PRACTICES_STATUS` = 1"; // Assuming PRACTICES_STATUS = 1 means 'pre-registered' or 'active pre-registration'

        if ($currentId !== null) {
            $sql .= " AND `PROFESSIONAL_PRACTICE_ID` != :current_id";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $studentId);
        $stmt->bindValue(':period_id', $periodId);
        if ($currentId !== null) { $stmt->bindValue(':current_id', $currentId); }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

   /**
 * Verifica si un estudiante ya está en un proceso de práctica profesional (no culminada y aprobada).
 * @param int $studentId El ID del estudiante.
 * @param int|null $currentId El ID del registro actual a excluir de la verificación (en caso de actualización).
     */
    public function isStudentInProcess($studentId, $currentId = null) {
        $sql = "SELECT COUNT(*) FROM `t-professional_practices`
                WHERE `STUDENTS_ID` = :student_id
                AND `STATUS` = 1 -- Only consider active records
                -- PRACTICES_STATUS: 1=Preinscrito, 2=Inscrito, 3=Culminado
                -- INTERSHIP_STATUS: 1=En Curso, 2=Aprobado, 3=Reprobado
                AND NOT (`PRACTICES_STATUS` = 3 AND `INTERSHIP_STATUS` = 2)"; // Not (Culminado AND Aprobado)

        if ($currentId !== null) {
            $sql .= " AND `PROFESSIONAL_PRACTICE_ID` != :current_id";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $studentId);
        if ($currentId !== null) { $stmt->bindValue(':current_id', $currentId); }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    /**
 * Verifica si ya existe CUALQUIER preinscripción (activa o inactiva) para un estudiante en un período.
 * @param int $studentId El ID del estudiante.
 * @param int $periodId El ID del período.
 * @param int|null $currentId El ID de la preinscripción actual a excluir (opcional).
 * @return bool Devuelve true si se encuentra un duplicado, de lo contrario false.
     */
    public function checkAnyDuplicatePreinscripcion($studentId, $periodId, $currentId = null) {
        $sql = "SELECT COUNT(*) FROM `t-professional_practices`
                WHERE `STUDENTS_ID` = :student_id
                AND `PERIOD_ID` = :period_id
                AND `PRACTICES_STATUS` = 1"; // Check only pre-registrations, regardless of their active/inactive status

        if ($currentId !== null) {
            $sql .= " AND `PROFESSIONAL_PRACTICE_ID` != :current_id";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $studentId);
        $stmt->bindValue(':period_id', $periodId);
        if ($currentId !== null) { $stmt->bindValue(':current_id', $currentId); }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
 * Verifica si un estudiante puede registrarse para un tipo de práctica específico según la prioridad.
 * @param int $studentId El ID del estudiante.
 * @param int $internshipTypeId El ID del tipo de práctica para el que se intenta registrar.
 * @param int|null $currentId El ID del registro actual a excluir (en caso de actualización).
 * @return bool|string Devuelve true si está permitido, o una cadena de error si no.
     */
    public function canRegisterForPracticeType($studentId, $internshipTypeId, $currentId = null) {
        // Get the priority of the new practice type
        $sqlPriority = "SELECT PRIORITY FROM `t-internship_type` WHERE INTERNSHIP_TYPE_ID = :internship_type_id";
        $stmtPriority = $this->pdo->prepare($sqlPriority);
        $stmtPriority->bindValue(':internship_type_id', $internshipTypeId);
        $stmtPriority->execute();
        $newPractice = $stmtPriority->fetch(PDO::FETCH_ASSOC);

        if (!$newPractice) {
            return "INVALID_PRACTICE_TYPE"; // Practice type does not exist
        }

        $priority = (int)$newPractice['PRIORITY'];

        // Check if a practice with this priority already exists for the student
        $sqlCheckExists = "SELECT COUNT(*) FROM `t-professional_practices` pp
                           JOIN `t-internship_type` it ON pp.INTERNSHIP_TYPE_ID = it.INTERNSHIP_TYPE_ID
                           WHERE pp.STUDENTS_ID = :student_id AND it.PRIORITY = :priority";
        if ($currentId !== null) {
            $sqlCheckExists .= " AND pp.PROFESSIONAL_PRACTICE_ID != :current_id";
        }
        $stmtCheckExists = $this->pdo->prepare($sqlCheckExists);
        $stmtCheckExists->bindValue(':student_id', $studentId);
        $stmtCheckExists->bindValue(':priority', $priority);
        if ($currentId !== null) {
            $stmtCheckExists->bindValue(':current_id', $currentId);
        }
        $stmtCheckExists->execute();
        if ($stmtCheckExists->fetchColumn() > 0) {
            return "PRIORITY_ALREADY_REGISTERED";
        }

        if ($priority === 1 || $priority === 0) {
            return true; // La prioridad 0 y 1 siempre se permiten como primera práctica.
        }

        // For priorities > 1, check if the previous one is completed AND approved.
        $requiredPriority = $priority - 1;

        $sqlCheck = "SELECT COUNT(*) 
                     FROM `t-professional_practices` pp
                     JOIN `t-internship_type` it ON pp.INTERNSHIP_TYPE_ID = it.INTERNSHIP_TYPE_ID
                     WHERE pp.STUDENTS_ID = :student_id
                       AND pp.PRACTICES_STATUS = 3 -- 3 = Culminado
                       AND pp.INTERSHIP_STATUS = 2 -- 2 = Aprobado
                       AND it.PRIORITY = :required_priority";
        
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute([':student_id' => $studentId, ':required_priority' => $requiredPriority]);
        
        return $stmtCheck->fetchColumn() > 0 ? true : "PRIORITY_VIOLATION_NEEDS_" . $requiredPriority;
    }

    /**
 * Lista todas las inscripciones activas.
     * @return array Un array de inscripciones activas.
     */
    public function listarInscripcionesActivos() {
        $consulta = "SELECT 
                i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                s.`STUDENTS_ID`,
                CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                ta.`NAME` AS TUTOR_ACADEMICO_NOMBRE,
                ta.`SURNAME` AS TUTOR_ACADEMICO_APELLIDO,
                tm.`NAME` AS TUTOR_METODOLOGICO_NOMBRE,
                tm.`SURNAME` AS TUTOR_METODOLOGICO_APELLIDO,
                inst.`INSTITUTION_NAME`,
                r.`NAME` AS RESPONSABLE_NOMBRE,
                r.`SURNAME` AS RESPONSABLE_APELLIDO
            FROM `t-professional_practices` i
            LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
            LEFT JOIN `t-tutors` ta ON i.`TUTOR_ID` = ta.`TUTOR_ID`
            LEFT JOIN `t-tutors` tm ON i.`TUTOR_M_ID` = tm.`TUTOR_ID`
            LEFT JOIN `t-institution` inst ON i.`INSTITUTION_ID` = inst.`INSTITUTION_ID`
            LEFT JOIN `t-institution_manager` r ON i.`MANAGER_ID` = r.`MANAGER_ID`
            WHERE i.`STATUS` = 1 AND i.`PRACTICES_STATUS` = 2
        ";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Lista todas las inscripciones inactivas.
     * @return array Un array de inscripciones inactivas.
     */
    public function listarInscripcionesInactivos() {
        $consulta = "SELECT 
                i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                s.`STUDENTS_ID`,
                CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                ta.`NAME` AS TUTOR_ACADEMICO_NOMBRE,
                ta.`SURNAME` AS TUTOR_ACADEMICO_APELLIDO,
                tm.`NAME` AS TUTOR_METODOLOGICO_NOMBRE,
                tm.`SURNAME` AS TUTOR_METODOLOGICO_APELLIDO,
                inst.`INSTITUTION_NAME`,
                r.`NAME` AS RESPONSABLE_NOMBRE,
                r.`SURNAME` AS RESPONSABLE_APELLIDO
            FROM `t-professional_practices` i
            LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
            LEFT JOIN `t-tutors` ta ON i.`TUTOR_ID` = ta.`TUTOR_ID`
            LEFT JOIN `t-tutors` tm ON i.`TUTOR_M_ID` = tm.`TUTOR_ID`
            LEFT JOIN `t-institution` inst ON i.`INSTITUTION_ID` = inst.`INSTITUTION_ID`
            LEFT JOIN `t-institution_manager` r ON i.`MANAGER_ID` = r.`MANAGER_ID`
            WHERE i.`STATUS` = 0 AND i.`PRACTICES_STATUS` = 2
        ";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Lista los períodos académicos que no están culminados.
     * @return array Un array de períodos.
     */
    public function listarPeriodos() {
        $consulta = "SELECT `PERIOD_ID`, `DESCRIPTION` FROM `t-internships_period` WHERE `STATUS` = 1 AND `PERIOD_STATUS` != 3";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
 * Obtiene los tipos de práctica asociados a una carrera específica.
     * @param int $carreraId El ID de la carrera.
     * @return array Un array con los tipos de práctica.
     */
    public function obtenerTiposPracticaPorCarrera($carreraId) {
        $consulta = "SELECT i.`INTERNSHIP_TYPE_ID`, i.`NAME` 
                     FROM `t-career_internship_type` c
                     LEFT JOIN `t-internship_type` i ON c.`INTERNSHIP_TYPE_ID` = i.`INTERNSHIP_TYPE_ID`
                     WHERE c.`CAREER_ID` = :carreraId";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':carreraId', $carreraId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
 * Lista todas las preinscripciones activas.
     * @return array Un array de preinscripciones activas.
     */
    public function listar_preinscripciones_activos() {
        $consulta = "SELECT 
                i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                s.`STUDENTS_ID`,
                `STUDENTS_CI`,
                CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                s.`CONTACT_PHONE` AS CONTACTO,
                i.`ENROLLMENT`,
                p.`DESCRIPTION` AS PERIOD_DESCRIPTION,
                i.`CREATION_DATE`
            FROM `t-professional_practices` i
            LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
            LEFT JOIN `t-career` c ON s.`CAREER_ID` = c.`CAREER_ID`
            LEFT JOIN `t-internships_period` p ON i.`PERIOD_ID` = p.`PERIOD_ID`
            WHERE i.`STATUS` = 1 AND I.`PRACTICES_STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Lista todas las preinscripciones inactivas.
     * @return array Un array de preinscripciones inactivas.
     */
    public function listar_preinscripciones_inactivos() {
        $consulta = "SELECT 
                i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                s.`STUDENTS_ID`,
                s.`STUDENTS_CI`,
                CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                s.`CONTACT_PHONE` AS CONTACTO,
                i.`ENROLLMENT`,
                p.`DESCRIPTION` AS PERIOD_DESCRIPTION,
                i.`CREATION_DATE`
            FROM `t-professional_practices` i
            LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
            LEFT JOIN `t-internships_period` p ON i.`PERIOD_ID` = p.`PERIOD_ID`
            WHERE i.`STATUS` = 0 AND i.`PRACTICES_STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Lista todas las preinscripciones culminadas y aprobadas.
     * @return array Un array de preinscripciones culminadas aprobadas.
     */
    public function listarCulminadasAprobadas() {
        $consulta = "SELECT
                        i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                        s.`STUDENTS_ID`,
                        s.`STUDENTS_CI`,
                        CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                        COALESCE(s.`CONTACT_PHONE`, '') AS CONTACTO,
                        i.`CULMINATION_DATE`,
                        it.NAME AS TIPO_PRACTICA,
                        i.`ENROLLMENT`,
                        p.`DESCRIPTION` AS PERIOD_DESCRIPTION
                    FROM `t-professional_practices` i
                    LEFT JOIN `t-internship_type` it ON i.`INTERNSHIP_TYPE_ID` = it.`INTERNSHIP_TYPE_ID`
                    LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
                    LEFT JOIN `t-internships_period` p ON i.`PERIOD_ID` = p.`PERIOD_ID`
                    WHERE i.`PRACTICES_STATUS` = 3 AND i.`INTERSHIP_STATUS` = 2"; // Culminado y Aprobado
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Lista todas las preinscripciones culminadas y reprobadas.
     * @return array Un array de preinscripciones culminadas reprobadas.
     */
    public function listarCulminadasReprobadas() {
        $consulta = "SELECT
                        i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                        s.`STUDENTS_ID`,
                        s.`STUDENTS_CI`,
                        CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                        COALESCE(s.`CONTACT_PHONE`, '') AS CONTACTO,
                        i.`CULMINATION_DATE`,
                        it.NAME AS TIPO_PRACTICA,
                        i.`ENROLLMENT`,
                        p.`DESCRIPTION` AS PERIOD_DESCRIPTION
                    FROM `t-professional_practices` i
                    LEFT JOIN `t-internship_type` it ON i.`INTERNSHIP_TYPE_ID` = it.`INTERNSHIP_TYPE_ID`
                    LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
                    LEFT JOIN `t-internships_period` p ON i.`PERIOD_ID` = p.`PERIOD_ID`
                    WHERE i.`PRACTICES_STATUS` = 3 AND i.`INTERSHIP_STATUS` = 3"; // Culminado y Reprobado
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }





    /**
 * Inserta un nuevo registro de preinscripción en la base de datos.
 * @param array $datos Datos de la preinscripción.
     * @return bool|string Devuelve true en caso de éxito, o una cadena de error en caso de fallo.
     */
    public function insertarPreinscripcion($datos) {
        if ($this->checkAnyDuplicatePreinscripcion($datos['estudiante_id'], $datos['periodo'])) {
            return "DUPLICATE_PREINSCRIPTION"; // Special return value for any duplicate
        }
        if ($this->isStudentInProcess($datos['estudiante_id'])) {
            return "STUDENT_ALREADY_INSCRIBED";
        }
        $canRegister = $this->canRegisterForPracticeType($datos['estudiante_id'], $datos['tipo_practica']); // No currentId on insert
        if ($canRegister !== true) {
            return $canRegister; // Returns error string like "PRIORITY_VIOLATION_NEEDS_X"
        }
        $sql = "INSERT INTO `t-professional_practices` 
            (`STUDENTS_ID`, `PERIOD_ID`, `INTERNSHIP_TYPE_ID`, `ENROLLMENT`, `STATUS`, `INTERSHIP_STATUS`,  `PRACTICES_STATUS`, `CREATION_DATE`)
            VALUES (:estudiante_id, :periodo, :tipo_practica ,:matricula ,1, 1, 1, NOW())"; // STATUS=1 (Activo), INTERSHIP_STATUS=1 (En Curso), PRACTICES_STATUS=1 (Preinscrito)
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':estudiante_id', $datos['estudiante_id']);
        $stmt->bindValue(':periodo', $datos['periodo']);
        $stmt->bindValue(':tipo_practica', $datos['tipo_practica']); 
        $stmt->bindValue(':matricula', $datos['matricula']);    
        return $stmt->execute();
    }

    /**
 * Actualiza un registro de preinscripción existente.
 * @param int $id El ID de la preinscripción a actualizar.
 * @param array $datos Los nuevos datos para la preinscripción.
     * @return bool|string Devuelve true en caso de éxito, o una cadena de error en caso de fallo.
     */
    public function actualizarPreinscripcion($id, $datos) {
        if ($this->checkAnyDuplicatePreinscripcion($datos['estudiante_id'], $datos['periodo'], $id)) {
            return "DUPLICATE_PREINSCRIPTION"; // Special return value for any duplicate
        }
        if ($this->isStudentInProcess($datos['estudiante_id'], $id)) {
            return "STUDENT_ALREADY_INSCRIBED";
        }
        $canRegister = $this->canRegisterForPracticeType($datos['estudiante_id'], $datos['tipo_practica'], $id);
        if ($canRegister !== true) {
            return $canRegister; // Returns error string like "PRIORITY_VIOLATION_NEEDS_X"
        }
        $sql = "UPDATE `t-professional_practices` SET 
            `STUDENTS_ID` = :estudiante_id,
            `PERIOD_ID` = :periodo,
            `INTERNSHIP_TYPE_ID` = :tipo_practica
            WHERE `PROFESSIONAL_PRACTICE_ID` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':estudiante_id', $datos['estudiante_id']);
        $stmt->bindValue(':periodo', $datos['periodo']);
        $stmt->bindValue(':tipo_practica', $datos['tipo_practica']);
        return $stmt->execute();
    }

    /**
 * Busca una preinscripción por su ID.
 * @param int $id El ID de la preinscripción.
 * @return array|null Los datos de la preinscripción o null si no se encuentra.
     */
    public function buscarPreinscripcionPorId($id) {
        $sql = "SELECT 
                    i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                    i.`PERIOD_ID`,
                    i.`INTERNSHIP_TYPE_ID`,
                    s.`STUDENTS_ID`,
                    s.`STUDENTS_CI` AS FULL_CEDULA,
                    CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                    s.`CAREER_ID`, i.`ENROLLMENT`
                FROM `t-professional_practices` i
                LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
                WHERE i.`PROFESSIONAL_PRACTICE_ID` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['FULL_CEDULA'])) {
            // Separar NACIONALIDAD y CEDULA del campo FULL_CEDULA (ej: "V-12345678")
            $parts = explode('-', $result['FULL_CEDULA'], 2);
            if (count($parts) == 2) {
                $result['NACIONALIDAD'] = $parts[0];
                $result['CEDULA'] = $parts[1]; // Solo el número de cédula
            } else {
                // Si no tiene el formato esperado, asignar valores por defecto o manejar el error
                $result['NACIONALIDAD'] = ''; 
                $result['CEDULA'] = $result['FULL_CEDULA'];
            }
        }
        return $result;
    }

    /**
 * Busca una inscripción por su ID con todos los detalles necesarios para la vista.
 * @param int $id El ID de la inscripción.
 * @return array|null Los datos de la inscripción o null si no se encuentra.
     */
    public function buscarInscripcionPorId($id) {
        $consulta = "SELECT
                        i.`PROFESSIONAL_PRACTICE_ID` AS INSCRIPCION_ID,
                        s.`STUDENTS_ID`,
                        s.`STUDENTS_CI` AS FULL_CEDULA,
                        CONCAT(s.`NAME`, ' ', s.`SECOND_NAME`, ' ', s.`SURNAME`, ' ', s.`SECOND_SURNAME`) AS ESTUDIANTE,
                        itp.`NAME` AS TIPO_PRACTICA,
                        i.`TUTOR_ID`,
                        i.`TUTOR_M_ID`,
                        i.`INSTITUTION_ID`,
                        i.`MANAGER_ID`,
                        s.`CAREER_ID`
                    FROM `t-professional_practices` i
                    LEFT JOIN `t-students` s ON i.`STUDENTS_ID` = s.`STUDENTS_ID`
                    LEFT JOIN `t-internship_type` itp ON i.`INTERNSHIP_TYPE_ID` = itp.`INTERNSHIP_TYPE_ID`
                    WHERE i.`PROFESSIONAL_PRACTICE_ID` = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Separar NACIONALIDAD y CEDULA
            $parts = explode('-', $result['FULL_CEDULA'], 2);
            if (count($parts) == 2) {
                $result['NACIONALIDAD'] = $parts[0];
                $result['CEDULA'] = $parts[1];
            } else {
                $result['NACIONALIDAD'] = '';
                $result['CEDULA'] = $result['FULL_CEDULA'];
            }
        }
        return $result;
    }







    /**
 * Actualiza una preinscripción a una inscripción formal.
 * Cambia PRACTICES_STATUS a 2 y guarda los datos de los tutores e institución.
     * @return bool Devuelve true en caso de éxito, false en caso de fallo.
     */
    public function inscribirPractica($datos) {
        $sql = "UPDATE `t-professional_practices` SET
                    `TUTOR_ID` = :tutor_academico,
                    `TUTOR_M_ID` = :tutor_metodologico,
                    `INSTITUTION_ID` = :institucion,
                    `MANAGER_ID` = :responsable,
                    `PRACTICES_STATUS` = 2 -- 2 = INSCRIPCION
                WHERE `PROFESSIONAL_PRACTICE_ID` = :id AND `PRACTICES_STATUS` = 1"; // Doble check de seguridad

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':tutor_academico' => $datos['tutor_academico'], ':tutor_metodologico' => $datos['tutor_metodologico'],
            ':institucion' => $datos['institucion'], ':responsable' => $datos['responsable'], ':id' => $datos['id']
        ]);
    }

    /**
 * Actualiza los detalles de una inscripción ya existente.
 * No cambia el estado de la práctica (PRACTICES_STATUS).
 * @param array $datos Datos de la inscripción a actualizar.
 * @return bool Devuelve true en caso de éxito, false en caso de fallo.
     */
    public function actualizarInscripcion($datos) {
        $sql = "UPDATE `t-professional_practices` SET
                    `TUTOR_ID` = :tutor_academico,
                    `TUTOR_M_ID` = :tutor_metodologico,
                    `INSTITUTION_ID` = :institucion,
                    `MANAGER_ID` = :responsable
                WHERE `PROFESSIONAL_PRACTICE_ID` = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':tutor_academico' => $datos['tutor_academico'], ':tutor_metodologico' => $datos['tutor_metodologico'],
            ':institucion' => $datos['institucion'], ':responsable' => $datos['responsable'], ':id' => $datos['id']
        ]);
    }

    /**
 * Actualiza el estado de culminación (INTERSHIP_STATUS) de una práctica profesional.
 * @param int $id El ID de la práctica profesional.
 * @param int $intershipStatus El nuevo estado de la pasantía (2 = Aprobado, 3 = Reprobado).
     * @return bool Devuelve true en caso de éxito, false en caso de fallo.
     */
    public function actualizarEstadoCulminacion($id, $intershipStatus) {
        $sql = "UPDATE `t-professional_practices` SET
                    `INTERSHIP_STATUS` = :intership_status
                WHERE `PROFESSIONAL_PRACTICE_ID` = :id AND `PRACTICES_STATUS` = 3"; // Solo actualizar si ya está culminado

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':intership_status' => $intershipStatus,
            ':id' => $id
        ]);
    }

    /**
 * Culmina una inscripción, actualizando su estado de práctica y de pasantía.
 * @param int $id El ID de la práctica profesional.
 * @param int $intershipStatus El estado final de la pasantía (2 = Aprobado, 3 = Reprobado).
     * @return bool Devuelve true en caso de éxito, false en caso de fallo.
     */
    public function culminarInscripcion($id, $intershipStatus) {
        $sql = "UPDATE `t-professional_practices` SET
                    `PRACTICES_STATUS` = 3, -- 3 = Culminado
                    `INTERSHIP_STATUS` = :intership_status
                WHERE `PROFESSIONAL_PRACTICE_ID` = :id AND `PRACTICES_STATUS` = 2"; // Solo culminar si está en estado 'Inscrito'

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':intership_status' => $intershipStatus,
            ':id' => $id
        ]);
    }
    /**
 * Cambia el estado de una preinscripción (activo/inactivo).
 * @param int $id El ID de la preinscripción.
 * @param int $estado El nuevo estado (1 para activo, 0 para inactivo).
     * @return bool Devuelve true si la operación fue exitosa, de lo contrario false.
     */
    public function cambiarEstadoPreinscripcion($id, $estado) {
        $sql = "UPDATE `t-professional_practices` SET `STATUS` = :estado WHERE `PROFESSIONAL_PRACTICE_ID` = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id' => $id
        ]);
    }

    /**
 * Obtiene el estado actual de una práctica profesional por su ID.
 * @param int $id El ID de la práctica profesional.
 * @return int|null El valor de PRACTICES_STATUS o null si no se encuentra.
     */
    public function getPracticeStatusById($id) {
        $sql = "SELECT PRACTICES_STATUS FROM `t-professional_practices` WHERE PROFESSIONAL_PRACTICE_ID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}
?>