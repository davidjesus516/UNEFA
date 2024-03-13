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
    public function buscarUsuario($CI){
        $consulta = "SELECT t.ID,t.NOMBRE, t.APELLIDO,
        CONCAT(t.NACIONALIDAD,'-',t.CI) CEDULA, t.GENERO, t.TELEFONO,
        t.E_MAIL,t.Cargo,t.PROFESION t.ID_empresa, e.NOMBRE EMPRESA , 
        t.STATUS
         FROM tutor_inst t 
         left join empresa e on e.id = t.ID_empresa
         WHERE t.STATUS = 1
        AND t.CI LIKE :CI";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':CI', '%' . $CI . '%');
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
                'CARGO' => $row["CARGO"],
                'PROFESION' => $row["PROFESION"],
                'ID_empresa' => $row["ID_empresa"],
                'EMPRESA' => $row["EMPRESA"],
                'STATUS' => $row["STATUS"]
            );
        } 
        return $json;
    }
    
    //creo la clase que me va a insertar un nuevo usuario
    public function insertarUsuario($cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$cargo,$profesion,$empresa) {
        try{
            $this->pdo->beginTransaction();

            $consulta = "INSERT INTO tutor_inst (NOMBRE, APELLIDO,
            CI, NACIONALIDAD, GENERO, TELEFONO, E_MAIL,
            CARGO, PROFESION, ID_EMPRESA, STATUS) VALUES
            (:NOMBRE,:APELLIDO,:CI,:NACIONALIDAD, :GENERO, :TELEFONO,
            :E_MAIL, :cargo, :profesion, :empresa, :STATUS)";
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':CI', $cedula);
            $statement->bindValue(':NACIONALIDAD', $nacionalidad);
            $statement->bindValue(':NOMBRE', $nombre);
            $statement->bindValue(':APELLIDO', $apellido);
            $statement->bindValue(':GENERO', $genero);
            $statement->bindValue(':TELEFONO', $tlf);
            $statement->bindValue(':E_MAIL', $e_mail);
            $statement->bindValue(':cargo', $cargo);
            $statement->bindValue(':profesion', $profesion);
            $statement->bindValue(':empresa', $empresa);
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
        $consulta ="SELECT t.ID,t.NOMBRE, t.APELLIDO, CONCAT(t.NACIONALIDAD,'-',t.CI) CEDULA, t.GENERO, t.TELEFONO,t.E_MAIL, t.CARGO,t.PROFESION ,t.ID_empresa, e.NOMBRE EMPRESA , t.STATUS FROM tutor_inst t left join empresa e on e.id = t.ID_empresa WHERE t.STATUS = 1";
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
                'CARGO' => $row["CARGO"],
                'PROFESION' => $row["PROFESION"],
                'ID_empresa' => $row["ID_empresa"],
                'EMPRESA' => $row["EMPRESA"],
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
                'CARGO' => $row["CARGO"],
                'PROFESION' => $row["PROFESION"],
                'ID_empresa' => $row["ID_empresa"],
                'EMPRESA' => $row["EMPRESA"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    //creo la clase que me va a cambiar el estatus de un usuario
    public function cambiarEstatus($id,$estatus){
        $consulta = "UPDATE tutor_inst SET status = :estatus 
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
        t.E_MAIL,t.Cargo,t.PROFESION t.ID_empresa, e.NOMBRE EMPRESA , 
        t.STATUS
         FROM tutor_inst t 
         left join empresa e on e.id = t.ID_empresa
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
                'CARGO' => $row["CARGO"],
                'PROFESION' => $row["PROFESION"],
                'ID_empresa' => $row["ID_empresa"],
                'EMPRESA' => $row["EMPRESA"],
                'STATUS' => $row["STATUS"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($id,$cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$cargo,$profesion,$empresa){

        $consulta = "UPDATE tutor_inst SET
        NOMBRE = :nombre ,APELLIDO = :apellido, 
        NACIONALIDAD = :nacionalidad ,CI = :CI, GENERO = :genero, 
        TELEFONO = :telefono, E_MAIL = :e_mail,
        CARGO = :cargo,  PROFESION = :profesion, ID_EMPRESA = :empresa
        WHERE ID = :id";
        $statement = $this->pdo->prepare($consulta);       
        $statement->bindValue(':id', $id);
        $statement->bindValue(':CI', $cedula);
        $statement->bindValue(':NACIONALIDAD', $nacionalidad);
        $statement->bindValue(':NOMBRE', $nombre);
        $statement->bindValue(':APELLIDO', $apellido);
        $statement->bindValue(':GENERO', $genero);
        $statement->bindValue(':TELEFONO', $tlf);
        $statement->bindValue(':E_MAIL', $e_mail);
        $statement->bindValue(':cargo', $cargo);
        $statement->bindValue(':profesion', $profesion);
        $statement->bindValue(':empresa', $empresa);
        return $statement->execute();

    }    
}


?>