<?php
session_start();
//me voy a traer la conexion
require_once("conexion.php");
date_default_timezone_get();

//instancio la clase usuario
class Usuario
{
    //creo los atributos
    private $conexion;
    private $pdo;

    //hago el metodo constructor para usar la conexion en todo lo que va de la clase
    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    //creo la funcion que me va a consultar todos los datos que exista y me los traera y guardarlos en una variable
    public function buscarCodigo($CAREER_CODE){
        $consulta = "SELECT * FROM `t-career` WHERE CAREER_CODE = :CAREER_CODE";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':CAREER_CODE', $CAREER_CODE);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'CAREER_ID' => $row["CAREER_ID"],
                'CAREER_NAME' => $row["CAREER_NAME"],
                'CAREER_CODE' => $row["CAREER_CODE"]
            );
        }
        return $json;
    }
    public function buscarNombre($CAREER_NAME){
        $consulta = "SELECT * FROM `t-career` WHERE CAREER_NAME LIKE :CAREER_NAME";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':CAREER_NAME', $CAREER_NAME);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'CAREER_ID' => $row["CAREER_ID"],
                'CAREER_NAME' => $row["CAREER_NAME"],
                'CAREER_CODE' => $row["CAREER_CODE"]
            );
        }
        return $json;
    }
    
    //creo la funcion que me va a insertar un nuevo usuario
    public function insertarUsuario($CAREER_NAME,$CAREER_CODE,$MINIMUM_GRADE,$CAREER_INTERNSHIP_TYPES)
    {try {
        $this->pdo->beginTransaction();
        $consulta = "INSERT INTO `t-career`(`CAREER_NAME`, `CAREER_CODE`, `MINIMUM_GRADE`, `CREATION_DATE`, `MODIF_USER_ID`, `MODIF_USER_DATE`, `ELIM_USER_ID`, `ELIM_USER_DATE`, `REST_USER_ID`, `REST_USER_DATE`, `STATUS`) VALUES (:CAREER_NAME, :CAREER_CODE, :MINIMUM_GRADE, :CREATION_DATE, :MODIF_USER_ID, :MODIF_USER_DATE, :ELIM_USER_ID, :ELIM_USER_DATE, :REST_USER_ID, :REST_USER_DATE, :STATUS)";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":CAREER_NAME", $CAREER_NAME);
        $statement->bindValue(":CAREER_CODE", $CAREER_CODE);
        $statement->bindValue(":MINIMUM_GRADE", $MINIMUM_GRADE);
        $statement->bindValue(":CREATION_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":MODIF_USER_ID", $_SESSION['USER_ID']);
        $statement->bindValue(":MODIF_USER_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":ELIM_USER_ID", $_SESSION['USER_ID']);
        $statement->bindValue(":ELIM_USER_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":REST_USER_ID", $_SESSION['USER_ID']);
        $statement->bindValue(":REST_USER_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":STATUS", 1);
        $statement->execute();
        $CAREER_ID = $this->pdo->lastInsertId();
        $consulta2 = "INSERT INTO `t-career_internship_type`(`CAREER_ID`, `INTERNSHIP_TYPE_ID`) VALUES (:CAREER_ID, :INTERNSHIP_TYPE_ID)";
        foreach ($CAREER_INTERNSHIP_TYPES as $INTERNSHIP_TYPE_ID) {
            $statement2 = $this->pdo->prepare($consulta2);
            $statement2->bindValue(":CAREER_ID", $CAREER_ID);
            $statement2->bindValue(":INTERNSHIP_TYPE_ID", $INTERNSHIP_TYPE_ID);
            if(!$statement2->execute()){
                $this->pdo->rollBack();
                return false; // Error al insertar en la tabla intermedia
            };
        }
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
    
    //creo la funcion que me va a listar todos los usuarios activos
    public function listarUsuarios(){
        $consulta = "SELECT * FROM `t-career` WHERE `STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'CAREER_ID' => $row["CAREER_ID"],
                'CAREER_NAME' => $row["CAREER_NAME"],
                'CAREER_CODE' => $row["CAREER_CODE"]
            );
        }
        return $json;
    }

    //creo la funcion que me va a listar todos los usuarios activos
    public function listarUsuariosI(){
        $consulta = "SELECT * FROM `t-career` WHERE `STATUS` = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'CAREER_ID' => $row["CAREER_ID"],
                'CAREER_NAME' => $row["CAREER_NAME"],
                'CAREER_CODE' => $row["CAREER_CODE"]
            );
            }
        return $json;
    }
    //creo la funcion que me va a eliminar un usuario
    public function eliminarUsuario($CAREER_ID){
        $consulta = "UPDATE `t-career` SET ELIM_USER_ID = :ELIM_USER_ID , ELIM_USER_DATE = :ELIM_USER_DATE ,`STATUS` = 0 WHERE CAREER_ID = :CAREER_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":ELIM_USER_ID", $_SESSION['USER_ID']);
        $statement->bindValue(":ELIM_USER_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":CAREER_ID", $CAREER_ID);
        return $statement->execute();
    }
    public function RestaurarUsuario($CAREER_ID){
        $consulta = "UPDATE `t-career` SET REST_USER_ID = :REST_USER_ID , REST_USER_DATE = :REST_USER_DATE , `STATUS` = 1 WHERE CAREER_ID = :CAREER_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":REST_USER_ID", $_SESSION['USER_ID']);
        $statement->bindValue(":REST_USER_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":CAREER_ID", $CAREER_ID);
        return $statement->execute();
    }
    //creo la funcion que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($CAREER_ID){
        $consulta = "SELECT * FROM `t-career` WHERE CAREER_ID = :CAREER_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":CAREER_ID", $CAREER_ID);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'CAREER_ID' => $row["CAREER_ID"],
                'CAREER_NAME' => $row["CAREER_NAME"],
                'CAREER_CODE' => $row["CAREER_CODE"],
                'MINIMUM_GRADE' => $row["MINIMUM_GRADE"],
                'CAREER_INTERNSHIP_TYPES' => $this->careerInternshipType($row["CAREER_ID"])
            );
        }
        return $json;
    }
    public function careerInternshipType($CAREER_ID){
        $consulta = "SELECT INTERNSHIP_TYPE_ID FROM `t-career_internship_type` WHERE CAREER_ID = :CAREER_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":CAREER_ID", $CAREER_ID);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    
    //creo la funcion que me va a editar un usuario
    public function editarUsuario($CAREER_ID, $CAREER_NAME , $CAREER_CODE,$MINIMUM_GRADE, $CAREER_INTERNSHIP_TYPES){
        $consulta = "UPDATE `t-career` SET CAREER_NAME = :CAREER_NAME, CAREER_CODE = :CAREER_CODE, MINIMUM_GRADE = :MINIMUM_GRADE, MODIF_USER_ID = :MODIF_USER_ID , MODIF_USER_DATE = :MODIF_USER_DATE  WHERE CAREER_ID = :CAREER_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":CAREER_ID", $CAREER_ID);
        $statement->bindValue(":CAREER_NAME", $CAREER_NAME);
        $statement->bindValue(":CAREER_CODE", $CAREER_CODE);
        $statement->bindValue(":MINIMUM_GRADE", $MINIMUM_GRADE);
        $statement->bindValue(":MODIF_USER_ID", $_SESSION['USER_ID']);
        $statement->bindValue(":MODIF_USER_DATE", date("Y-m-d H:i:s"));
        $consulta2 = "INSERT INTO `t-career_internship_type`(`CAREER_ID`, `INTERNSHIP_TYPE_ID`) VALUES (:CAREER_ID, :INTERNSHIP_TYPE_ID)";
        $statement2 = $this->pdo->prepare("DELETE FROM `t-career_internship_type` WHERE CAREER_ID = :CAREER_ID");
        $statement2->bindValue(":CAREER_ID", $CAREER_ID);
        $statement2->execute();
        foreach ($CAREER_INTERNSHIP_TYPES as $INTERNSHIP_TYPE_ID) {
            $statement2 = $this->pdo->prepare($consulta2);
            $statement2->bindValue(":CAREER_ID", $CAREER_ID);
            $statement2->bindValue(":INTERNSHIP_TYPE_ID", $INTERNSHIP_TYPE_ID);
            if(!$statement2->execute()){
                $this->pdo->rollBack();
                return false; // Error al insertar en la tabla intermedia
            };
        }
        return $statement->execute();
    }    

    public function internshipsTypeList(){
        $consulta = "SELECT * FROM `T-INTERNSHIP_TYPE` WHERE `STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'INTERNSHIP_TYPE_ID' => $row["INTERNSHIP_TYPE_ID"],
                'NAME' => $row["NAME"],
                'PRIORITY' => $row["PRIORITY"]
            );
        }
        return $json;
    }
}


?>