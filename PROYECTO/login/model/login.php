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
        $this->conexion = new Conexion('localhost', 'mydb', 'root', '');
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

        $sql = 'SELECT *FROM `t-user` WHERE ID = :ID';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':ID', $ID);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;

}   
public function UserCreate($USER, $CEDULA, $NAME, $SURNAME, $EMAIL, $PHONE_NUMBER, $KEY){
    try {
    $sql = "INSERT INTO `t-user`(`USER`, `CEDULA`, `NAME`, `SURNAME`, `EMAIL`, `PHONE_NUMBER`, `CREATION_DATE`, `LOGIN`, `TERMS_CONDITIONS`, `STATUS_SESSION`, `STATUS`) VALUES (:USER, :CEDULA, :NAME, :SURNAME, :EMAIL, :PHONE_NUMBER, :CREATION_DATE, :LOGIN, :TERMS_CONDITIONS, :STATUS_SESSION, :STATUS)";
    $statement = $this->pdo->beginTransaction();
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(':USER', $USER);
    $statement->bindValue(':CEDULA', $CEDULA);
    $statement->bindValue(':NAME', $NAME);
    $statement->bindValue(':SURNAME', $SURNAME);
    $statement->bindValue(':EMAIL', $EMAIL);
    $statement->bindValue(':PHONE_NUMBER', $PHONE_NUMBER);
    $statement->bindValue(':CREATION_DATE', date("Y-m-d H:i:s"));
    $statement->bindValue(':LOGIN', 0);
    $statement->bindValue(':TERMS_CONDITIONS', 0);
    $statement->bindValue(':STATUS_SESSION', 1);
    $statement->bindValue(':STATUS', 1);
    $statement->execute();

    $id = $this->pdo->lastInsertId();
    $sql2 = "INSERT INTO `t-user_key`( `USER_ID`, `KEY`, `START_DATE`, `END_DATE`, `STATUS`) VALUES (:USER_ID, :KEY, :START_DATE, :END_DATE, :STATUS)";
    $statement2 = $this->pdo->prepare($sql2);
    $statement2->bindValue(':USER_ID', $id);
    $statement2->bindValue(':KEY', $KEY);
    $statement2->bindValue(':START_DATE', date("Y-m-d H:i:s"));
    $statement2->bindValue(':END_DATE', date("Y-m-d H:i:s"));
    $statement2->bindValue(':STATUS', 1);
    $statement2->execute();
    $this->pdo->commit();
    return true;
    } catch (Exception $e) {
        if ($e->getCode() == 23000) {
            return false;
        }
        else{
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
public function SearchUsername($username){

    $consulta = "SELECT * FROM `t-user` WHERE `USER` = :username";
    $statement = $this->pdo->prepare($consulta);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row;

}
public function SearchUserKey($UserId){

    $consulta = "SELECT * FROM `t-user_key` WHERE `USER_ID` = :UserId";
    $statement = $this->pdo->prepare($consulta);
    $statement->bindValue(':UserId', $UserId);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row;

}
public function login($username){
    $consulta = "SELECT * FROM `t-user` u left join `t-user_key` k on u.USER_ID = k.USER_ID WHERE `USER` = :username";
    $statement = $this->pdo->prepare($consulta);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row;
    }
}
?>