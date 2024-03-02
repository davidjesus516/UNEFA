<?php
//me voy a traer la conexion
require_once("conexion.php");

//instancio la clase usuario
class Estudiante
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
    public function listarEstudiante($cedula){
        $consulta = "SELECT * FROM estudiante e JOIN persona p ON e.id_persona = p.cedula WHERE e.estatus = 1 AND cedula LIKE :cedula ORDER BY CASE WHEN cedula = :cedula THEN 0 WHEN cedula LIKE :cedula || '%' THEN 1 WHEN cedula LIKE '% ' || :cedula || '%' THEN 2 WHEN cedula LIKE '%-' || :cedula || '%' THEN 3 WHEN cedula LIKE '%.' || :cedula || '%' THEN 4 ELSE 5 END;";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula', '%' . $cedula . '%');
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'cedula' => $row["cedula"],
                'nombre' => $row["nombre"],
                'apellido' => $row["apellido"]
            );
        }
        return $json;
    }
    
}


?>