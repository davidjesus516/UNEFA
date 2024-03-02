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

    //creo la funcion que me va a consultar todos los datos que exista y me los traera y guardarlos en una variable
    public function buscarCodigo($codigo){
        $consulta = "SELECT * FROM carrera WHERE CODIGO = :codigo";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':codigo', $codigo);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'codigo' => $row["CODIGO"],
                'nombre' => $row["NOMBRE"],
                'estatus' => $row["STATUS"]
            );
        }
        return $json;
    }
    public function buscarNombre($codigo){
        $consulta = "SELECT * FROM carrera WHERE NOMBRE LIKE :nombre";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':nombre', $codigo);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'codigo' => $row["CODIGO"],
                'nombre' => $row["NOMBRE"],
                'estatus' => $row["STATUS"]
            );
        }
        return $json;
    }
    
    //creo la funcion que me va a insertar un nuevo usuario
    public function insertarUsuario($nombre, $codigo, $status)
    {try {
        $consulta = "INSERT INTO carrera (NOMBRE, CODIGO, STATUS) VALUES (:nombre, :codigo, :status)";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":nombre", $nombre);
        $statement->bindValue(":codigo", $codigo);
        $statement->bindValue(":status", $status);
        $statement->execute();
        $this->pdo->commit();
        return true;
} catch (PDOException $e) {
    if ($e->getCode() == "23000") { // Código de error para clave duplicada
        return false; // Usuario duplicado
    } else {
        $this->pdo->rollBack();
        throw $e; // Se lanza la excepción para manejarla en otro lugar
    }
}
}
    
    //creo la funcion que me va a listar todos los usuarios activos
    public function listarUsuarios(){
        $consulta = "SELECT * FROM carrera WHERE STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'codigo' => $row["CODIGO"],
                'nombre' => $row["NOMBRE"],
                'estatus' => $row["STATUS"]
            );
        }
        return $json;
    }

    //creo la funcion que me va a listar todos los usuarios activos
    public function listarUsuariosI(){
        $consulta = "SELECT * FROM carrera WHERE estatus = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'codigo' => $row["codigo"],
                'nombre' => $row["nombre"],
                'estatus' => $row["estatus"]
            );
            }
        return $json;
    }
    //creo la funcion que me va a eliminar un usuario
    public function eliminarUsuario($ID){
        $consulta = "UPDATE carrera SET status = 0 WHERE ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":id", $ID);
        return $statement->execute();
    }
    //creo la funcion que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($ID){
        $consulta = "SELECT * FROM carrera WHERE ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":id", $ID);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'codigo' => $row["CODIGO"],
                'nombre' => $row["NOMBRE"]
            );
        }
        return $json;
    }
    
    //creo la funcion que me va a editar un usuario
    public function editarUsuario($ID, $nombre , $codigo, $status){
        $consulta = "UPDATE carrera SET NOMBRE = :nombre, CODIGO = :codigo,
          STATUS = :status WHERE `ID` = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":id", $ID);
        $statement->bindValue(":nombre", $nombre);
        $statement->bindValue(":codigo", $codigo);
        $statement->bindValue(":status", $status);
        return $statement->execute();
    }    
}


?>