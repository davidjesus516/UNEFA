<?php
//me voy a traer la conexion
require_once("conexion.php");

//instancio la clase usuario
class Lapso
{
    //creo los atributos
    private $conexion;
    private $pdo;

    //hago el metodo constructor para usar la conexion en todo lo que va de la clase
    public function __construct() {
        $this->conexion = new Conexion('localhost', 'instituciont', 'root', '');
        $this->pdo = $this->conexion->conectar();
    }
    
    //creo la clase que me va a listar todos los usuarios
    public function listarLapso(){
        $consulta = "SELECT * FROM lapso_academico WHERE estatus = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'codigo' => $row["codigo"],
                'nombre' => $row["nombre"]
            );
        }
        return $json;
    }
    
}


?>