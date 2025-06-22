<?php
// Incluir el archivo de conexión a la base de datos.
// Se asume que 'conexion.php' contiene la clase 'Conexion'
// y un método 'conectar()' que devuelve un objeto PDO.
require_once("conexion.php");

/**
 * Clase Student (Estudiante)
 *
 * Esta clase maneja todas las operaciones relacionadas con los estudiantes en la base de datos.
 * Incluye métodos para insertar, actualizar, eliminar (lógico), recuperar (lógico),
 * obtener, buscar y listar estudiantes. Utiliza PDO para interacciones seguras con la base de datos.
 */
class Student
{
    private $conexion; // Objeto de la clase Conexion
    private $pdo;      // Objeto PDO para las operaciones de base de datos

    /**
     * Constructor de la clase Student.
     *
     * Inicializa la conexión a la base de datos al crear una instancia de la clase.
     * Se conecta a la base de datos utilizando la clase 'Conexion'.
     */
    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    /**
     * Obtiene un estudiante por su ID.
     *
     * @param int $id El ID único del estudiante.
     * @return array|false Un array asociativo con los datos del estudiante si se encuentra,
     * o false si no se encuentra o si ocurre un error en la consulta.
     */
    public function getStudentbyId($id)
    {
        try {
            $sql = "SELECT * FROM `t-students` WHERE `STUDENTS_ID` = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            // Vincula el ID como un entero para mayor seguridad
            $stmt->bindValue(':STUDENTS_ID', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Registra el error para depuración sin exponerlo al usuario
            error_log("Error al obtener estudiante por ID: " . $e->getMessage());
            return false; // Indica fallo
        }
    }

    /**
     * Obtiene un estudiante por su número de Cédula de Identidad (CI).
     *
     * @param string $ci El número de Cédula de Identidad del estudiante.
     * @return array|false Un array asociativo con los datos del estudiante si se encuentra,
     * o false si no se encuentra o si ocurre un error en la consulta.
     */
    public function getStudentbyCI($ci)
    {
        try {
            $sql = "SELECT * FROM `t-students` WHERE `STUDENTS_CI` = :STUDENTS_CI";
            $stmt = $this->pdo->prepare($sql);
            // Vincula el CI como una cadena
            $stmt->bindValue(':STUDENTS_CI', $ci, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener estudiante por CI: " . $e->getMessage());
            return false; // Indica fallo
        }
    }

    /**
     * Obtiene todos los estudiantes activos de una carrera específica.
     *
     * @param int $id El ID de la carrera.
     * @return array Un array de arrays asociativos, cada uno representando un estudiante,
     * o un array vacío si no hay resultados o si ocurre un error.
     */
    public function getStudentByCareer($id)
    {
        try {
            // Se añade 'AND `STATUS` = 1' para obtener solo estudiantes activos
            $sql = "SELECT * FROM `t-students` WHERE `CAREER_ID` = :CAREER_ID AND `STATUS` = 1";
            $stmt = $this->pdo->prepare($sql);
            // Vincula el ID de la carrera como un entero
            $stmt->bindValue(':CAREER_ID', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener estudiantes por carrera: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }

    /**
     * Obtiene una lista de todos los estudiantes (activos e inactivos) con el nombre de su carrera.
     *
     * @return array Un array de arrays asociativos con los datos de todos los estudiantes,
     * o un array vacío si no hay resultados o si ocurre un error.
     */
    public function getAllStudents()
    {
        try {
            $sql = "SELECT s.`STUDENTS_ID`, s.`STUDENTS_CI`, CONCAT(s.`NAME`,' ',s.`SECOND_NAME`) AS `NAME`, CONCAT(s.`SURNAME`,' ',s.`SECOND_SURNAME`) AS `SURNAME`, s.`GENDER`, s.`CONTACT_PHONE`, s.`EMAIL`, c.CAREER_NAME, s.`STATUS`
                    FROM `t-students` s
                    LEFT JOIN `t-career` c ON s.`CAREER_ID` = c.`CAREER_ID`";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener todos los estudiantes: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }

    /**
     * Inserta un nuevo estudiante en la base de datos.
     *
     * @param string $STUDENTS_CI Cédula de Identidad del estudiante (único).
     * @param string $NAME Primer nombre.
     * @param string $SECOND_NAME Segundo nombre.
     * @param string $SURNAME Primer apellido.
     * @param string $SECOND_SURNAME Segundo apellido.
     * @param string $GENDER Género (ej. 'M', 'F').
     * @param string $BIRTHDATE Fecha de nacimiento (formato 'YYYY-MM-DD').
     * @param string $CONTACT_PHONE Número de teléfono de contacto.
     * @param string $EMAIL Correo electrónico (único).
     * @param string $ADDRESS Dirección de residencia.
     * @param string $MARITAL_STATUS Estado civil.
     * @param int $SEMESTER Semestre actual.
     * @param int $SECTION Sección.
     * @param string $REGIME Régimen (ej. 'DIURNO', 'NOCTURNO').
     * @param string $STUDENT_TYPE Tipo de estudiante (ej. 'CIV', 'MIL').
     * @param string $MILITARY_RANK Rango militar (si aplica).
     * @param string $EMPLOYMENT Estado de empleo.
     * @param int $CAREER_ID ID de la carrera a la que pertenece el estudiante.
     * @return bool True si la inserción fue exitosa, false en caso contrario (incluyendo duplicados de CI o EMAIL).
     */
    public function insertStudent(
        $STUDENTS_CI, $NAME, $SECOND_NAME, $SURNAME, $SECOND_SURNAME, $GENDER, $BIRTHDATE,
        $CONTACT_PHONE, $EMAIL, $ADDRESS, $MARITAL_STATUS, $SEMESTER, $SECTION, $REGIME,
        $STUDENT_TYPE, $MILITARY_RANK, $EMPLOYMENT, $CAREER_ID
    ) {
        try {
            $this->pdo->beginTransaction(); // Inicia una transacción para asegurar la integridad de los datos

            $sql = "INSERT INTO `t-students`(
                        `STUDENTS_CI`, `NAME`, `SECOND_NAME`, `SURNAME`, `SECOND_SURNAME`,
                        `GENDER`, `BIRTHDATE`, `CONTACT_PHONE`, `EMAIL`, `ADDRESS`,
                        `MARITAL_STATUS`, `SEMESTER`, `SECTION`, `REGIME`, `STUDENT_TYPE`,
                        `MILITARY_RANK`, `EMPLOYMENT`, `STATUS`, `REGISTRATION_DATE`, `CAREER_ID`
                    ) VALUES (
                        :STUDENTS_CI, :NAME, :SECOND_NAME, :SURNAME, :SECOND_SURNAME,
                        :GENDER, :BIRTHDATE, :CONTACT_PHONE, :EMAIL, :ADDRESS,
                        :MARITAL_STATUS, :SEMESTER, :SECTION, :REGIME, :STUDENT_TYPE,
                        :MILITARY_RANK, :EMPLOYMENT, :STATUS, :REGISTRATION_DATE, :CAREER_ID
                    )";
            $stmt = $this->pdo->prepare($sql);

            // Vinculación de parámetros con tipos explícitos para mayor seguridad y evitar SQL injection
            $stmt->bindValue(":STUDENTS_CI", strtoupper($STUDENTS_CI), PDO::PARAM_STR);
            $stmt->bindValue(":NAME", strtoupper($NAME), PDO::PARAM_STR);
            $stmt->bindValue(":SECOND_NAME", strtoupper($SECOND_NAME), PDO::PARAM_STR);
            $stmt->bindValue(":SURNAME", strtoupper($SURNAME), PDO::PARAM_STR);
            $stmt->bindValue(":SECOND_SURNAME", strtoupper($SECOND_SURNAME), PDO::PARAM_STR);
            $stmt->bindValue(":GENDER", strtoupper($GENDER), PDO::PARAM_STR);
            $stmt->bindValue(":BIRTHDATE", $BIRTHDATE, PDO::PARAM_STR); // Asume formato YYYY-MM-DD
            $stmt->bindValue(":CONTACT_PHONE", $CONTACT_PHONE, PDO::PARAM_STR);
            $stmt->bindValue(":EMAIL", strtolower($EMAIL), PDO::PARAM_STR); // Correo siempre en minúsculas
            $stmt->bindValue(":ADDRESS", strtoupper($ADDRESS), PDO::PARAM_STR);
            $stmt->bindValue(":MARITAL_STATUS", strtoupper($MARITAL_STATUS), PDO::PARAM_STR);
            $stmt->bindValue(":SEMESTER", $SEMESTER, PDO::PARAM_INT);
            $stmt->bindValue(":SECTION", $SECTION, PDO::PARAM_INT);
            $stmt->bindValue(":REGIME", strtoupper($REGIME), PDO::PARAM_STR);
            $stmt->bindValue(":STUDENT_TYPE", strtoupper($STUDENT_TYPE), PDO::PARAM_STR);
            $stmt->bindValue(":MILITARY_RANK", strtoupper($MILITARY_RANK), PDO::PARAM_STR);
            $stmt->bindValue(":EMPLOYMENT", strtoupper($EMPLOYMENT), PDO::PARAM_STR);
            $stmt->bindValue(":REGISTRATION_DATE", date("Y-m-d H:i:s"), PDO::PARAM_STR); // Fecha y hora actual
            $stmt->bindValue(":CAREER_ID", $CAREER_ID, PDO::PARAM_INT);
            $stmt->bindValue(":STATUS", 1, PDO::PARAM_INT); // Estado activo por defecto (1 para activo)

            $stmt->execute();
            $this->pdo->commit(); // Confirma la transacción si todo fue exitoso
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Revierte la transacción en caso de error
            // Código de error 23000 es para violaciones de unicidad (ej. clave duplicada)
            if ($e->getCode() == "23000") {
                error_log("Error de duplicidad al insertar estudiante (CI o Email ya existe): " . $e->getMessage());
            } else {
                error_log("Error al insertar estudiante: " . $e->getMessage());
            }
            return false; // Indica que la inserción falló
        }
    }

    /**
     * Cambia el estado de un estudiante a inactivo (eliminación lógica).
     * No elimina el registro físicamente de la base de datos.
     *
     * @param int $id El ID del estudiante a "eliminar" (cambiar estado).
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function deleteStudent($id)
    {
        try {
            $this->pdo->beginTransaction(); // Inicia una transacción
            $sql = "UPDATE `t-students` SET `STATUS` = :STATUS WHERE `STUDENTS_ID` = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':STUDENTS_ID', $id, PDO::PARAM_INT);
            $stmt->bindValue(":STATUS", 0, PDO::PARAM_INT); // 0 para estado inactivo
            $stmt->execute();
            $this->pdo->commit(); // Confirma la transacción
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Revierte la transacción
            error_log("Error al eliminar (lógico) estudiante: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cambia el estado de un estudiante a activo (recuperación lógica).
     *
     * @param int $id El ID del estudiante a "recuperar" (cambiar estado).
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function recoverStudent($id)
    {
        try {
            $this->pdo->beginTransaction(); // Inicia una transacción
            $sql = "UPDATE `t-students` SET `STATUS` = :STATUS WHERE `STUDENTS_ID` = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':STUDENTS_ID', $id, PDO::PARAM_INT);
            $stmt->bindValue(":STATUS", 1, PDO::PARAM_INT); // 1 para estado activo
            $stmt->execute();
            $this->pdo->commit(); // Confirma la transacción
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Revierte la transacción
            error_log("Error al recuperar estudiante: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza los datos de un estudiante existente.
     *
     * @param int $STUDENTS_ID ID del estudiante a actualizar.
     * @param string $STUDENTS_CI Cédula del estudiante.
     * @param string $NAME Primer nombre.
     * @param string $SECOND_NAME Segundo nombre.
     * @param string $SURNAME Primer apellido.
     * @param string $SECOND_SURNAME Segundo apellido.
     * @param string $GENDER Género.
     * @param string $BIRTHDATE Fecha de nacimiento.
     * @param string $CONTACT_PHONE Teléfono de contacto.
     * @param string $EMAIL Correo electrónico.
     * @param string $ADDRESS Dirección.
     * @param string $MARITAL_STATUS Estado civil.
     * @param int $SEMESTER Semestre.
     * @param int $SECTION Sección.
     * @param string $REGIME Régimen.
     * @param string $STUDENT_TYPE Tipo de estudiante (CIV/MIL).
     * @param string $MILITARY_RANK Rango militar (si aplica).
     * @param string $EMPLOYMENT Estado de empleo.
     * @param int $CAREER_ID ID de la carrera.
     * @return bool True si la actualización fue exitosa, false en caso contrario (incluyendo duplicados).
     */
    public function updateStudent(
        $STUDENTS_ID, $STUDENTS_CI, $NAME, $SECOND_NAME, $SURNAME, $SECOND_SURNAME, $GENDER, $BIRTHDATE,
        $CONTACT_PHONE, $EMAIL, $ADDRESS, $MARITAL_STATUS, $SEMESTER, $SECTION, $REGIME,
        $STUDENT_TYPE, $MILITARY_RANK, $EMPLOYMENT, $CAREER_ID
    ) {
        try {
            $this->pdo->beginTransaction(); // Inicia una transacción

            $sql = "UPDATE `t-students` SET
                        `STUDENTS_CI`=:STUDENTS_CI, `NAME`=:NAME, `SECOND_NAME`=:SECOND_NAME, `SURNAME`=:SURNAME,
                        `SECOND_SURNAME`=:SECOND_SURNAME, `GENDER`=:GENDER, `BIRTHDATE`=:BIRTHDATE,
                        `CONTACT_PHONE`=:CONTACT_PHONE, `EMAIL`=:EMAIL, `ADDRESS`=:ADDRESS,
                        `MARITAL_STATUS`=:MARITAL_STATUS, `SEMESTER`=:SEMESTER, `SECTION`=:SECTION,
                        `REGIME`=:REGIME, `STUDENT_TYPE`=:STUDENT_TYPE, `MILITARY_RANK`=:MILITARY_RANK,
                        `EMPLOYMENT`=:EMPLOYMENT, `CAREER_ID`=:CAREER_ID
                    WHERE `STUDENTS_ID` = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);

            // Vinculación de parámetros con tipos explícitos
            $stmt->bindValue(":STUDENTS_ID", $STUDENTS_ID, PDO::PARAM_INT);
            $stmt->bindValue(":STUDENTS_CI", strtoupper($STUDENTS_CI), PDO::PARAM_STR);
            $stmt->bindValue(":NAME", strtoupper($NAME), PDO::PARAM_STR);
            $stmt->bindValue(":SECOND_NAME", strtoupper($SECOND_NAME), PDO::PARAM_STR);
            $stmt->bindValue(":SURNAME", strtoupper($SURNAME), PDO::PARAM_STR);
            $stmt->bindValue(":SECOND_SURNAME", strtoupper($SECOND_SURNAME), PDO::PARAM_STR);
            $stmt->bindValue(":GENDER", strtoupper($GENDER), PDO::PARAM_STR);
            $stmt->bindValue(":BIRTHDATE", $BIRTHDATE, PDO::PARAM_STR);
            $stmt->bindValue(":CONTACT_PHONE", $CONTACT_PHONE, PDO::PARAM_STR); // Puede contener caracteres no alfanuméricos
            $stmt->bindValue(":EMAIL", strtolower($EMAIL), PDO::PARAM_STR);
            $stmt->bindValue(":ADDRESS", strtoupper($ADDRESS), PDO::PARAM_STR);
            $stmt->bindValue(":MARITAL_STATUS", strtoupper($MARITAL_STATUS), PDO::PARAM_STR);
            $stmt->bindValue(":SEMESTER", $SEMESTER, PDO::PARAM_INT);
            $stmt->bindValue(":SECTION", $SECTION, PDO::PARAM_INT);
            $stmt->bindValue(":REGIME", strtoupper($REGIME), PDO::PARAM_STR);
            $stmt->bindValue(":STUDENT_TYPE", strtoupper($STUDENT_TYPE), PDO::PARAM_STR);
            $stmt->bindValue(":MILITARY_RANK", strtoupper($MILITARY_RANK), PDO::PARAM_STR);
            $stmt->bindValue(":EMPLOYMENT", strtoupper($EMPLOYMENT), PDO::PARAM_STR);
            $stmt->bindValue(":CAREER_ID", $CAREER_ID, PDO::PARAM_INT);

            $stmt->execute();
            $this->pdo->commit(); // Confirma la transacción
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Revierte la transacción en caso de error
            // Manejo específico para errores de duplicidad (ej. CI o Email ya existen para otro estudiante)
            if ($e->getCode() == "23000") {
                error_log("Error de duplicidad al actualizar estudiante (CI o Email ya existe en otro registro): " . $e->getMessage());
            } else {
                error_log("Error al actualizar estudiante: " . $e->getMessage());
            }
            return false; // Indica que la actualización falló
        }
    }

    /**
     * Busca un estudiante por correo electrónico.
     * Útil para verificar la existencia de un correo.
     *
     * @param string $email El correo electrónico a buscar.
     * @return array|false Un array asociativo con los datos del estudiante si se encuentra,
     * o false si no se encuentra o si ocurre un error en la consulta.
     */
    public function getStudentByEmail($email)
    {
        try {
            $sql = "SELECT * FROM `t-students` WHERE `EMAIL` = :EMAIL";
            $stmt = $this->pdo->prepare($sql);
            // Vincula el email como una cadena, convirtiéndolo a minúsculas para una búsqueda consistente
            $stmt->bindValue(':EMAIL', strtolower($email), PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al buscar estudiante por email: " . $e->getMessage());
            return false; // Indica fallo
        }
    }

    /**
     * Busca un estudiante por correo electrónico, excluyendo un ID específico.
     * Esto es útil para verificar la unicidad de un correo electrónico al actualizar
     * los datos de un estudiante, asegurando que el correo no sea el mismo de otro estudiante.
     *
     * @param string $email El correo electrónico a buscar.
     * @param int $id El ID del estudiante a excluir de la búsqueda (el estudiante actual que se está editando).
     * @return array|false Un array asociativo con los datos del estudiante encontrado si hay una coincidencia
     * (es decir, el email ya está en uso por otro estudiante), o false si no hay
     * coincidencias o si ocurre un error.
     */
    public function getStudentByEmailExceptId($email, $id)
    {
        try {
            $sql = "SELECT * FROM `t-students` WHERE `EMAIL` = :EMAIL AND `STUDENTS_ID` != :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            // Vincula el email como cadena y el ID a excluir como entero
            $stmt->bindValue(':EMAIL', strtolower($email), PDO::PARAM_STR);
            $stmt->bindValue(':STUDENTS_ID', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al buscar estudiante por email (excluyendo ID): " . $e->getMessage());
            return false; // Indica fallo
        }
    }

    /**
     * Obtiene el conteo de estudiantes activos por cada carrera.
     *
     * @return array Un array de arrays asociativos, cada uno con 'CAREER_NAME' y 'student_count',
     * o un array vacío si no hay resultados o si ocurre un error.
     */
    public function getStudentCountByCareer()
    {
        try {
            // Se añade 's.STATUS = 1' en el JOIN para contar solo estudiantes activos
            $sql = "SELECT c.CAREER_NAME, COUNT(s.STUDENTS_ID) AS student_count
                    FROM `t-career` c
                    LEFT JOIN `t-students` s ON c.CAREER_ID = s.CAREER_ID AND s.STATUS = 1
                    GROUP BY c.CAREER_NAME";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener conteo de estudiantes por carrera: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }
}
?>
