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
    public function buscarUsuario($cedula){
        $consulta = "SELECT * FROM estudiante WHERE CI LIKE :cedula";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula', $cedula);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'NOMBRE' => $row["NOMBRE"],
                'APELLIDO' => $row["APELLIDO"],
                'NACIONALIDAD' => $row["NACIONALIDAD"],
                'GENERO' => $row["GENERO"],
                'TELEFONO' => $row["TELEFONO"],
                'E_MAIL' => $row["E_MAIL"],
                'RANGO_MILITAR' => $row["RANGO_MILITAR"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'TURNO' => $row["TURNO"],
                'ESTATUS' => $row["ESTATUS"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a insertar un nuevo usuario
    public function insertarUsuario($cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$rango_militar,$carrera,
    $turno,$estatus) {
        try {
            $consulta = "INSERT INTO estudiante (NOMBRE, APELLIDO,
            CI, NACIONALIDAD, GENERO, TELEFONO, E_MAIL, RANGO_MILITAR,
            ID_CARRERA, TURNO, ESTATUS)
            VALUES
            (:nombre, :apellido, :cedula, :nacionalidad, :genero, 
            :telefono, :e_mail, :rango_militar, :carrera, :turno, :estatus)";
            $statement = $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':cedula', $cedula);
            $statement->bindValue(':nombre', $nombre);
            $statement->bindValue(':apellido', $apellido);
            $statement->bindValue(':genero', $genero);
            $statement->bindValue(':nacionalidad', $nacionalidad);
            $statement->bindValue(':telefono', $tlf);
            $statement->bindValue(':e_mail', $e_mail);
            $statement->bindValue(':rango_militar', $rango_militar);
            $statement->bindValue(':carrera', $carrera);
            $statement->bindValue(':turno', $turno);
            $statement->bindValue(':estatus', $estatus);
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
        $consulta = "SELECT e.ID, e.NOMBRE, e.APELLIDO,
        CONCAT (e.NACIONALIDAD,'-',e.CI)AS CEDULA, e.GENERO, e.TELEFONO, e.E_MAIL, e.RANGO_MILITAR,
        e.ID_CARRERA, c.nombre as CARRERA, e.TURNO, e.ESTATUS FROM estudiante e left join carrera c on e.ID_CARRERA = c.ID
        WHERE e.estatus = 1";
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
                'RANGO_MILITAR' => $row["RANGO_MILITAR"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'TURNO' => $row["TURNO"],
                'ESTATUS' => $row["ESTATUS"]
            );
        }
        return $json;
    }
    public function listarUsuariosProspectos(){
        $consulta = "SELECT e.ID, e.NOMBRE, e.APELLIDO,
        CONCAT (e.NACIONALIDAD,'-',e.CI)AS CEDULA, e.GENERO, e.TELEFONO, e.E_MAIL, e.RANGO_MILITAR,
        e.ID_CARRERA, c.nombre as CARRERA, e.TURNO, e.ESTATUS FROM estudiante e left join carrera c on e.ID_CARRERA = c.ID
        WHERE e.estatus = 2";
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
                'RANGO_MILITAR' => $row["RANGO_MILITAR"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'TURNO' => $row["TURNO"],
                'ESTATUS' => $row["ESTATUS"]
            );
        }
        return $json;
    }
    public function listarUsuariosAprobados(){
        $consulta = "SELECT e.ID, e.NOMBRE, e.APELLIDO,
        CONCAT (e.NACIONALIDAD,'-',e.CI)AS CEDULA, e.GENERO, e.TELEFONO, e.E_MAIL, e.RANGO_MILITAR,
        e.ID_CARRERA, c.nombre as CARRERA, e.TURNO, e.ESTATUS FROM estudiante e left join carrera c on e.ID_CARRERA = c.ID
        WHERE e.estatus = 3";
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
                'RANGO_MILITAR' => $row["RANGO_MILITAR"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'TURNO' => $row["TURNO"],
                'ESTATUS' => $row["ESTATUS"]
            );
        }
        return $json;
    }
    public function listarUsuariosInactivos(){
        $consulta = "SELECT e.ID, e.NOMBRE, e.APELLIDO,
        CONCAT (e.NACIONALIDAD,'-',e.CI)AS CEDULA, e.GENERO, e.TELEFONO, e.E_MAIL, e.RANGO_MILITAR,
        e.ID_CARRERA, c.nombre as CARRERA, e.TURNO, e.ESTATUS FROM estudiante e left join carrera c on e.ID_CARRERA = c.ID
        WHERE e.estatus = 0";
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
                'RANGO_MILITAR' => $row["RANGO_MILITAR"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'CARRERA' => $row["CARRERA"],
                'TURNO' => $row["TURNO"],
                'ESTATUS' => $row["ESTATUS"]
            );
        }
        return $json;
    }
    //creo la clase que me va a eliminar un usuario
    public function eliminarUsuario($id,$estatus){
        $consulta = "UPDATE estudiante SET estatus = :estatus WHERE id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }
    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($id){
        $consulta = "SELECT * FROM estudiante WHERE estatus = 1
        AND ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'ID' => $row["ID"],
                'NOMBRE' => $row["NOMBRE"],
                'APELLIDO' => $row["APELLIDO"],
                'CEDULA' => $row["CI"],
                'NACIONALIDAD' => $row["NACIONALIDAD"],
                'GENERO' => $row["GENERO"],
                'TELEFONO' => $row["TELEFONO"],
                'E_MAIL' => $row["E_MAIL"],
                'RANGO_MILITAR' => $row["RANGO_MILITAR"],
                'ID_CARRERA' => $row["ID_CARRERA"],
                'TURNO' => $row["TURNO"],
                'ESTATUS' => $row["ESTATUS"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($id,$cedula,$nacionalidad,$nombre,
    $apellido,$genero,$tlf,$e_mail,$rango_militar,$carrera,
    $turno){
        $consulta = "UPDATE estudiante SET NOMBRE = :nombre, APELLIDO = :apellido, GENERO = :genero, CI = :cedula, NACIONALIDAD = :nacionalidad, TELEFONO = :telefono, E_MAIL = :e_mail, RANGO_MILITAR = :rango_militar, ID_CARRERA = :carrera, TURNO = :turno WHERE ID = :id"; 
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':cedula', $cedula);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':apellido', $apellido);
        $statement->bindValue(':genero', $genero);
        $statement->bindValue(':nacionalidad', $nacionalidad);
        $statement->bindValue(':telefono', $tlf);
        $statement->bindValue(':e_mail', $e_mail);
        $statement->bindValue(':rango_militar', $rango_militar);
        $statement->bindValue(':carrera', $carrera);
        $statement->bindValue(':turno', $turno);
        return $statement->execute();
    }    
}


?>