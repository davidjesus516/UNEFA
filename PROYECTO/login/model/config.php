<?php
require_once("conexion.php");
class Config
{
    private $conexion;
    private $pdo;

    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    public function getConfig(){
        $consulta = "SELECT * FROM `t-config` ";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
?>