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
    public function buscarUsuario($codigo){
        $consulta = "SELECT * FROM profesion WHERE estatus = 1 AND codigo LIKE :codigo";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':codigo', '%' . $codigo . '%');
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'codigo' => $row["codigo"],
                'nombre' => $row["nombre"],
                'estatus' => $row["estatus"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a insertar un nuevo usuario
    public function insertarUsuario($nombre, $estatus){
        $consulta = "INSERT INTO profesion (nombre, estatus) VALUES (:nombre, :estatus)";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':estatus', $estatus);
        return $statement->execute();
    }
    
    //creo la clase que me va a listar todos los usuarios
    public function listarUsuarios(){
        $consulta = "SELECT * FROM profesion WHERE estatus = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'codigo' => $row["codigo"],
                'nombre' => $row["nombre"],
                'estatus' => $row["estatus"]
            );
        }
        return $json;
    }
    //creo la clase que me va a eliminar un usuario
    public function eliminarUsuario($estatus,$codigo){
        $consulta = "UPDATE profesion SET estatus = :estatus WHERE codigo = :codigo";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':codigo', $codigo);
        return $statement->execute();
    }
    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($codigo){
        $consulta = "SELECT * FROM profesion WHERE codigo = :codigo";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':codigo', $codigo);
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
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($codigo, $nombre){
        $consulta = "UPDATE profesion SET nombre = :nombre WHERE codigo = :codigo";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':codigo', $codigo);
        $statement->bindValue(':nombre', $nombre);
        return $statement->execute();
    }    
}


?>