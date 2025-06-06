<?php
session_start();
require_once("conexion.php");
date_default_timezone_set("America/Caracas");

class InstitutionManager
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
        $consulta = "SELECT * FROM `t-institution_manager`";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($MANAGER_ID)
    {
        $consulta = "SELECT * FROM `t-institution_manager` WHERE MANAGER_ID = :MANAGER_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':MANAGER_ID', $MANAGER_ID);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorCedula($MANAGER_CI)
    {
        $consulta = "SELECT * FROM `t-institution_manager` WHERE MANAGER_CI = :MANAGER_CI";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':MANAGER_CI', $MANAGER_CI);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar($MANAGER_CI, $NAME, $SURNAME, $CONTACT_PHONE, $EMAIL, $SECOND_NAME = null, $SECOND_SURNAME = null)
    {
        try {
            $this->pdo->beginTransaction();
            $consulta = "INSERT INTO `t-institution_manager` (
                MANAGER_CI, NAME, SECOND_NAME, SURNAME, SECOND_SURNAME, CONTACT_PHONE, EMAIL,
                CREATION_DATE, STATUS
            ) VALUES (
                :MANAGER_CI, :NAME, :SECOND_NAME, :SURNAME, :SECOND_SURNAME, :CONTACT_PHONE, :EMAIL,
                :CREATION_DATE, 1
            )";

            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(":MANAGER_CI", $MANAGER_CI);
            $statement->bindValue(":NAME", $NAME);
            $statement->bindValue(":SECOND_NAME", $SECOND_NAME);
            $statement->bindValue(":SURNAME", $SURNAME);
            $statement->bindValue(":SECOND_SURNAME", $SECOND_SURNAME);
            $statement->bindValue(":CONTACT_PHONE", $CONTACT_PHONE);
            $statement->bindValue(":EMAIL", $EMAIL);
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

    public function actualizar($MANAGER_ID, $MANAGER_CI, $NAME, $SURNAME, $CONTACT_PHONE, $EMAIL, $SECOND_NAME = null, $SECOND_SURNAME = null)
    {
        $consulta = "UPDATE `t-institution_manager` 
            SET MANAGER_CI = :MANAGER_CI, NAME = :NAME, SECOND_NAME = :SECOND_NAME,
                SURNAME = :SURNAME, SECOND_SURNAME = :SECOND_SURNAME, CONTACT_PHONE = :CONTACT_PHONE,
                EMAIL = :EMAIL
            WHERE MANAGER_ID = :MANAGER_ID";

        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":MANAGER_ID", $MANAGER_ID);
        $statement->bindValue(":MANAGER_CI", $MANAGER_CI);
        $statement->bindValue(":NAME", $NAME);
        $statement->bindValue(":SECOND_NAME", $SECOND_NAME);
        $statement->bindValue(":SURNAME", $SURNAME);
        $statement->bindValue(":SECOND_SURNAME", $SECOND_SURNAME);
        $statement->bindValue(":CONTACT_PHONE", $CONTACT_PHONE);
        $statement->bindValue(":EMAIL", $EMAIL);

        return $statement->execute();
    }

    public function eliminar($MANAGER_ID)
    {
        $consulta = "UPDATE `t-institution_manager` 
            SET STATUS = 0
            WHERE MANAGER_ID = :MANAGER_ID";

        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":MANAGER_ID", $MANAGER_ID);

        return $statement->execute();
    }

    public function restaurar($MANAGER_ID)
    {
        $consulta = "UPDATE `t-institution_manager` 
            SET STATUS = 1
            WHERE MANAGER_ID = :MANAGER_ID";

        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":MANAGER_ID", $MANAGER_ID);

        return $statement->execute();
    }

    public function listarActivos()
    {
        $consulta = "SELECT * FROM `t-institution_manager` WHERE STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarInactivos()
    {
        $consulta = "SELECT * FROM `t-institution_manager` WHERE STATUS = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
