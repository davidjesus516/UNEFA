<?php
//me voy a traer la conexion
require_once("conexion.php");

//instancio la clase usuario
class AreaInvestigacion
{
    //creo los atributos
    private $conexion;
    private $pdo;

    //hago el metodo constructor para usar la conexion en todo lo que va de la clase
    public function __construct() {
        $this->conexion = new Conexion('localhost', 'instituciont', 'root', '');
        $this->pdo = $this->conexion->conectar();
    }
    
    //creo la clase que me va a listar todos los estudiantes buscados
    public function listarArea($codigo){
        $consulta = "SELECT * FROM area_investigacion WHERE estatus = 1 AND codigo LIKE :codigo;";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':codigo', '%' . $codigo . '%');
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