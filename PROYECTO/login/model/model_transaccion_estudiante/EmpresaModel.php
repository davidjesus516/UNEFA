<?php
//me voy a traer la conexion
require_once("conexion.php");

//instancio la clase usuario
class Empresa
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
    public function listarEmpresa($rif){
        $consulta = "SELECT * FROM empresa WHERE estatus = 1 AND rif LIKE :rif;";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':rif', '%' . $rif . '%');
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'rif' => $row["rif"],
                'nombre' => $row["nombre"],
                'direccion' => $row["direccion"]
            );
        }
        return $json;
    }
    
}


?>