<?php
require_once("conexion.php");

class InstitutionManager
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Conexion())->conectar();
    }

    public function listarActivos()
    {
        try {
            $sql = "SELECT m.*, i.INSTITUTION_NAME 
                   FROM `t-institution_manager` m
                   LEFT JOIN `t-institution` i ON m.INSTITUTION_ID = i.INSTITUTION_ID
                   WHERE m.STATUS = 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en listarActivos: " . $e->getMessage());
            return [];
        }
    }

    public function listarInactivos()
    {
        $consulta = "SELECT m.*, i.INSTITUTION_NAME 
                    FROM `t-institution_manager` m
                    LEFT JOIN `t-institution` i ON m.INSTITUTION_ID = i.INSTITUTION_ID
                    WHERE m.STATUS = 0
                    ORDER BY m.SURNAME, m.NAME";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id)
    {
        $consulta = "SELECT * FROM `t-institution_manager` WHERE MANAGER_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($datos)
    {
        try {
            $this->pdo->beginTransaction();

            $consulta = "INSERT INTO `t-institution_manager` (
                INSTITUTION_ID, MANAGER_CI, NAME, SECOND_NAME, SURNAME, SECOND_SURNAME,
                CONTACT_PHONE, EMAIL, CREATION_DATE, STATUS
            ) VALUES (
                :institucion_id, :cedula, :nombre, :segundo_nombre, :apellido, :segundo_apellido,
                :telefono, :correo, NOW(), 1
            )";

            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':institucion_id', $datos['institucion_id']);
            $stmt->bindValue(':cedula', $datos['cedula']);
            $stmt->bindValue(':nombre', $datos['nombre']);
            $stmt->bindValue(':segundo_nombre', $datos['segundo_nombre'] ?? null);
            $stmt->bindValue(':apellido', $datos['apellido']);
            $stmt->bindValue(':segundo_apellido', $datos['segundo_apellido'] ?? null);
            $stmt->bindValue(':telefono', $datos['telefono']);
            $stmt->bindValue(':correo', $datos['correo']);

            $stmt->execute();
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return ['success' => true, 'id' => $id];
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            if ($e->getCode() == "23000") {
                return ['success' => false, 'error' => 'La cédula ya está registrada'];
            }
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function actualizar($datos)
    {
        try {
            $consulta = "UPDATE `t-institution_manager` 
                        SET INSTITUTION_ID = :institucion_id,
                            MANAGER_CI = :cedula,
                            NAME = :nombre,
                            SECOND_NAME = :segundo_nombre,
                            SURNAME = :apellido,
                            SECOND_SURNAME = :segundo_apellido,
                            CONTACT_PHONE = :telefono,
                            EMAIL = :correo
                        WHERE MANAGER_ID = :id";

            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':id', $datos['id']);
            $stmt->bindValue(':institucion_id', $datos['institucion_id']);
            $stmt->bindValue(':cedula', $datos['cedula']);
            $stmt->bindValue(':nombre', $datos['nombre']);
            $stmt->bindValue(':segundo_nombre', $datos['segundo_nombre'] ?? null);
            $stmt->bindValue(':apellido', $datos['apellido']);
            $stmt->bindValue(':segundo_apellido', $datos['segundo_apellido'] ?? null);
            $stmt->bindValue(':telefono', $datos['telefono']);
            $stmt->bindValue(':correo', $datos['correo']);

            $stmt->execute();
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function eliminar($id)
    {
        $consulta = "UPDATE `t-institution_manager` SET STATUS = 0 WHERE MANAGER_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':id', $id);
        return $stmt->execute() ? ['success' => true] : ['success' => false];
    }

    public function restaurar($id)
    {
        $consulta = "UPDATE `t-institution_manager` SET STATUS = 1 WHERE MANAGER_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':id', $id);
        return $stmt->execute() ? ['success' => true] : ['success' => false];
    }

    public function cedulaExiste($cedula, $idExcluir = null)
    {
        $consulta = "SELECT COUNT(*) FROM `t-institution_manager` 
                    WHERE MANAGER_CI = :cedula" .
            ($idExcluir ? " AND MANAGER_ID != :id" : "");

        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':cedula', $cedula);
        if ($idExcluir) {
            $stmt->bindValue(':id', $idExcluir);
        }
        $stmt->execute();

        return ['existe' => $stmt->fetchColumn() > 0];
    }
}
