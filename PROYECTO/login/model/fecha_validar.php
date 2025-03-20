<?php
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

    //creo la clase que me va a consultar todos los datos que exista y me los traera y guardarlos en una variable
    public function lapso_activo(){
        $consulta = "SELECT * FROM PERIODO WHERE status = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function lapso_prospecto(){
        $consulta = "SELECT * FROM PERIODO WHERE status = 2";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function lapso_finalizado(){
        $consulta = "SELECT * FROM PERIODO WHERE status = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function fechadiff($date){
        $consulta = "SELECT DATEDIFF(:fecha , CURDATE()) as dias" ;
        $statement = $this->pdo->prepare($consulta);
        $statement->bindvalue(":fecha", $date);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
      
}


?>