<?php
require_once("conexion.php");
date_default_timezone_set("America/Caracas");

session_start();

class Tutor
{
    private $conexion;
    private $pdo;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    public function listar()
    {
        $consulta = "SELECT * FROM `t-tutors`";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($TUTOR_ID)
    {
        $consulta = "SELECT * FROM `t-tutors` WHERE TUTOR_ID = :TUTOR_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':TUTOR_ID', $TUTOR_ID);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorCedula($TUTOR_CI)
    {
        $consulta = "SELECT * FROM `t-tutors` WHERE TUTOR_CI = :TUTOR_CI";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':TUTOR_CI', $TUTOR_CI);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar(
        $TUTOR_CI,
        $NAME,
        $SURNAME,
        $CONTACT_PHONE,
        $GENDER,
        $EMAIL,
        $PROFESSION,
        $CONDITION,
        $DEDICATION,
        $CATEGORY,
        $MODIF_USER_ID,
        $SECOND_NAME = null,
        $SECOND_SURNAME = null
    ) {
        // Validar unicidad de la cédula
        $existe = $this->buscarPorCedula($TUTOR_CI);
        if ($existe && count($existe) > 0) {
            return "duplicado";
        }

        try {
            $this->pdo->beginTransaction();
            $consulta = "INSERT INTO `t-tutors` (
                TUTOR_CI, 
                NAME, 
                SECOND_NAME, 
                SURNAME, 
                SECOND_SURNAME, 
                CONTACT_PHONE, 
                GENDER,
                EMAIL,
                PROFESSION,
                `CONDITION`,
                DEDICATION,
                CATEGORY,
                CREATION_DATE, 
                STATUS
            ) VALUES (
                :TUTOR_CI, 
                :NAME, 
                :SECOND_NAME, 
                :SURNAME, 
                :SECOND_SURNAME, 
                :CONTACT_PHONE, 
                :GENDER,
                :EMAIL,
                :PROFESSION,
                :CONDITION,
                :DEDICATION,
                :CATEGORY,
                :CREATION_DATE, 
                1
            )";
            
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(":TUTOR_CI", $TUTOR_CI);
            $statement->bindValue(":NAME", $NAME);
            $statement->bindValue(":SECOND_NAME", $SECOND_NAME);
            $statement->bindValue(":SURNAME", $SURNAME);
            $statement->bindValue(":SECOND_SURNAME", $SECOND_SURNAME);
            $statement->bindValue(":CONTACT_PHONE", $CONTACT_PHONE);
            $statement->bindValue(":GENDER", $GENDER);
            $statement->bindValue(":EMAIL", $EMAIL);
            $statement->bindValue(":PROFESSION", $PROFESSION);
            $statement->bindValue(":CONDITION", $CONDITION);
            $statement->bindValue(":DEDICATION", $DEDICATION);
            $statement->bindValue(":CATEGORY", $CATEGORY);
            $statement->bindValue(":CREATION_DATE", date("Y-m-d H:i:s"));
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            if ($e->getCode() == "23000") {
                return false;
            } else {
                throw $e;
            }
        }
    }

    public function actualizar(
        $TUTOR_ID,
        $TUTOR_CI,
        $NAME,
        $SURNAME,
        $CONTACT_PHONE,
        $GENDER,
        $EMAIL,
        $PROFESSION,
        $CONDITION,
        $DEDICATION,
        $CATEGORY,
        $MODIF_USER_ID,
        $SECOND_NAME = null,
        $SECOND_SURNAME = null
    ) {
        $consulta = "UPDATE `t-tutors` 
            SET TUTOR_CI = :TUTOR_CI, 
                NAME = :NAME, 
                SECOND_NAME = :SECOND_NAME, 
                SURNAME = :SURNAME, 
                SECOND_SURNAME = :SECOND_SURNAME, 
                CONTACT_PHONE = :CONTACT_PHONE, 
                GENDER = :GENDER,
                EMAIL = :EMAIL,
                PROFESSION = :PROFESSION,
                `CONDITION` = :CONDITION,
                DEDICATION = :DEDICATION,
                CATEGORY = :CATEGORY
               
            WHERE TUTOR_ID = :TUTOR_ID";
            
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":TUTOR_ID", $TUTOR_ID);
        $statement->bindValue(":TUTOR_CI", $TUTOR_CI);
        $statement->bindValue(":NAME", $NAME);
        $statement->bindValue(":SECOND_NAME", $SECOND_NAME);
        $statement->bindValue(":SURNAME", $SURNAME);
        $statement->bindValue(":SECOND_SURNAME", $SECOND_SURNAME);
        $statement->bindValue(":CONTACT_PHONE", $CONTACT_PHONE);
        $statement->bindValue(":GENDER", $GENDER);
        $statement->bindValue(":EMAIL", $EMAIL);
        $statement->bindValue(":PROFESSION", $PROFESSION);
        $statement->bindValue(":CONDITION", $CONDITION);
        $statement->bindValue(":DEDICATION", $DEDICATION);
        $statement->bindValue(":CATEGORY", $CATEGORY);

        return $statement->execute();
    }

    public function eliminar($TUTOR_ID, $ELIM_USER_ID=1)
    {
        $consulta = "UPDATE `t-tutors` 
            SET STATUS = 0
            WHERE TUTOR_ID = :TUTOR_ID";
            
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":TUTOR_ID", $TUTOR_ID);
     
        return $statement->execute();
    }

    public function restaurar($TUTOR_ID)
    {
        $consulta = "UPDATE `t-tutors` SET STATUS = 1 WHERE TUTOR_ID = :TUTOR_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":TUTOR_ID", $TUTOR_ID);
        return $statement->execute();
    }

    public function listarActivos()
    {
        $consulta = "SELECT * FROM `t-tutors` WHERE STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarInactivos()
    {
        $consulta = "SELECT * FROM `t-tutors` WHERE STATUS = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>