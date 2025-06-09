<?php
require_once("conexion.php");

class Institucion
{
    private $conexion;
    private $pdo;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    /**
     * Buscar institución por nombre o RIF
     * @param string $busqueda Texto a buscar
     * @return array Resultados en formato JSON
     */
    public function buscar($busqueda)
    {
        $consulta = "SELECT * FROM `t-institution` 
                    WHERE (INSTITUTION_NAME LIKE :busqueda OR RIF LIKE :busqueda)
                    AND STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':busqueda', '%' . $busqueda . '%');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insertar nueva institución
     * @param array $datos Datos de la institución
     * @return int|false ID de la nueva institución o false en error
     */
    public function insertar($datos)
    {
        try {
            $this->pdo->beginTransaction();

            $consulta = "INSERT INTO `t-institution` (
                INSTITUTION_NAME, INSTITUTION_ADDRESS, INSTITUTION_CONTACT,
                PRACTICE_TYPE, REGION, NUCLEUS, EXTENSION,
                CREATION_DATE, INSTITUTION_TYPE, STATUS, RIF
            ) VALUES (
                :nombre, :direccion, :contacto,
                :tipo_practica, :region, :nucleo, :extension,
                NOW(), :tipo_institucion, 1, :rif
            )";

            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':nombre', $datos['nombre']);
            $statement->bindValue(':direccion', $datos['direccion']);
            $statement->bindValue(':contacto', $datos['contacto']);
            $statement->bindValue(':tipo_practica', $datos['tipo_practica']);
            $statement->bindValue(':region', $datos['region']);
            $statement->bindValue(':nucleo', $datos['nucleo']);
            $statement->bindValue(':extension', $datos['extension']);
            $statement->bindValue(':tipo_institucion', $datos['tipo_institucion']);
            $statement->bindValue(':rif', $datos['rif']);

            $statement->execute();
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return $id;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            if ($e->getCode() == "23000") {
                return false; // Registro duplicado (probablemente RIF repetido)
            }

            echo $e->getMessage();
            error_log("Error al insertar institución: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar instituciones activas
     * @return array Lista de instituciones
     */
    public function listarActivas()
    {
        $consulta = "SELECT * FROM `t-institution` WHERE STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Listar instituciones inactivas
     * @return array Lista de instituciones
     */
    public function listarInactivas()
    {
        $consulta = "SELECT * FROM `t-institution` WHERE STATUS = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Eliminar (desactivar) institución
     * @param int $id ID de la institución
     * @return bool Resultado de la operación
     */
    public function eliminar($id)
    {
        $consulta = "UPDATE `t-institution` 
                    SET STATUS = 0 
                    WHERE INSTITUTION_ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    /**
     * Restaurar (activar) institución
     * @param int $id ID de la institución
     * @return bool Resultado de la operación
     */
    public function restaurar($id)
    {
        $consulta = "UPDATE `t-institution` 
                    SET STATUS = 1 
                    WHERE INSTITUTION_ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    /**
     * Buscar institución por ID para edición
     * @param int $id ID de la institución
     * @return array|null Datos de la institución o null si no existe
     */
    public function buscarPorId($id)
    {
        $consulta = "SELECT * FROM `t-institution` WHERE INSTITUTION_ID = :id";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualizar datos de institución
     * @param int $id ID de la institución
     * @param array $datos Nuevos datos
     * @return bool Resultado de la operación
     */
    public function actualizar($id, $datos)
    {
        try {
            $consulta = "UPDATE `t-institution` 
                        SET INSTITUTION_NAME = :nombre,
                            INSTITUTION_ADDRESS = :direccion,
                            INSTITUTION_CONTACT = :contacto,
                            PRACTICE_TYPE = :tipo_practica,
                            REGION = :region,
                            NUCLEUS = :nucleo,
                            EXTENSION = :extension,
                            INSTITUTION_TYPE = :tipo_institucion,
                            RIF = :rif
                        WHERE INSTITUTION_ID = :id";

            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':nombre', $datos['nombre']);
            $statement->bindValue(':direccion', $datos['direccion']);
            $statement->bindValue(':contacto', $datos['contacto']);
            $statement->bindValue(':tipo_practica', $datos['tipo_practica']);
            $statement->bindValue(':region', $datos['region']);
            $statement->bindValue(':nucleo', $datos['nucleo']);
            $statement->bindValue(':extension', $datos['extension']);
            $statement->bindValue(':tipo_institucion', $datos['tipo_institucion']);
            $statement->bindValue(':rif', $datos['rif']);

            return $statement->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar institución: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un RIF ya existe
     * @param string $rif RIF a verificar
     * @param int|null $idExcluir ID a excluir (para ediciones)
     * @return bool True si ya existe
     */
    public function rifExiste($rif, $idExcluir = null)
    {
        $consulta = "SELECT COUNT(*) FROM `t-institution` 
                    WHERE RIF = :rif" .
            ($idExcluir ? " AND INSTITUTION_ID != :id" : "");

        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':rif', $rif);
        if ($idExcluir) {
            $statement->bindValue(':id', $idExcluir);
        }
        $statement->execute();

        return $statement->fetchColumn() > 0;
    }

    /**
     * Listar instituciones para select (solo ID y nombre)
     * @return array Lista de instituciones con ID y nombre
     */
    public function listarParaSelect()
    {
        $consulta = "SELECT INSTITUTION_ID as id, INSTITUTION_NAME as nombre 
                FROM `t-institution` 
                WHERE STATUS = 1
                ORDER BY INSTITUTION_NAME ASC";

        $statement = $this->pdo->prepare($consulta);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
