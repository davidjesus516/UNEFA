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
    public function buscarUsuario($CI){
        $consulta = "SELECT t.ID,t.NOMBRE, t.APELLIDO,
        CONCAT(t.NACIONALIDAD,'-',t.CI) CEDULA, t.GENERO, t.TELEFONO,
        t.E_MAIL, t.CARRERA ID_CARRERA, c.NOMBRE CARRERA, t.STATUS
        FROM tutor_a t 
        left join carrera c on c.id = t.carrera
        WHERE t.STATUS = 1 
        AND t.CI LIKE :CI";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':CI',  $CI );
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'CEDULA' => $row["CEDULA"],
                'NOMBRE' => $row["NOMBRE"],
                'APELLIDO' => $row["APELLIDO"],
                'GENERO' => $row["GENERO"],
                'TELEFONO' => $row["TELEFONO"],
                'E_MAIL' => $row["E_MAIL"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'STATUS' => $row["STATUS"]
            );
        } 
        return $json;
    }
    
    //creo la clase que me va a insertar un nuevo usuario
    public function insertarUsuario($cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$carrera) {
        try{
            $this->pdo->beginTransaction();

            $consulta = "INSERT INTO tutor_a (NOMBRE, APELLIDO,
            CI, NACIONALIDAD, GENERO, TELEFONO, E_MAIL,
            CARRERA, STATUS) VALUES
            (:NOMBRE,:APELLIDO,:CI,:NACIONALIDAD, :GENERO, :TELEFONO,
            :E_MAIL, :CARRERA, :STATUS)";
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':CI', $cedula);
            $statement->bindValue(':NACIONALIDAD', $nacionalidad);
            $statement->bindValue(':NOMBRE', $nombre);
            $statement->bindValue(':APELLIDO', $apellido);
            $statement->bindValue(':GENERO', $genero);
            $statement->bindValue(':TELEFONO', $tlf);
            $statement->bindValue(':E_MAIL', $e_mail);
            $statement->bindValue(':CARRERA', $carrera);
            $statement->bindValue(':STATUS', 1);
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
    
    
    //creo la clase que me va a listar todos los usuarios
    public function listarUsuarios(){
        $consulta ="SELECT t.ID,t.NOMBRE, t.APELLIDO,
        CONCAT(t.NACIONALIDAD,'-',t.CI) CEDULA, t.GENERO, t.TELEFONO,
        t.E_MAIL, t.CARRERA ID_CARRERA, c.NOMBRE CARRERA, t.STATUS
        FROM tutor_a t 
        left join carrera c on c.id = t.carrera
        WHERE t.STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'CEDULA' => $row["CEDULA"],
                'NOMBRE' => $row["NOMBRE"],
                'APELLIDO' => $row["APELLIDO"],
                'GENERO' => $row["GENERO"],
                'TELEFONO' => $row["TELEFONO"],
                'E_MAIL' => $row["E_MAIL"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    //creo la clase que me va a listar todos los usuarios
    public function listarUsuariosInactivos(){
        $consulta ="SELECT t.ID,t.NOMBRE, t.APELLIDO,
         CONCAT(t.NACIONALIDAD,'-',t.CI) CEDULA, t.GENERO, t.TELEFONO,
          t.E_MAIL, t.CARRERA ID_CARRERA, c.NOMBRE CARRERA, t.STATUS
         FROM tutor_a t 
         left join carrera c on c.id = t.carrera
         WHERE t.STATUS = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'CEDULA' => $row["CEDULA"],
                'NOMBRE' => $row["NOMBRE"],
                'APELLIDO' => $row["APELLIDO"],
                'GENERO' => $row["GENERO"],
                'TELEFONO' => $row["TELEFONO"],
                'E_MAIL' => $row["E_MAIL"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    //creo la clase que me va a cambiar el estatus de un usuario
    public function cambiarEstatus($id,$estatus){
        $consulta = "UPDATE tutor_a SET status = :estatus 
        WHERE ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }
    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($id){
        $consulta = "SELECT t.ID,t.NOMBRE, t.APELLIDO,
        CONCAT(t.NACIONALIDAD,'-',t.CI) CEDULA, t.GENERO, t.TELEFONO,
         t.E_MAIL, t.CARRERA ID_CARRERA, c.NOMBRE CARRERA, t.STATUS
        FROM tutor_a t 
        left join carrera c on c.id = t.carrera
        WHERE t.STATUS = 1 
        AND t.ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                
                'ID' => $row["ID"],
                'CEDULA' => $row["CEDULA"],
                'NOMBRE' => $row["NOMBRE"],
                'APELLIDO' => $row["APELLIDO"],
                'GENERO' => $row["GENERO"],
                'TELEFONO' => $row["TELEFONO"],
                'E_MAIL' => $row["E_MAIL"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($id,$cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$carrera){
        $consulta = "UPDATE tutor_a SET
        NOMBRE = :nombre ,APELLIDO = :apellido, 
        NACIONALIDAD = :nacionalidad ,CI = :cedula, GENERO = :genero, 
        TELEFONO = :telefono, E_MAIL = :e_mail,
        CARRERA = :carrera 
        WHERE ID = :id";
        $statement = $this->pdo->prepare($consulta);       
        $statement->bindValue(':id', $id);
        $statement->bindValue(':cedula', $cedula);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':apellido', $apellido);
        $statement->bindValue(':genero', $genero);
        $statement->bindValue(':nacionalidad', $nacionalidad);
        $statement->bindValue(':telefono', $tlf);
        $statement->bindValue(':e_mail', $e_mail);
        $statement->bindValue(':carrera', $carrera);
        return $statement->execute();

    }    
}


?>