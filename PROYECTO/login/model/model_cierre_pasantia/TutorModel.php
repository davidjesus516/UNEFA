<?php
//me voy a traer la conexion
require_once("conexion.php");

//instancio la clase usuario
class Tutor
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
    public function listarTutor($cedula){
        $consulta = "SELECT t.id, p.cedula, p.nombre, p.apellido, prof.nombre AS nombre_profesion FROM tutor_empresarial t INNER JOIN persona p ON t.id_persona = p.cedula INNER JOIN profesion prof ON t.id_profesion = prof.codigo WHERE t.estatus = 1 AND cedula LIKE :cedula ORDER BY CASE WHEN cedula = :cedula THEN 0 WHEN cedula LIKE :cedula || '%' THEN 1 WHEN cedula LIKE '% ' || :cedula || '%' THEN 2 WHEN cedula LIKE '%-' || :cedula || '%' THEN 3 WHEN cedula LIKE '%.' || :cedula || '%' THEN 4 ELSE 5 END;";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula', '%' . $cedula . '%');
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'cedula' => $row["cedula"],
                'nombre' => $row["nombre"],
                'apellido' => $row["apellido"],
                'nombre_profesion' => $row["nombre_profesion"]
            );
        }
        return $json;
    }

    public function filtrarTutor(){
        $consulta = "SELECT * FROM tutor_empresarial t JOIN persona p ON t.id_persona = p.cedula WHERE t.estatus = 1";
        $statement = $this->pdo->prepare($consulta);
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