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
        $sql = "SELECT s.`STUDENTS_ID`,s.`STUDENTS_CI`,CONCAT(s.`NAME`,' ',s.`SECOND_NAME`) AS `NAME`, CONCAT(s.`SURNAME`,' ',s.`SECOND_SURNAME`) AS `SURNAME`,s.`GENDER`,s.`CONTACT_PHONE`,s.`EMAIL`,c.CAREER_NAME FROM `t-students` s LEFT JOIN `t-career` c ON s.`CAREER_ID` = c.`CAREER_ID` WHERE s.`STATUS` = 1";
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
        $statement->bindValue(":STUDENTS_CI", $STUDENTS_CI);
        $statement->bindValue(":NAME", $NAME);
        $statement->bindValue(":SECOND_NAME", $SECOND_NAME);
        $statement->bindValue(":SURNAME", $SURNAME);
        $statement->bindValue(":SECOND_SURNAME", $SECOND_SURNAME);
        $statement->bindValue(":GENDER", $GENDER);
        $statement->bindValue(":BIRTHDATE", $BIRTHDATE);
        $statement->bindValue(":CONTACT_PHONE", $CONTACT_PHONE);
        $statement->bindValue(":EMAIL", $EMAIL);
        $statement->bindValue(":ADDRESS", $ADDRESS);
        $statement->bindValue(":MARITAL_STATUS", $MARITAL_STATUS);
        $statement->bindValue(":SEMESTER", $SEMESTER);
        $statement->bindValue(":SECTION", $SECTION);
        $statement->bindValue(":REGIME", $REGIME);
        $statement->bindValue(":STUDENT_TYPE", $STUDENT_TYPE);
        $statement->bindValue(":MILITARY_RANK", $MILITARY_RANK);
        $statement->bindValue(":EMPLOYMENT", $EMPLOYMENT);
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
        return false;
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
        return false;
}
    }

    public function recoverStudent($id) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-students`SET `STATUS`=':STATUS' WHERE STUDENTS_ID = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':STUDENTS_ID', $id);
            $stmt->bindValue(":STATUS", 1);
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
        $this->pdo->rollBack();
        throw $e; // Se lanza la excepción para manejarla en otro lugar
        return false;
}
    }

    public function updateStudent($STUDENTS_ID,$STUDENTS_CI, $NAME, $SECOND_NAME, $SURNAME, $SECOND_SURNAME, $GENDER, $BIRTHDATE, $CONTACT_PHONE, $EMAIL, $ADDRESS, $MARITAL_STATUS, $SEMESTER, $SECTION, $REGIME, $STUDENT_TYPE, $MILITARY_RANK, $EMPLOYMENT, $CAREER_ID){
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-students` SET `STUDENTS_CI`=:STUDENTS_CI,`NAME`=:NAME,`SECOND_NAME`=:SECOND_NAME,`SURNAME`=:SURNAME,`SECOND_SURNAME`=:SECOND_SURNAME,`GENDER`=:GENDER,`BIRTHDATE`=:BIRTHDATE,`CONTACT_PHONE`=:CONTACT_PHONE,`EMAIL`=:EMAIL,`ADDRESS`=:ADDRESS,`MARITAL_STATUS`=:MARITAL_STATUS,`SEMESTER`=:SEMESTER,`SECTION`=:SECTION,`REGIME`=:REGIME,`STUDENT_TYPE`=:STUDENT_TYPE,`MILITARY_RANK`=:MILITARY_RANK,`EMPLOYMENT`=:EMPLOYMENT,`CAREER_ID`=:CAREER_ID WHERE `STUDENTS_ID` = :STUDENTS_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":STUDENTS_ID", $STUDENTS_ID);
            $stmt->bindValue(":STUDENTS_CI", $STUDENTS_CI);
            $stmt->bindValue(":NAME", $NAME);
            $stmt->bindValue(":SECOND_NAME", $SECOND_NAME);
            $stmt->bindValue(":SURNAME", $SURNAME);
            $stmt->bindValue(":SECOND_SURNAME", $SECOND_SURNAME);
            $stmt->bindValue(":GENDER", $GENDER);
            $stmt->bindValue(":BIRTHDATE", $BIRTHDATE);
            $stmt->bindValue(":CONTACT_PHONE", $CONTACT_PHONE);
            $stmt->bindValue(":EMAIL", $EMAIL);
            $stmt->bindValue(":ADDRESS", $ADDRESS);
            $stmt->bindValue(":MARITAL_STATUS", $MARITAL_STATUS);
            $stmt->bindValue(":SEMESTER", $SEMESTER);
            $stmt->bindValue(":SECTION", $SECTION);
            $stmt->bindValue(":REGIME", $REGIME);
            $stmt->bindValue(":STUDENT_TYPE", $STUDENT_TYPE);
            $stmt->bindValue(":MILITARY_RANK", $MILITARY_RANK);
            $stmt->bindValue(":EMPLOYMENT", $EMPLOYMENT);
            $stmt->bindValue(":CAREER_ID", $CAREER_ID);
            $stmt->execute();
            $this->pdo->commit();
            return true;
    }catch (PDOException $e) {
        $this->pdo->rollBack();
        throw $e; // Se lanza la excepción para manejarla en otro lugar
        return false;
    
}
}
}
?>