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

            // Convertir todos los valores a mayúsculas antes de guardar
            foreach ($datos as $key => $value) {
                if (is_string($value)) {
                    $datos[$key] = mb_strtoupper($value, 'UTF-8');
                }
            }

            // Validar cédula
            $sqlCedula = "SELECT COUNT(*) FROM `t-institution_manager` WHERE MANAGER_CI = :cedula";
            $stmtCedula = $this->pdo->prepare($sqlCedula);
            $stmtCedula->bindValue(':cedula', $datos['MANAGER_CI']);
            $stmtCedula->execute();
            if ($stmtCedula->fetchColumn() > 0) {
                $this->pdo->rollBack();
                return ['success' => false, 'error' => 'La cédula ya está registrada'];
            }

            // Validar correo
            $sqlCorreo = "SELECT COUNT(*) FROM `t-institution_manager` WHERE EMAIL = :correo";
            $stmtCorreo = $this->pdo->prepare($sqlCorreo);
            $stmtCorreo->bindValue(':correo', $datos['EMAIL']);
            $stmtCorreo->execute();
            if ($stmtCorreo->fetchColumn() > 0) {
                $this->pdo->rollBack();
                return ['success' => false, 'error' => 'El correo ya está registrado'];
            }

            $consulta = "INSERT INTO `t-institution_manager` (
                INSTITUTION_ID, MANAGER_CI, NAME, SECOND_NAME, SURNAME, SECOND_SURNAME,
                CONTACT_PHONE, EMAIL, CREATION_DATE, STATUS
            ) VALUES (
                :institucion_id, :cedula, :nombre, :segundo_nombre, :apellido, :segundo_apellido,
                :telefono, :correo, NOW(), 1
            )";

            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':institucion_id', $datos['INSTITUTION_ID']);
            $stmt->bindValue(':cedula', $datos['MANAGER_CI']);
            $stmt->bindValue(':nombre', $datos['NAME']);
            $stmt->bindValue(':segundo_nombre', $datos['SECOND_NAME'] ?? null);
            $stmt->bindValue(':apellido', $datos['SURNAME']);
            $stmt->bindValue(':segundo_apellido', $datos['SECOND_SURNAME'] ?? null);
            $stmt->bindValue(':telefono', $datos['CONTACT_PHONE']);
            $stmt->bindValue(':correo', $datos['EMAIL']);

            $stmt->execute();
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return ['success' => true, 'id' => $id];
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function actualizar($datos)
    {
        try {
            // Convertir todos los valores a mayúsculas antes de guardar
            foreach ($datos as $key => $value) {
                if (is_string($value)) {
                    $datos[$key] = mb_strtoupper($value, 'UTF-8');
                }
            }

            $consulta = "UPDATE `t-institution_manager` SET 
                MANAGER_CI = :MANAGER_CI,
                NAME = :NAME,
                SECOND_NAME = :SECOND_NAME,
                SURNAME = :SURNAME,
                SECOND_SURNAME = :SECOND_SURNAME,
                CONTACT_PHONE = :CONTACT_PHONE,
                EMAIL = :EMAIL
                WHERE MANAGER_ID = :MANAGER_ID";
            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':MANAGER_ID', $datos['MANAGER_ID']);
            $stmt->bindValue(':MANAGER_CI', $datos['MANAGER_CI']);
            $stmt->bindValue(':NAME', $datos['NAME']);
            $stmt->bindValue(':SECOND_NAME', $datos['SECOND_NAME']);
            $stmt->bindValue(':SURNAME', $datos['SURNAME']);
            $stmt->bindValue(':SECOND_SURNAME', $datos['SECOND_SURNAME']);
            $stmt->bindValue(':CONTACT_PHONE', $datos['CONTACT_PHONE']);
            $stmt->bindValue(':EMAIL', $datos['EMAIL']);
            return $stmt->execute();
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
