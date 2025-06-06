<?php
//inicializo la sesion y la zona horaria

session_start();
require_once("conexion.php");
date_default_timezone_set("America/Caracas");

class Periodo
{
    private $conexion;
    private $pdo;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    public function listar() //muestra todo
    {
        $consulta = "SELECT * FROM `t-internships_period`";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarCodigo($T_INTERNSHIPS_CODE)
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE T_INTERNSHIPS_CODE = :T_INTERNSHIPS_CODE";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':T_INTERNSHIPS_CODE', $T_INTERNSHIPS_CODE);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarNombre($ACADEMIC_LAPSE)
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE ACADEMIC_LAPSE LIKE :ACADEMIC_LAPSE";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':ACADEMIC_LAPSE', $ACADEMIC_LAPSE);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarPeriodo($ACADEMIC_LAPSE, $T_INTERNSHIPS_CODE, $START_DATE, $END_DATE, $PERIOD_STATUS, $STATUS , $DESCRIPTION = '')
    {
        try {
            $this->pdo->beginTransaction();
            $consulta = "INSERT INTO `t-internships_period` (ACADEMIC_LAPSE, T_INTERNSHIPS_CODE, START_DATE, END_DATE, CREATION_DATE, PERIOD_STATUS, STATUS, DESCRIPTION) 
             VALUES (:ACADEMIC_LAPSE, :T_INTERNSHIPS_CODE, :START_DATE, :END_DATE, :CREATION_DATE, :PERIOD_STATUS, :STATUS, :DESCRIPTION)";
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(":ACADEMIC_LAPSE", $ACADEMIC_LAPSE);
            $statement->bindValue(":T_INTERNSHIPS_CODE", $T_INTERNSHIPS_CODE);
            $statement->bindValue(":START_DATE", $START_DATE);
            $statement->bindValue(":END_DATE", $END_DATE);
            $statement->bindValue(":CREATION_DATE", date("Y-m-d H:i:s"));
            $statement->bindValue(":PERIOD_STATUS", $PERIOD_STATUS);
            $statement->bindValue(":STATUS", $STATUS); // Ahora toma el valor desde el parámetro
            $statement->bindValue(":DESCRIPTION", $DESCRIPTION); // Ahora toma el valor desde el parámetro
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

    public function listarActivos() //LOS TOMO DEL ESTATUS PERIODO
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarInactivos()
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE `STATUS` = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarPeriodo($PERIOD_ID) // AQUI INACTIVA
    {
        $consulta = "UPDATE `t-internships_period` SET `STATUS` = 0 WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
        return $statement->execute();
    }

    public function restaurarPeriodo($PERIOD_ID) // AQUI INACTIVA
    {
        $consulta = "UPDATE `t-internships_period` SET `STATUS` = 1 WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
        return $statement->execute();
    }

    public function obtenerPorID($PERIOD_ID)
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarPeriodo($PERIOD_ID, $ACADEMIC_LAPSE, $T_INTERNSHIPS_CODE, $START_DATE, $END_DATE, $PERIOD_STATUS, $STATUS)
    {
        $consulta = "UPDATE `t-internships_period` 
            SET ACADEMIC_LAPSE = :ACADEMIC_LAPSE, 
                T_INTERNSHIPS_CODE = :T_INTERNSHIPS_CODE, 
                START_DATE = :START_DATE, 
                END_DATE = :END_DATE, 
                PERIOD_STATUS = :PERIOD_STATUS,
                STATUS = :STATUS
            WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
        $statement->bindValue(":ACADEMIC_LAPSE", $ACADEMIC_LAPSE);
        $statement->bindValue(":T_INTERNSHIPS_CODE", $T_INTERNSHIPS_CODE);
        $statement->bindValue(":START_DATE", $START_DATE);
        $statement->bindValue(":END_DATE", $END_DATE);
        $statement->bindValue(":PERIOD_STATUS", $PERIOD_STATUS);
        $statement->bindValue(":STATUS", $STATUS);
        return $statement->execute();
    }
}
