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
        $this->conexion = new Conexion('localhost', 'registro_pasantias', 'root', '');
        $this->pdo = $this->conexion->conectar();
    }

    //creo la funcion que me va a consultar todos los datos que exista y me los traera y guardarlos en una variable
    public function buscarCodigo($Codigo){
        $consulta = "SELECT * FROM carrera WHERE Codigo = :Codigo";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':Codigo', $Codigo);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'Id_Carrera' => $row["Id_Carrera"],
                'Nombre_Carrera' => $row["Nombre_Carrera"],
                'Codigo' => $row["Codigo"]
            );
        }
        return $json;
    }
    public function buscarNombre($Nombre_Carrera){
        $consulta = "SELECT * FROM carrera WHERE Nombre_Carrera LIKE :Nombre_Carrera";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':Nombre_Carrera', $Nombre_Carrera);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'Id_Carrera' => $row["Id_Carrera"],
                'Nombre_Carrera' => $row["Nombre_Carrera"],
                'Codigo' => $row["Codigo"]
            );
        }
        return $json;
    }
    
    //creo la funcion que me va a insertar un nuevo usuario
    public function insertarUsuario($Nombre_Carrera,$Codigo)
    {try {
        $consulta = "INSERT INTO carrera (Nombre_Carrera,Codigo) VALUES (:Nombre_Carrera,:Codigo)";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":Nombre_Carrera", $Nombre_Carrera);
        $statement->bindValue(":Codigo", $Codigo);
        $statement->execute();
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
        $consulta = "SELECT * FROM carrera WHERE Estatus = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'Id_Carrera' => $row["Id_Carrera"],
                'Nombre_Carrera' => $row["Nombre_Carrera"],
                'Codigo' => $row["Codigo"]
            );
        }
        return $json;
    }

    //creo la funcion que me va a listar todos los usuarios activos
    public function listarUsuariosI(){
        $consulta = "SELECT * FROM carrera WHERE Estatus = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'Id_Carrera' => $row["Id_Carrera"],
                'Nombre_Carrera' => $row["Nombre_Carrera"],
                'Codigo' => $row["Codigo"]
            );
            }
        return $json;
    }
    //creo la funcion que me va a eliminar un usuario
    public function eliminarUsuario($Id_Carrera){
        $consulta = "UPDATE carrera SET Estatus = 0 WHERE Id_Carrera = :Id_Carrera";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":Id_Carrera", $Id_Carrera);
        return $statement->execute();
    }
    public function RestaurarUsuario($Id_Carrera){
        $consulta = "UPDATE carrera SET Estatus = 1 WHERE ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":Id_Carrera", $Id_Carrera);
        return $statement->execute();
    }
    //creo la funcion que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($Id_Carrera){
        $consulta = "SELECT * FROM carrera WHERE Id_Carrera = :Id_Carrera";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":Id_Carrera", $Id_Carrera);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'Id_Carrera' => $row["Id_Carrera"],
                'Nombre_Carrera' => $row["Nombre_Carrera"],
                'Codigo' => $row["Codigo"]
            );
        }
        return $json;
    }
    
    //creo la funcion que me va a editar un usuario
    public function editarUsuario($Id_Carrera, $Nombre_Carrera , $Codigo){
        $consulta = "UPDATE carrera SET Nombre_Carrera = :Nombre_Carrera, Codigo = :Codigo WHERE Id_Carrera = :Id_Carrera";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":Id_Carrera", $Id_Carrera);
        $statement->bindValue(":Nombre_Carrera", $Nombre_Carrera);
        $statement->bindValue(":Codigo", $Codigo);
        return $statement->execute();
    }    
}


?>