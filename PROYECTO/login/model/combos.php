<?php
require_once("conexion.php");

class Combos
{
    private $conexion;
    private $pdo;

    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }
    public function getGenderCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getMaritalStatusCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 2";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getNationalityCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 3";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getRegimeCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 4";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getWorkingStatusCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 5";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getInstitutionTypeCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 6";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getRIFTypeCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 7";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getStudentTypeCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 12";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }
    public function getMilitaryRankCombo(){
        $sql = "SELECT NAME, ABBREVIATION FROM `t-value_list` WHERE LIST_ID = 13";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $options = "";
        foreach ($rows as $row) {
            $options .= "<option value='" . $row['ABBREVIATION'] . "'>" . $row['NAME'] . "</option>";
        }
        return $options;
    }

}

?>