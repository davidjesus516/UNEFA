<?php
//me voy a traer la conexion
require_once("conexion.php");

//instancio la clase usuario
class Student 
{
    //creo los atributos
    private $conexion;
    private $pdo;

    //hago el metodo constructor para usar la conexion en todo lo que va de la clase
    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    public function getStudentbyId($id) {
        $sql = "SELECT * FROM `t-students` WHERE `STUDENTS_ID` = :STUDENTS_ID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':STUDENTS_ID', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getStudentbyCI($ci) {
        $sql = "SELECT * FROM `t-students` WHERE `STUDENTS_CI` = :STUDENTS_CI";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':STUDENTS_CI', $ci);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getStudentByCareer($id) {
        $sql = "SELECT * FROM `t-students` WHERE `CAREER_ID` = :CAREER_ID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':CAREER_ID', $id);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getAllStudents() {
        $sql = "SELECT s.`STUDENTS_ID`, s.`STUDENTS_CI`, CONCAT(s.`NAME`,' ',s.`SECOND_NAME`) AS `NAME`, CONCAT(s.`SURNAME`,' ',s.`SECOND_SURNAME`) AS `SURNAME`, s.`GENDER`, s.`CONTACT_PHONE`, s.`EMAIL`, c.CAREER_NAME, s.`STATUS`
                FROM `t-students` s
                LEFT JOIN `t-career` c ON s.`CAREER_ID` = c.`CAREER_ID`";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function insertStudent($STUDENTS_CI, $NAME, $SECOND_NAME, $SURNAME, $SECOND_SURNAME, $GENDER, $BIRTHDATE, $CONTACT_PHONE, $EMAIL, $ADDRESS, $MARITAL_STATUS, $SEMESTER, $SECTION, $REGIME, $STUDENT_TYPE, $MILITARY_RANK, $EMPLOYMENT, $CAREER_ID)
    {try {
        $this->pdo->beginTransaction();
        $consulta = "INSERT INTO `t-students`( `STUDENTS_CI`, `NAME`, `SECOND_NAME`, `SURNAME`, `SECOND_SURNAME`, `GENDER`, `BIRTHDATE`, `CONTACT_PHONE`, `EMAIL`, `ADDRESS`, `MARITAL_STATUS`, `SEMESTER`, `SECTION`, `REGIME`, `STUDENT_TYPE`, `MILITARY_RANK`, `EMPLOYMENT`, `STATUS`, `REGISTRATION_DATE`, `CAREER_ID`) VALUES (:STUDENTS_CI, :NAME, :SECOND_NAME, :SURNAME, :SECOND_SURNAME, :GENDER, :BIRTHDATE, :CONTACT_PHONE, :EMAIL, :ADDRESS, :MARITAL_STATUS, :SEMESTER, :SECTION, :REGIME, :STUDENT_TYPE, :MILITARY_RANK, :EMPLOYMENT, :STATUS, :REGISTRATION_DATE, :CAREER_ID) ";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":STUDENTS_CI", strtoupper($STUDENTS_CI));
        $statement->bindValue(":NAME", strtoupper($NAME));
        $statement->bindValue(":SECOND_NAME", strtoupper($SECOND_NAME));
        $statement->bindValue(":SURNAME", strtoupper($SURNAME));
        $statement->bindValue(":SECOND_SURNAME", strtoupper($SECOND_SURNAME));
        $statement->bindValue(":GENDER", strtoupper($GENDER));
        $statement->bindValue(":BIRTHDATE", $BIRTHDATE);
        $statement->bindValue(":CONTACT_PHONE", strtoupper($CONTACT_PHONE));
        $statement->bindValue(":EMAIL", strtoupper($EMAIL));
        $statement->bindValue(":ADDRESS", strtoupper($ADDRESS));
        $statement->bindValue(":MARITAL_STATUS", strtoupper($MARITAL_STATUS));
        $statement->bindValue(":SEMESTER", strtoupper($SEMESTER));
        $statement->bindValue(":SECTION", strtoupper($SECTION));
        $statement->bindValue(":REGIME", strtoupper($REGIME));
        $statement->bindValue(":STUDENT_TYPE", strtoupper($STUDENT_TYPE));
        $statement->bindValue(":MILITARY_RANK", strtoupper($MILITARY_RANK));
        $statement->bindValue(":EMPLOYMENT", strtoupper($EMPLOYMENT));
        $statement->bindValue(":REGISTRATION_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":CAREER_ID", $CAREER_ID);
        $statement->bindValue(":STATUS", 1);
        $statement->execute();
        $this->pdo->commit();
        return true;
    } catch (PDOException $e) {
    if ($e->getCode() == "23000") { // Código de error para clave duplicada
        return false; // Usuario duplicado
    } else {
        $this->pdo->rollBack();
        throw $e; // Se lanza la excepción para manejarla en otro lugar
    }
}
}

    public function deleteStudent($id) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-students`SET `STATUS`=:STATUS WHERE STUDENTS_ID = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':STUDENTS_ID', $id);
            $stmt->bindValue(":STATUS", 0);
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
        $this->pdo->rollBack();
        throw $e; // Se lanza la excepción para manejarla en otro lugar
}
    }

    public function recoverStudent($id) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-students` SET `STATUS`=:STATUS WHERE STUDENTS_ID = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':STUDENTS_ID', $id);
            $stmt->bindValue(":STATUS", 1);
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function updateStudent($STUDENTS_ID,$STUDENTS_CI, $NAME, $SECOND_NAME, $SURNAME, $SECOND_SURNAME, $GENDER, $BIRTHDATE, $CONTACT_PHONE, $EMAIL, $ADDRESS, $MARITAL_STATUS, $SEMESTER, $SECTION, $REGIME, $STUDENT_TYPE, $MILITARY_RANK, $EMPLOYMENT, $CAREER_ID){
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-students` SET `STUDENTS_CI`=:STUDENTS_CI,`NAME`=:NAME,`SECOND_NAME`=:SECOND_NAME,`SURNAME`=:SURNAME,`SECOND_SURNAME`=:SECOND_SURNAME,`GENDER`=:GENDER,`BIRTHDATE`=:BIRTHDATE,`CONTACT_PHONE`=:CONTACT_PHONE,`EMAIL`=:EMAIL,`ADDRESS`=:ADDRESS,`MARITAL_STATUS`=:MARITAL_STATUS,`SEMESTER`=:SEMESTER,`SECTION`=:SECTION,`REGIME`=:REGIME,`STUDENT_TYPE`=:STUDENT_TYPE,`MILITARY_RANK`=:MILITARY_RANK,`EMPLOYMENT`=:EMPLOYMENT,`CAREER_ID`=:CAREER_ID WHERE `STUDENTS_ID` = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":STUDENTS_ID", $STUDENTS_ID);
            $stmt->bindValue(":STUDENTS_CI", strtoupper($STUDENTS_CI));
            $stmt->bindValue(":NAME", strtoupper($NAME));
            $stmt->bindValue(":SECOND_NAME", strtoupper($SECOND_NAME));
            $stmt->bindValue(":SURNAME", strtoupper($SURNAME));
            $stmt->bindValue(":SECOND_SURNAME", strtoupper($SECOND_SURNAME));
            $stmt->bindValue(":GENDER", strtoupper($GENDER));
            $stmt->bindValue(":BIRTHDATE", $BIRTHDATE);
            $stmt->bindValue(":CONTACT_PHONE", strtoupper($CONTACT_PHONE));
            $stmt->bindValue(":EMAIL", strtoupper($EMAIL));
            $stmt->bindValue(":ADDRESS", strtoupper($ADDRESS));
            $stmt->bindValue(":MARITAL_STATUS", strtoupper($MARITAL_STATUS));
            $stmt->bindValue(":SEMESTER", strtoupper($SEMESTER));
            $stmt->bindValue(":SECTION", strtoupper($SECTION));
            $stmt->bindValue(":REGIME", strtoupper($REGIME));
            $stmt->bindValue(":STUDENT_TYPE", strtoupper($STUDENT_TYPE));
            $stmt->bindValue(":MILITARY_RANK", strtoupper($MILITARY_RANK));
            $stmt->bindValue(":EMPLOYMENT", strtoupper($EMPLOYMENT));
            $stmt->bindValue(":CAREER_ID", $CAREER_ID);
            $stmt->execute();
            $this->pdo->commit();
            return true;
    }catch (PDOException $e) {
        $this->pdo->rollBack();
        throw $e; // Se lanza la excepción para manejarla en otro lugar
}
}

    // Buscar estudiante por correo (para registro)
    public function getStudentByEmail($email) {
        $sql = "SELECT * FROM `t-students` WHERE `EMAIL` = :EMAIL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':EMAIL', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // Buscar estudiante por correo excluyendo un ID (para edición)
    public function getStudentByEmailExceptId($email, $id) {
        $sql = "SELECT * FROM `t-students` WHERE `EMAIL` = :EMAIL AND `STUDENTS_ID` != :STUDENTS_ID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':EMAIL', $email);
        $stmt->bindValue(':STUDENTS_ID', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getStudentCountByCareer() {
        $sql = "SELECT c.CAREER_NAME, COUNT(s.STUDENTS_ID) AS student_count
                FROM `t-career` c
                LEFT JOIN `t-students` s ON c.CAREER_ID = s.CAREER_ID
                GROUP BY c.CAREER_NAME";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}
?>