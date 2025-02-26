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

    //creo la clase que me va a consultar todos los datos que exista y me los traera y guardarlos en una variable
    public function buscar($rif){
        $consulta = "SELECT e.ID, e.NOMBRE, CONCAT(e.L_RIF,'-',e.RIF) 
        RIF, e.TELEFONO, e.DIRECCION, e.N_PASANTES, c.id C_ID,c.NOMBRE
        CARRERA, c.CODIGO C_CODIGO FROM empresa as e 
        left join carrera as c on e.carrera = c.id
        WHERE e.STATUS = 1 AND RIF LIKE :rif";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':rif', '%' . $rif . '%');
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'rif' => $row["RIF"],
                'nombre' => $row["NOMBRE"],
                'direccion' => $row["DIRECCION"],
                'telefono_empresa' => $row["TELEFONO"],
                'carrera' => $row["CARRERA"],
                'c_idid' => $row["C_ID"],
                'c_codigo' => $row["C_CODIGO"]
            );
        }
        return $json;
    } 
    
    //creo la clase que me va a insertar un nuevo usuario
    public function insertar($l_rif,$rif,$nombre,$direccion,$telefono_empresa,$n_pasantes,$carrera,$estatus){
        try {
            $this->pdo->beginTransaction();
            $consulta = "INSERT INTO empresa (l_rif, rif, nombre,
            direccion, telefono, n_pasantes, carrera,
            STATUS) VALUES (:l_rif,:rif, :nombre, :direccion, :telefono_empresa, :n_pasantes, :carrera, :estatus)";
            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':l_rif', $l_rif);
            $statement->bindValue(':rif', $rif);
            $statement->bindValue(':nombre', $nombre);
            $statement->bindValue(':direccion', $direccion);
            $statement->bindValue(':telefono_empresa', $telefono_empresa);
            $statement->bindValue(':n_pasantes', $n_pasantes);
            $statement->bindValue(':carrera', $carrera);
            $statement->bindValue(':estatus', $estatus);
            $statement->execute();
            $this->pdo->commit();
            return true;    
        } catch (PDOException $e) {
            if ($e->getCode() == "23000") {
                 // Código de error para clave duplicada
                return false; // Usuario duplicado
            } 
            else {
                $this->pdo->rollBack();
                throw $e; // Se lanza la excepción para manejarla en otro lugar
            }
        }
    }  
    
    //creo la funcion que me va a listar todos las empresas activos
    public function listar_a(){
        $consulta = "SELECT e.ID, e.NOMBRE, CONCAT(e.L_RIF,'-',e.RIF)  RIF, e.TELEFONO, e.DIRECCION, e.N_PASANTES, c.id C_ID,c.NOMBRE CARRERA, c.CODIGO C_CODIGO FROM empresa as e left join carrera as c on e.carrera = c.id WHERE e.STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'rif' => $row["RIF"],
                'nombre' => $row["NOMBRE"],
                'direccion' => $row["DIRECCION"],
                'telefono_empresa' => $row["TELEFONO"],
                'n_pasantes' => $row['N_PASANTES'],
                'carrera' => $row["CARRERA"],
                'c_id' => $row["C_ID"],
                'c_codigo' => $row["C_CODIGO"]
            );
        }
        return $json;
    }
    //creo la funcion que me va a listar todas las empresas inactivos
    public function listar_i(){
        $consulta = "SELECT e.ID, e.NOMBRE, CONCAT(e.L_RIF,'-',e.RIF) 
        RIF, e.TELEFONO, e.DIRECCION, e.N_PASANTES, c.id C_ID,c.NOMBRE
        CARRERA, c.CODIGO C_CODIGO FROM empresa as e 
        left join carrera as c on e.carrera = c.id
        WHERE e.STATUS = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'rif' => $row["RIF"],
                'nombre' => $row["NOMBRE"],
                'direccion' => $row["DIRECCION"],
                'telefono_empresa' => $row["TELEFONO"],
                'carrera' => $row["CARRERA"],
                'c_id' => $row["C_ID"],
                'c_codigo' => $row["C_CODIGO"]
            );
        }
        return $json;
    }
    //creo la clase que me va a eliminar un usuario
    public function eliminar($id,$estatus){
        $consulta = "UPDATE empresa SET status = :estatus WHERE id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }
    //creo la clase que me va a consultar todos los datos que va a editar por el ID
    public function searchedit($id){
        $consulta = "SELECT * FROM empresa WHERE id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $json = array();
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'id' => $row["ID"],
                'l_rif' => $row["L_RIF"],
                'rif' => $row["RIF"],
                'nombre' => $row["NOMBRE"],
                'direccion' => $row["DIRECCION"],
                'telefono_empresa' => $row["TELEFONO"],
                'carrera' => $row["CARRERA"],
                'n_pasantes' => $row['N_PASANTES'],
                'estatus' => $row["STATUS"]
            );
        }
        return $json;
    }
    
    //creo la funcion que me va a editar una empresa
    public function editar($id, $l_rif, $rif, $nombre, $direccion, $telefono_empresa,$n_pasantes,$carrera,$estatus){
        $consulta = "UPDATE empresa SET L_RIF = :l_rif, rif = :rif, nombre = :nombre, direccion = :direccion, telefono = :telefono_empresa, n_pasantes = :n_pasantes, status = :estatus, carrera = :carrera  WHERE id = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':l_rif', $l_rif);
        $statement->bindValue(':rif', $rif);
        $statement->bindValue(':nombre', $nombre);
        $statement->bindValue(':direccion', $direccion);
        $statement->bindValue(':telefono_empresa', $telefono_empresa);
        $statement->bindValue(':n_pasantes', $n_pasantes);
        $statement->bindValue(':estatus', $estatus);
        $statement->bindValue(':carrera', $carrera);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }  
}


?>