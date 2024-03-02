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
        $this->conexion = new Conexion('localhost', 'unefa', 'root', '');
        $this->pdo = $this->conexion->conectar();
    }

    //creo la clase que me va a consultar todos los datos que exista y me los traera y guardarlos en una variable
    public function buscarUsuario($periodo){
        $consulta = "SELECT * FROM periodo WHERE STATUS = 1
         AND periodo LIKE :periodo";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':periodo', '%' . $periodo . '%');
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'PERIODO' => $row["PERIODO"],
                'FECHA_INICIO' => $row["FECHA_INICIO"],
                'FECHA_FIN' => $row["FECHA_FIN"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a insertar un nuevo usuario
    public function insertarUsuario($periodo, $fecha_inicio,
     $fecha_fin, $estatus){

        $consulta = "INSERT INTO periodo (PERIODO, FECHA_INICIO,
        FECHA_FIN, STATUS) VALUES (:periodo, :fecha_inicio, 
        :fecha_fin, :estatus)";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':periodo', $periodo);
        $statement->bindValue(':fecha_inicio', $fecha_inicio);
        $statement->bindValue(':fecha_fin', $fecha_fin);
        $statement->bindValue(':estatus', $estatus);
        return $statement->execute();
    }
    
    //creo la clase que me va a listar todos los usuarios
    public function listarUsuarios(){
        $consulta = "SELECT * FROM lapso_academico";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'PERIODO' => $row["PERIODO"],
                'FECHA_INICIO' => $row["FECHA_INICIO"],
                'FECHA_FIN' => $row["FECHA_FIN"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    //creo la clase que me va a eliminar un usuario
    public function eliminarUsuario($estatus,$id){
        $consulta = "UPDATE periodo SET estatus = :estatus
        WHERE ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    public function activarUsuario($estatus, $id)
    {
        $consultaDesactivar = "UPDATE periodo SET estatus = 0
         WHERE estatus = 1";
        $statementDesactivar = $this->pdo->prepare($consultaDesactivar);
        $statementDesactivar->execute();
    
        $consultaActivar = "UPDATE periodo SET estatus = :estatus 
        WHERE id = :id";
        $statementActivar = $this->pdo->prepare($consultaActivar);
        $statementActivar->bindValue(':estatus', $estatus);
        $statementActivar->bindValue(':codigo', $id);
    
        return $statementActivar->execute();
    }

    public function desactivarLapsos()
    {
        $consultaDesactivar = "UPDATE lapso_academico SET estatus = 0
         WHERE estatus = 1";
        $statementDesactivar = $this->pdo->prepare($consultaDesactivar);
        $statementDesactivar->execute();
    }
    

    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($id){
        $consulta = "SELECT * FROM lapso_academico WHERE id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'PERIODO' => $row["PERIODO"],
                'FECHA_INICIO' => $row["FECHA_INICIO"],
                'FECHA_FIN' => $row["FECHA_FIN"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($id, $periodo, $fecha_inicio,
    $fecha_fin, $estatus){
        $consulta = "UPDATE lapso_academico SET PERIODO = :periodo,
        FECHA_INICIO = :inicio, FECHA_FIN = :fin, STATUS = :estatus
        WHERE id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':periodo', $periodo);
        $statement->bindValue(':inicio', $fecha_inicio);
        $statement->bindValue(':fin', $fecha_fin);
        $statement->bindValue(':estatus', $estatus);
        return $statement->execute();
    }    
}

?>