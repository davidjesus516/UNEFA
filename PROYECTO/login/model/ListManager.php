<?php
require_once("conexion.php");

class ListManager 
{
    private $conexion;
    private $pdo;

    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    // Métodos para t-list
    public function getListById($id) {
        $sql = "SELECT * FROM `t-list` WHERE `LIST_ID` = :LIST_ID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':LIST_ID', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getListByName($name) {
        $sql = "SELECT * FROM `t-list` WHERE `NAME` = :NAME";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':NAME', $name);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getAllLists() {
        $sql = "SELECT * FROM `t-list` WHERE `STATUS` = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function insertList($NAME, $MODIF_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $consulta = "INSERT INTO `t-list` (`NAME`, `CREATION_DATE`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) 
                         VALUES (:NAME, :CREATION_DATE, :MODIF_USER_ID, :MODIF_USER_DATE, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1)";
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(":NAME", $NAME);
            $statement->bindValue(":CREATION_DATE", date("Y-m-d H:i:s"));
            $statement->bindValue(":MODIF_USER_ID", $MODIF_USER_ID);
            $statement->bindValue(":MODIF_USER_DATE", date("Y-m-d H:i:s"));
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == "23000") {
                return false;
            } else {
                $this->pdo->rollBack();
                throw $e;
                return false;
            }
        }
    }

    public function deleteList($id, $ELIM_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-list` SET `STATUS` = 0, `ELIM_USER_ID` = :ELIM_USER_ID, `ELIM_USER_DATE` = :ELIM_USER_DATE WHERE `LIST_ID` = :LIST_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':LIST_ID', $id);
            $stmt->bindValue(':ELIM_USER_ID', $ELIM_USER_ID);
            $stmt->bindValue(':ELIM_USER_DATE', date("Y-m-d H:i:s"));
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
            return false;
        }
    }

    public function recoverList($id, $REST_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-list` SET `STATUS` = 1, `REST_USER_ID` = :REST_USER_ID, `REST_USER_DATE` = :REST_USER_DATE WHERE `LIST_ID` = :LIST_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':LIST_ID', $id);
            $stmt->bindValue(':REST_USER_ID', $REST_USER_ID);
            $stmt->bindValue(':REST_USER_DATE', date("Y-m-d H:i:s"));
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
            return false;
        }
    }

    public function updateList($LIST_ID, $NAME, $MODIF_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-list` SET `NAME` = :NAME, `MODIF_USER_ID` = :MODIF_USER_ID, `MODIF_USER_DATE` = :MODIF_USER_DATE WHERE `LIST_ID` = :LIST_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":LIST_ID", $LIST_ID);
            $stmt->bindValue(":NAME", $NAME);
            $stmt->bindValue(":MODIF_USER_ID", $MODIF_USER_ID);
            $stmt->bindValue(":MODIF_USER_DATE", date("Y-m-d H:i:s"));
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
            return false;
        }
    }

    // Métodos para t-value_list
    public function getValueListById($id) {
        $sql = "SELECT * FROM `t-value_list` WHERE `VALUE_LIST_ID` = :VALUE_LIST_ID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':VALUE_LIST_ID', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getValueListByName($name) {
        $sql = "SELECT * FROM `t-value_list` WHERE `NAME` = :NAME";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':NAME', $name);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getValueListsByListId($list_id) {
        $sql = "SELECT * FROM `t-value_list` WHERE `LIST_ID` = :LIST_ID AND `STATUS` = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':LIST_ID', $list_id);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getAllValueLists() {
        $sql = "SELECT vl.*, l.NAME as LIST_NAME FROM `t-value_list` vl 
                LEFT JOIN `t-list` l ON vl.LIST_ID = l.LIST_ID 
                WHERE vl.`STATUS` = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function insertValueList($NAME, $ABBREVIATION, $LIST_ID, $MODIF_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $consulta = "INSERT INTO `t-value_list` (`NAME`, `ABBREVIATION`, `LIST_ID`, `CREATION_DATE`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) 
                         VALUES (:NAME, :ABBREVIATION, :LIST_ID, :CREATION_DATE, :MODIF_USER_ID, :MODIF_USER_DATE, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1)";
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(":NAME", $NAME);
            $statement->bindValue(":ABBREVIATION", $ABBREVIATION);
            $statement->bindValue(":LIST_ID", $LIST_ID);
            $statement->bindValue(":CREATION_DATE", date("Y-m-d H:i:s"));
            $statement->bindValue(":MODIF_USER_ID", $MODIF_USER_ID);
            $statement->bindValue(":MODIF_USER_DATE", date("Y-m-d H:i:s"));
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == "23000") {
                return false;
            } else {
                $this->pdo->rollBack();
                throw $e;
                return false;
            }
        }
    }

    public function deleteValueList($id, $ELIM_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-value_list` SET `STATUS` = 0, `ELIM_USER_ID` = :ELIM_USER_ID, `ELIM_USER_DATE` = :ELIM_USER_DATE WHERE `VALUE_LIST_ID` = :VALUE_LIST_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':VALUE_LIST_ID', $id);
            $stmt->bindValue(':ELIM_USER_ID', $ELIM_USER_ID);
            $stmt->bindValue(':ELIM_USER_DATE', date("Y-m-d H:i:s"));
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
            return false;
        }
    }

    public function recoverValueList($id, $REST_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-value_list` SET `STATUS` = 1, `REST_USER_ID` = :REST_USER_ID, `REST_USER_DATE` = :REST_USER_DATE WHERE `VALUE_LIST_ID` = :VALUE_LIST_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':VALUE_LIST_ID', $id);
            $stmt->bindValue(':REST_USER_ID', $REST_USER_ID);
            $stmt->bindValue(':REST_USER_DATE', date("Y-m-d H:i:s"));
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
            return false;
        }
    }

    public function updateValueList($VALUE_LIST_ID, $NAME, $ABBREVIATION, $LIST_ID, $MODIF_USER_ID) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-value_list` SET `NAME` = :NAME, `ABBREVIATION` = :ABBREVIATION, `LIST_ID` = :LIST_ID, `MODIF_USER_ID` = :MODIF_USER_ID, `MODIF_USER_DATE` = :MODIF_USER_DATE WHERE `VALUE_LIST_ID` = :VALUE_LIST_ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":VALUE_LIST_ID", $VALUE_LIST_ID);
            $stmt->bindValue(":NAME", $NAME);
            $stmt->bindValue(":ABBREVIATION", $ABBREVIATION);
            $stmt->bindValue(":LIST_ID", $LIST_ID);
            $stmt->bindValue(":MODIF_USER_ID", $MODIF_USER_ID);
            $stmt->bindValue(":MODIF_USER_DATE", date("Y-m-d H:i:s"));
            $stmt->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
            return false;
        }
    }
}
?>