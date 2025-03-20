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
    //creo la funcion que me va a listar todos las empresas activos
    public function listar_a(){
        $consulta = "SELECT IdTipo_Institucion,Tipo_Institucion FROM tipo_institucion WHERE Estatus = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'IdTipo_Institucion' => $row["IdTipo_Institucion"],
                'Tipo_Institucion' => $row["Tipo_Institucion"]
            );
        }
        return $json;
    }
}


?>