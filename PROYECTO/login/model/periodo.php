<?php
session_start();
date_default_timezone_get();
//me voy a traer la conexion
require_once("conexion.php");

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
    public function buscarCodigo($DESCRIPTION){
        $consulta = "SELECT * FROM `T-INTERNSHIPS_PERIOD` WHERE 'DESCRIPTION' = :'DESCRIPTION'";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':DESCRIPTION', $DESCRIPTION);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'DESCRIPTION' => $row["DESCRIPTION"],
                'DESCRIPTION' => $row["T-INTERNSHIPS_CODE"],
                'START_DATE' => $row["START_DATE"],
                'END_DATE' => $row["END_DATE"]
            );
        }
        return $json;
    }
    
    //creo la funcion que me va a insertar un nuevo usuario
    public function insertarUsuario($DESCRIPTION, $T_INTERNSHIPS_CODE, $START_DATE, $END_DATE)
    {try {
        $this->pdo->beginTransaction();
        $consulta = "INSERT INTO `T-INTERNSHIPS_PERIOD`(`DESCRIPTION`, `T-INTERNSHIPS_CODE`, `START_DATE`, 'END_DATE', `CREATION_DATE`, `PERIOD-STATUS`, `STATUS`) VALUES (:DESCRIPTION, :T-INTERNSHIPS_CODE, :START_DATE, :END_DATE, :CREATION_DATE, :PERIOD_STATUS :STATUS)";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":DESCRIPTION", $DESCRIPTION);
        $statement->bindValue(":T-INTERNSHIPS_CODE", $T_INTERNSHIPS_CODE);
        $statement->bindValue(":START_DATE", $START_DATE);
        $statement->bindValue(":END_DATE", $END_DATE);
        $statement->bindValue(":CREATION_DATE", date("Y-m-d H:i:s"));
        $statement->bindValue(":PERIOD-STATUS",1);
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
   //creo la funcion que me va a listar todos los usuarios activos
    public function listarUsuarios(){
        $consulta = "SELECT * FROM `T-INTERNSHIPS_PERIOD` WHERE `STATUS` = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'PERIOD_ID' => $row["PERIOD_ID"],
                'DESCRIPTION' => $row["DESCRIPTION"],
                'T-INTERNSHIPS_CODE' => $row["T-INTERNSHIPS_CODE"],
                'START_DATE' => $row["START_DATE"],
                'END_DATE' => $row["END_DATE"],
            );
        }
        return $json;
    }
     //creo la funcion que me va a listar todos los usuarios inactivos
    public function listarUsuariosInactivos(){
        $consulta = "SELECT * FROM `T-INTERNSHIPS_PERIOD` WHERE `STATUS` = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'PERIOD_ID' => $row["PERIOD_ID"],
                'DESCRIPTION' => $row["DESCRIPTION"],
                'T-INTERNSHIPS_CODE' => $row["T-INTERNSHIPS_CODE"],
                'START_DATE' => $row["START_DATE"],
                'END_DATE' => $row["END_DATE"],
            );
        }
        return $json;
    }
    //creo la clase que me va a listar todos los usuarios
    public function listarProyeccion(){
        $consulta = "SELECT * FROM T-INTERNSHIPS_PERIOD where PERIOD_STATUS=2";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'PERIOD_ID' => $row["PERIOD_ID"],
                'DESCRIPTION' => $row["DESCRIPTION"],
                'T-INTERNSHIPS_CODE' => $row["T-INTERNSHIPS_CODE"],
                'START-DATE' => $row["START_DATE"],
                'END_DATE' => $row["END_DATE"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    //creo la clase que me va a listar todos los usuarios
    public function listarProrroga(){
        $consulta = "SELECT * FROM T-INTERNSHIPS_PERIOD where PERIOD_STATUS=3";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'PERIOD_ID' => $row["PERIOD_ID"],
                'DESCRIPTION' => $row["DESCRIPTION"],
                'T-INTERNSHIPS_CODE' => $row["T-INTERNSHIPS_CODE"],
                'START-DATE' => $row["START_DATE"],
                'END_DATE' => $row["END_DATE"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    //creo la clase que me va a eliminar un usuario
    public function eliminarUsuario($STATUS,$PERIOD_ID){
        $consulta = "UPDATE T-INTERNSHIPS_PERIOD SET STATUS = :STATUS
        WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':STATUS', $STATUS);
        $statement->bindValue(':PERIOD_ID', $PERIOD_ID);
        return $statement->execute();
    }

    public function activarUsuario($STATUS, $PERIOD_ID){
        $consultaDesactivar = "UPDATE T-INTERNSHIPS_PERIOD SET STATUS = 0
        WHERE STATUS = 1";
        $statementDesactivar = $this->pdo->prepare($consultaDesactivar);
        $statementDesactivar->execute();
    
        $consultaActivar = "UPDATE T-INTERNSHIPS_PERIOD SET STATUS = :STATUS
        WHERE PERIOD_ID = :PERIOD_ID"; 
        $statementActivar = $this->pdo->prepare($consultaActivar);
        $statementActivar->bindValue(':STATUS', $STATUS);
        $statementActivar->bindValue(':PERIOD_ID', $PERIOD_ID);
    
        return $statementActivar->execute();
    }
    public function activarLapsos()
    {
        $consultaActivar = "UPDATE DESCRIPTION SET STATUS = 1
        WHERE STATUS = 0";
        $statementActivar = $this->pdo->prepare($consultaActivar);
        $statementActivar->execute();
    }

    public function desactivarLapsos()
    {
        $consultaDesactivar = "UPDATE DESCRIPTION SET STATUS = 0
        WHERE STATUS = 1";
        $statementDesactivar = $this->pdo->prepare($consultaDesactivar);
        $statementDesactivar->execute();
    }
    

    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($PERIOD_ID){
        $consulta = "SELECT * FROM T-INTERNSHIPS_PERIOD WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':PERIOD_ID', $PERIOD_ID);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'PERIOD_ID' => $row["PERIOD_ID"],
                'DESCRIPTION' => $row["DESCRIPTION"],
                'T-INTERNSHIPS_CODE' => $row["T-INTERNSHIPS_CODE"],
                'START_DATE' => $row["START_DATE"],
                'END_DATE' => $row["END_DATE"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($PERIOD_ID, $DESCRIPTION, $T_INTERNSHIPS_CODE, $START_DATE, $END_DATE){
        $consulta = "UPDATE T-INTERNSHIPS_PERIOD SET DESCRIPTION = :DESCRIPTION,
        T-INTERNSHIPS_CODE = :T_INTERNSHIPS_CODE, START_DATE = :START_DATE,
        END_DATE = :END_DATE WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':PERIOD_ID', $PERIOD_ID);
        $statement->bindValue(':DESCRIPTION', $DESCRIPTION);
        $statement->bindValue(':T_INTERNSHIPS_CODE', $T_INTERNSHIPS_CODE);
        $statement->bindValue(':START_DATE', $START_DATE);
        $statement->bindValue(':END_DATE', $END_DATE);
        return $statement->execute();
    }
    }    
//cierro la clase
//cierro la conexion 

?>