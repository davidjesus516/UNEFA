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
        $this->conexion = new Conexion('localhost', 'instituciont', 'root', '');
        $this->pdo = $this->conexion->conectar();
    }

    //creo la clase que me va a consultar todos los datos que exista y me los traera y guardarlos en una variable
    public function filtrarInscripcion($id){
        $consulta = "SELECT inscripcion.id, lapso_academico.nombre AS lapso_academico, estudiante.id_persona, persona.nombre AS estudiante_nombre, persona.apellido AS estudiante_apellido, empresa.nombre AS empresa_nombre, carrera.nombre AS carrera_nombre, docente.id_persona AS docente_id_persona, persona_docente.nombre AS docente_nombre, persona_docente.apellido AS docente_apellido, tutor_empresarial.id_persona AS tutor_empresarial_id_persona, persona_tutor_empresarial.nombre AS tutor_empresarial_nombre, persona_tutor_empresarial.apellido AS tutor_empresarial_apellido
        FROM inscripcion
        JOIN lapso_academico ON inscripcion.id_lapso_academico = lapso_academico.codigo
        JOIN estudiante ON inscripcion.id_estudiante = estudiante.id
        JOIN persona ON estudiante.id_persona = persona.cedula
        JOIN empresa ON inscripcion.id_empresa = empresa.id
        JOIN carrera ON inscripcion.id_carrera = carrera.codigo
        JOIN docente ON inscripcion.id_docente = docente.id
        JOIN persona AS persona_docente ON docente.id_persona = persona_docente.cedula
        JOIN tutor_empresarial ON inscripcion.id_tutor_empresarial = tutor_empresarial.id
        JOIN persona AS persona_tutor_empresarial ON tutor_empresarial.id_persona = persona_tutor_empresarial.cedula
        WHERE inscripcion.estatus = 1
        AND inscripcion.id_docente = :id_docente";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id_docente', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'lapso_academico' => $row["lapso_academico"],
                'id_persona' => $row["id_persona"],
                'estudiante_nombre' => $row["estudiante_nombre"],
                'estudiante_apellido' => $row["estudiante_apellido"],
                'empresa_nombre' => $row["empresa_nombre"],
                'carrera_nombre' => $row["carrera_nombre"],
                'docente_id_persona' => $row["docente_id_persona"],
                'docente_nombre' => $row["docente_nombre"],
                'docente_apellido' => $row["docente_apellido"],
                'tutor_empresarial_id_persona' => $row["tutor_empresarial_id_persona"],
                'tutor_empresarial_nombre' => $row["tutor_empresarial_nombre"],
                'tutor_empresarial_apellido' => $row["tutor_empresarial_apellido"]
            );
        }
        return $json;
    }

    public function filtrarInscripcionCarrera($id){
        $consulta = "SELECT inscripcion.id, lapso_academico.nombre AS lapso_academico, estudiante.id_persona, persona.nombre AS estudiante_nombre, persona.apellido AS estudiante_apellido, empresa.nombre AS empresa_nombre, carrera.nombre AS carrera_nombre, docente.id_persona AS docente_id_persona, persona_docente.nombre AS docente_nombre, persona_docente.apellido AS docente_apellido, tutor_empresarial.id_persona AS tutor_empresarial_id_persona, persona_tutor_empresarial.nombre AS tutor_empresarial_nombre, persona_tutor_empresarial.apellido AS tutor_empresarial_apellido
        FROM inscripcion
        JOIN lapso_academico ON inscripcion.id_lapso_academico = lapso_academico.codigo
        JOIN estudiante ON inscripcion.id_estudiante = estudiante.id
        JOIN persona ON estudiante.id_persona = persona.cedula
        JOIN empresa ON inscripcion.id_empresa = empresa.id
        JOIN carrera ON inscripcion.id_carrera = carrera.codigo
        JOIN docente ON inscripcion.id_docente = docente.id
        JOIN persona AS persona_docente ON docente.id_persona = persona_docente.cedula
        JOIN tutor_empresarial ON inscripcion.id_tutor_empresarial = tutor_empresarial.id
        JOIN persona AS persona_tutor_empresarial ON tutor_empresarial.id_persona = persona_tutor_empresarial.cedula
        WHERE inscripcion.estatus = 1
        AND inscripcion.id_carrera = :id_carrera";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id_carrera', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'lapso_academico' => $row["lapso_academico"],
                'id_persona' => $row["id_persona"],
                'estudiante_nombre' => $row["estudiante_nombre"],
                'estudiante_apellido' => $row["estudiante_apellido"],
                'empresa_nombre' => $row["empresa_nombre"],
                'carrera_nombre' => $row["carrera_nombre"],
                'docente_id_persona' => $row["docente_id_persona"],
                'docente_nombre' => $row["docente_nombre"],
                'docente_apellido' => $row["docente_apellido"],
                'tutor_empresarial_id_persona' => $row["tutor_empresarial_id_persona"],
                'tutor_empresarial_nombre' => $row["tutor_empresarial_nombre"],
                'tutor_empresarial_apellido' => $row["tutor_empresarial_apellido"]
            );
        }
        return $json;
    }

    public function filtrarInscripcionTutor($id){
        $consulta = "SELECT inscripcion.id, lapso_academico.nombre AS lapso_academico, estudiante.id_persona, persona.nombre AS estudiante_nombre, persona.apellido AS estudiante_apellido, empresa.nombre AS empresa_nombre, carrera.nombre AS carrera_nombre, docente.id_persona AS docente_id_persona, persona_docente.nombre AS docente_nombre, persona_docente.apellido AS docente_apellido, tutor_empresarial.id_persona AS tutor_empresarial_id_persona, persona_tutor_empresarial.nombre AS tutor_empresarial_nombre, persona_tutor_empresarial.apellido AS tutor_empresarial_apellido
        FROM inscripcion
        JOIN lapso_academico ON inscripcion.id_lapso_academico = lapso_academico.codigo
        JOIN estudiante ON inscripcion.id_estudiante = estudiante.id
        JOIN persona ON estudiante.id_persona = persona.cedula
        JOIN empresa ON inscripcion.id_empresa = empresa.id
        JOIN carrera ON inscripcion.id_carrera = carrera.codigo
        JOIN docente ON inscripcion.id_docente = docente.id
        JOIN persona AS persona_docente ON docente.id_persona = persona_docente.cedula
        JOIN tutor_empresarial ON inscripcion.id_tutor_empresarial = tutor_empresarial.id
        JOIN persona AS persona_tutor_empresarial ON tutor_empresarial.id_persona = persona_tutor_empresarial.cedula
        WHERE inscripcion.estatus = 1
        AND inscripcion.id_tutor_empresarial = :id_tutor";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id_tutor', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'lapso_academico' => $row["lapso_academico"],
                'id_persona' => $row["id_persona"],
                'estudiante_nombre' => $row["estudiante_nombre"],
                'estudiante_apellido' => $row["estudiante_apellido"],
                'empresa_nombre' => $row["empresa_nombre"],
                'carrera_nombre' => $row["carrera_nombre"],
                'docente_id_persona' => $row["docente_id_persona"],
                'docente_nombre' => $row["docente_nombre"],
                'docente_apellido' => $row["docente_apellido"],
                'tutor_empresarial_id_persona' => $row["tutor_empresarial_id_persona"],
                'tutor_empresarial_nombre' => $row["tutor_empresarial_nombre"],
                'tutor_empresarial_apellido' => $row["tutor_empresarial_apellido"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a insertar un nuevo usuario
    public function insertarUsuario($lapso,$carrera,$estudiante,$empresa,$docente,$tutor,$estatus) {
        $consulta = "INSERT INTO inscripcion (id_lapso_academico, id_estudiante, id_empresa, id_carrera, id_docente, id_tutor_empresarial, estatus) VALUES (:id_lapso_academico, :id_estudiante, :id_empresa, :id_carrera, :id_docente, :id_tutor_empresarial, :estatus)";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id_lapso_academico', $lapso);
        $statement->bindValue(':id_estudiante', $estudiante);
        $statement->bindValue(':id_empresa', $empresa);
        $statement->bindValue(':id_carrera', $carrera);
        $statement->bindValue(':id_docente', $docente);
        $statement->bindValue(':id_tutor_empresarial', $tutor);
        $statement->bindValue(':estatus', $estatus);
        $statement->execute();
    }
    
    
    //creo la clase que me va a listar todos los usuarios
    public function listarUsuarios(){
        $consulta = "SELECT inscripcion.id, lapso_academico.nombre AS lapso_academico, estudiante.id_persona, persona.nombre AS estudiante_nombre, persona.apellido AS estudiante_apellido, empresa.nombre AS empresa_nombre, carrera.nombre AS carrera_nombre, docente.id_persona AS docente_id_persona, persona_docente.nombre AS docente_nombre, persona_docente.apellido AS docente_apellido, tutor_empresarial.id_persona AS tutor_empresarial_id_persona, persona_tutor_empresarial.nombre AS tutor_empresarial_nombre, persona_tutor_empresarial.apellido AS tutor_empresarial_apellido
        FROM inscripcion
        JOIN lapso_academico ON inscripcion.id_lapso_academico = lapso_academico.codigo
        JOIN estudiante ON inscripcion.id_estudiante = estudiante.id
        JOIN persona ON estudiante.id_persona = persona.cedula
        JOIN empresa ON inscripcion.id_empresa = empresa.id
        JOIN carrera ON inscripcion.id_carrera = carrera.codigo
        JOIN docente ON inscripcion.id_docente = docente.id
        JOIN persona AS persona_docente ON docente.id_persona = persona_docente.cedula
        JOIN tutor_empresarial ON inscripcion.id_tutor_empresarial = tutor_empresarial.id
        JOIN persona AS persona_tutor_empresarial ON tutor_empresarial.id_persona = persona_tutor_empresarial.cedula
        WHERE inscripcion.estatus = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'lapso_academico' => $row["lapso_academico"],
                'id_persona' => $row["id_persona"],
                'estudiante_nombre' => $row["estudiante_nombre"],
                'estudiante_apellido' => $row["estudiante_apellido"],
                'empresa_nombre' => $row["empresa_nombre"],
                'carrera_nombre' => $row["carrera_nombre"],
                'docente_id_persona' => $row["docente_id_persona"],
                'docente_nombre' => $row["docente_nombre"],
                'docente_apellido' => $row["docente_apellido"],
                'tutor_empresarial_id_persona' => $row["tutor_empresarial_id_persona"],
                'tutor_empresarial_nombre' => $row["tutor_empresarial_nombre"],
                'tutor_empresarial_apellido' => $row["tutor_empresarial_apellido"]
            );
        }
        return $json;
    }
    //creo la clase que me va a eliminar un usuario
    public function eliminarUsuario($id,$estatus){
        $consulta = "UPDATE inscripcion SET estatus = :estatus WHERE id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }
    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searcheditUsuario($id){
        $consulta = "SELECT inscripcion.id, lapso_academico.nombre AS lapso_academico, estudiante.id_persona, persona.nombre AS estudiante_nombre, persona.apellido AS estudiante_apellido, empresa.nombre AS empresa_nombre, carrera.nombre AS carrera_nombre, docente.id_persona AS docente_id_persona, persona_docente.nombre AS docente_nombre, persona_docente.apellido AS docente_apellido, tutor_empresarial.id_persona AS tutor_empresarial_id_persona, persona_tutor_empresarial.nombre AS tutor_empresarial_nombre, persona_tutor_empresarial.apellido AS tutor_empresarial_apellido
        FROM inscripcion
        JOIN lapso_academico ON inscripcion.id_lapso_academico = lapso_academico.codigo
        JOIN estudiante ON inscripcion.id_estudiante = estudiante.id
        JOIN persona ON estudiante.id_persona = persona.cedula
        JOIN empresa ON inscripcion.id_empresa = empresa.id
        JOIN carrera ON inscripcion.id_carrera = carrera.codigo
        JOIN docente ON inscripcion.id_docente = docente.id
        JOIN persona AS persona_docente ON docente.id_persona = persona_docente.cedula
        JOIN tutor_empresarial ON inscripcion.id_tutor_empresarial = tutor_empresarial.id
        JOIN persona AS persona_tutor_empresarial ON tutor_empresarial.id_persona = persona_tutor_empresarial.cedula
        WHERE inscripcion.estatus = 1
        AND inscripcion.id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["id"],
                'lapso_academico' => $row["lapso_academico"],
                'id_persona' => $row["id_persona"],
                'estudiante_nombre' => $row["estudiante_nombre"],
                'estudiante_apellido' => $row["estudiante_apellido"],
                'empresa_nombre' => $row["empresa_nombre"],
                'carrera_nombre' => $row["carrera_nombre"],
                'docente_id_persona' => $row["docente_id_persona"],
                'docente_nombre' => $row["docente_nombre"],
                'docente_apellido' => $row["docente_apellido"],
                'tutor_empresarial_id_persona' => $row["tutor_empresarial_id_persona"],
                'tutor_empresarial_nombre' => $row["tutor_empresarial_nombre"],
                'tutor_empresarial_apellido' => $row["tutor_empresarial_apellido"]
            );
        }
        return $json;
    }
    
    //creo la clase que me va a editar un usuario
    public function editarUsuario($id,$cedula,$nombre,$apellido,$genero,$fecha_nacimiento,$rif,$direccion){
        $consulta = "UPDATE persona SET nombre = :nombre, apellido = :apellido, genero = :genero, fecha_nacimiento = :fecha_nacimiento, rif = :rif,direccion = :direccion  WHERE cedula = :cedula";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':apellido', $apellido);
        $statement->bindValue(':genero', $genero);
        $statement->bindValue(':fecha_nacimiento', $fecha_nacimiento);
        $statement->bindValue(':rif', $rif);
        $statement->bindValue(':direccion', $direccion);
        $statement->bindValue(':cedula', $cedula);
        return $statement->execute();
    }    
}


?>