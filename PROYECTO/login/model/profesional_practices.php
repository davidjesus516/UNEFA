<?php
require_once("conexion.php");

class ProfesionalPractices
{
    private $conexion;
    private $pdo;

    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }
    
    /**
     * Buscar institución por cédula
     * @param string $cedula Cédula a buscar
     * @return array|null Datos de la institución o null si no existe
     */
    public function buscarPorCedula($cedula) {
        $consulta = "SELECT `STUDENTS_ID`, CONCAT(`NAME`,' ',`SECOND_NAME`,' ',`SURNAME`,' ',`SECOND_SURNAME`) AS `NOMBRE_COMPLETO` , `CAREER_ID` FROM `t-students`
                    WHERE `STUDENTS_CI` = :cedula 
                    AND `STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula', $cedula);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    /**
     * Cargar responsables (tutores) de una institución
     * @param int $institucionId ID de la institución
     * @return array Lista de responsables
     */
    public function cargarResponsables($institucionId) {
        $consulta = "SELECT * FROM `t-institution_manager` WHERE `INSTITUTION_ID` = :institucionId AND `STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':institucionId', $institucionId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Obtener combos para prácticas profesionales
     * @param int $carrera ID de la carrera
     * @return array Combos de tipos de prácticas, tutores e instituciones
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
    public function listarActivos() {
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
            WHERE i.`STATUS` = 1
        ";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarInactivos() {
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
            WHERE i.`STATUS` = 0
        ";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>