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
    public function buscarUsuario($cedula){
        $consulta = "SELECT * FROM estudiante WHERE estatus = 1 AND cedula LIKE :cedula";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula',$cedula);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id_persona' => $row["id_persona"]
            );
        }
        return $json;
    }
    
      //creo la clase que me va a insertar un nuevo usuario
      public function inscribirNuevo($cedula,$nacionalidad,$nombre,
      $apellido,$genero,$tlf,$e_mail,$rango_m,$carrera,$turno,$estatus,
      $tutor_a,$tutor_i,$empresa,$lapso,$status2) {
          try {
            $consulta = "INSERT INTO estudiante (NOMBRE, APELLIDO,CI, NACIONALIDAD, GENERO, TELEFONO, E_MAIL, RANGO_MILITAR,ID_CARRERA, TURNO, ESTATUS) VALUES (:nombre, :apellido, :cedula, :nacionalidad, :genero, :telefono,:e_mail, :rango_militar, :carrera, :turno, :estatus)";
              
            $consulta2 = "INSERT INTO inscripcion (ID_ESTUDIANTE,ID_TUTOR_A, ID_TUTOR_I, ID_EMPRESA, ID_LAPSO, STATUS) VALUE (:ID_ESTUDIANTES, :ID_TUTOR_A, :ID_TUTOR_I,:ID_EMPRESA, :ID_LAPSO, :STATUS)";
              
            $consulta3 = "INSERT INTO calificacion (ID_INSCRIPCION,TUTOR_A, TUTOR_I, COMITE, TOTAL) VALUES (:id_inscripcion, 0,0,0,0)";
  
            $statement = $this->pdo->beginTransaction();
  
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':cedula', $cedula);
            $statement->bindValue(':nombre', $nombre);
            $statement->bindValue(':apellido', $apellido);
            $statement->bindValue(':genero', $genero);
            $statement->bindValue(':nacionalidad', $nacionalidad);
            $statement->bindValue(':telefono', $tlf);
            $statement->bindValue(':e_mail', $e_mail);
            $statement->bindValue(':rango_militar', $rango_m);
            $statement->bindValue(':carrera', $carrera);
            $statement->bindValue(':turno', $turno);
            $statement->bindValue(':estatus', $estatus);
            $statement->execute();
              
            $id = $this->pdo->lastInsertId();
            $statement2 = $this->pdo->prepare($consulta2);
            $statement2->bindValue(':ID_ESTUDIANTES',$id);
            $statement2->bindValue(':ID_TUTOR_A',$tutor_a);
            $statement2->bindValue(':ID_TUTOR_I',$tutor_i);
            $statement2->bindValue(':ID_EMPRESA',$empresa);
            $statement2->bindValue(':ID_LAPSO',$lapso);
            $statement2->bindValue(':STATUS',$status2);
            $statement2->execute();

            $id2 = $this->pdo->lastInsertId();
              $statement3 = $this->pdo->prepare($consulta3);
              $statement3->bindValue(':id_inscripcion',$id2);
              $statement3->execute();
      
              $this->pdo->commit();
              return TRUE;
          } catch (PDOException $e) {
              if ($e->getCode() == "23000") { // Código de error para clave duplicada
                  return false; // Usuario duplicado
              } else {
                  $this->pdo->rollBack();
                  throw $e; // Se lanza la excepción para manejarla en otro lugar
              }
          }
      }
      //creo la clase que me va a insertar un nuevo usuario
      public function inscribir($estudiante,$tutor_a,$tutor_i,$empresa,
      $lapso,$status2) {
        try {
            $consulta = "INSERT INTO inscripcion (ID_ESTUDIANTE,ID_TUTOR_A, ID_TUTOR_I, ID_EMPRESA, ID_LAPSO, STATUS) VALUE (:ID_ESTUDIANTES, :ID_TUTOR_A, :ID_TUTOR_I, :ID_EMPRESA, :ID_LAPSO, :STATUS)";
            $consulta2 = "INSERT INTO calificacion (ID_INSCRIPCION,TUTOR_A, TUTOR_I, COMITE, TOTAL) VALUES (:id_inscripcion, 0,0,0,0)";

            $statement = $this->pdo->beginTransaction();
   
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':ID_ESTUDIANTES',$estudiante);
            $statement->bindValue(':ID_TUTOR_A',$tutor_a);
            $statement->bindValue(':ID_TUTOR_I',$tutor_i);
            $statement->bindValue(':ID_EMPRESA',$empresa);
            $statement->bindValue(':ID_LAPSO',$lapso);
            $statement->bindValue(':STATUS',$status2);
            $statement->execute();
   
            $id = $this->pdo->lastInsertId();
            $statement2 = $this->pdo->prepare($consulta2);
            $statement2->bindValue(':id_inscripcion',$id);
            $statement2->execute();
            $this->pdo->commit();
            return TRUE;
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
    public function listarUsuariosAprobados(){
        $consulta = "SELECT * FROM estudiante WHERE estudiante.estatus = 2";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'id_persona' => $row["id_persona"],
                'cedula' => $row["cedula"],
                'nombre' => $row["nombre"],
                'apellido' => $row["apellido"],
                'genero' => $row["genero"]
            );
        }
        return $json;
    }
    public function listarUsuariosInactivos(){
        $consulta = "SELECT * FROM estudiante WHERE estudiante.estatus = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'id_persona' => $row["id_persona"],
                'fecha_hora' => $row["fecha_hora"],
                'cedula' => $row["cedula"],
                'nombre' => $row["nombre"],
                'apellido' => $row["apellido"],
                'genero' => $row["genero"],
                'direccion' => $row["direccion"],
                'fecha_hora' => $row["fecha_hora"]
            );
        }
        return $json;
    }
    //creo la clase que me va a eliminar un usuario
    public function eliminarUsuario($cedula,$estatus){
        $consulta = "UPDATE estudiante SET estatus = :estatus WHERE id_persona = :id_persona";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':id_persona', $cedula);
        return $statement->execute();
    }
    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($cedula){
        $consulta = "SELECT * FROM estudiante JOIN persona ON estudiante.id_persona = persona.Cedula WHERE estudiante.estatus = 1 AND persona.cedula = :cedula";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':cedula', $cedula);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'id_persona' => $row["id_persona"],
                'fecha_hora' => $row["fecha_hora"],
                'cedula' => $row["cedula"],
                'nombre' => $row["nombre"],
                'apellido' => $row["apellido"],
                'genero' => $row["genero"],
                'direccion' => $row["direccion"],
                'fecha_hora' => $row["fecha_hora"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($id,$cedula,$nombre,$apellido,$genero,$direccion){
        $consulta = "UPDATE persona SET nombre = :nombre, apellido = :apellido, genero = :genero,direccion = :direccion  WHERE cedula = :cedula";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':apellido', $apellido);
        $statement->bindValue(':genero', $genero);
        $statement->bindValue(':direccion', $direccion);
        $statement->bindValue(':cedula', $cedula);
        return $statement->execute();
    }    
}


?>