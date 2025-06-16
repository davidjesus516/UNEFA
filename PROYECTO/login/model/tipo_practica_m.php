<?php
require_once("conexion.php");

class TipoPractica
{
    private $conexion;
    private $pdo;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    /**
     * Insertar nuevo tipo de práctica
     */
    public function insertar($datos)
    {
        try {
            $consulta = "INSERT INTO `t-internship_type` (NAME, PRIORITY, CREATION_DATE, STATUS) 
                         VALUES (:nombre, :prioridad, NOW(), 1)";
            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':nombre', mb_strtoupper(trim($datos['nombre'])));
            $stmt->bindValue(':prioridad', $datos['prioridad']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al insertar tipo de práctica: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar tipos de práctica activos
     */
    public function listarActivos()
    {
        $consulta = "SELECT * FROM `t-internship_type` WHERE STATUS = 1";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Listar tipos de práctica inactivos
     */
    public function listarInactivos()
    {
        $consulta = "SELECT * FROM `t-internship_type` WHERE STATUS = 0";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar tipo de práctica por ID
     */
    public function buscarPorId($id)
    {
        $consulta = "SELECT * FROM `t-internship_type` WHERE INTERNSHIP_TYPE_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualizar tipo de práctica
     */
    public function actualizar($id, $datos)
    {
        try {
            $consulta = "UPDATE `t-internship_type` 
                         SET NAME = :nombre, PRIORITY = :prioridad 
                         WHERE INTERNSHIP_TYPE_ID = :id";
            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':nombre', mb_strtoupper(trim($datos['nombre'])));
            $stmt->bindValue(':prioridad', $datos['prioridad']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar tipo de práctica: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar (desactivar) tipo de práctica
     */
    public function eliminar($id)
    {
        try {
            $consulta = "UPDATE `t-internship_type` SET STATUS = 0 WHERE INTERNSHIP_TYPE_ID = :id";
            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':id', $id);
            $resultado = $stmt->execute();
            if (!$resultado) {
                error_log('Error al ejecutar la consulta SQL: ' . json_encode($stmt->errorInfo()));
            }
            return $resultado;
        } catch (PDOException $e) {
            error_log('Error en el modelo eliminar: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Restaurar (activar) tipo de práctica
     */
    public function restaurar($id)
    {
        $consulta = "UPDATE `t-internship_type` SET STATUS = 1 WHERE INTERNSHIP_TYPE_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>