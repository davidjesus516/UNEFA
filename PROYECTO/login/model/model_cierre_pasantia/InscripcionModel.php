<?php
//me voy a traer la conexion
require_once("conexion.php");

//instancio la clase usuario
class Inscripcion
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
    public function listarInscripcion($codigo){
        $consulta = "SELECT * FROM inscripcion WHERE inscripcion.estatus = 1 AND id LIKE :id ORDER BY CASE WHEN id = :id THEN 0 WHEN id LIKE :id || '%' THEN 1 WHEN id LIKE '% ' || :id || '%' THEN 2 WHEN id LIKE '%-' || :id || '%' THEN 3 WHEN id LIKE '%.' || :id || '%' THEN 4 ELSE 5 END;";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', '%' . $codigo . '%');
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"]
            );
        }
        return $json;
    }
    
}


?>