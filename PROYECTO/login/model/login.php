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
public function contraseñanueva($id, $password){
        $sql = "UPDATE `usuarios` SET `password`= :password WHERE ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':password', $password);
        $statement->execute();
        

    }

public function validar($ID){

        $sql = 'SELECT *FROM usuarios WHERE ID = :ID';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':ID', $ID);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;

}

public function login($username,$password){
        $consulta = "SELECT * FROM usuarios WHERE username = :username AND password = :password";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    public function bucar_usuario($usuario){

        $consulta = "SELECT * FROM usuarios WHERE username = :username";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':username', $usuario);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;

}
}
?>