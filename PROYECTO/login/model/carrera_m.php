<?php
require_once("conexion.php");

class Carrera
{
    private $conexion;
    private $pdo;

    public function __construct() {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    /**
     * Buscar carrera por código exacto
     */
    public function buscarCodigo($codigo) {
        $consulta = "SELECT * FROM `t-career` WHERE CAREER_CODE = :codigo";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar carrera por nombre (LIKE)
     */
    public function buscarNombre($nombre) {
        $consulta = "SELECT * FROM `t-career` WHERE CAREER_NAME LIKE :nombre";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':nombre', '%' . $nombre . '%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insertar nueva carrera y sus tipos de pasantía
     */
    public function insertar($datos) {
        try {
            $this->pdo->beginTransaction();

            $consulta = "INSERT INTO `t-career`
                (CAREER_NAME, CAREER_CODE, MINIMUM_GRADE, CREATION_DATE, MODIF_USER_ID, MODIF_USER_DATE, ELIM_USER_ID, ELIM_USER_DATE, REST_USER_ID, REST_USER_DATE, STATUS)
                VALUES (:nombre, :codigo, :minimo, NOW(), :usuario, NOW(), :usuario, NOW(), :usuario, NOW(), 1)";
            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':nombre', $datos['nombre']);
            $stmt->bindValue(':codigo', $datos['codigo']);
            $stmt->bindValue(':minimo', $datos['minimo']);
            $stmt->bindValue(':usuario', $datos['usuario']);
            $stmt->execute();

            $career_id = $this->pdo->lastInsertId();

            $consulta2 = "INSERT INTO `t-career_internship_type` (CAREER_ID, INTERNSHIP_TYPE_ID) VALUES (:career_id, :internship_id)";
            foreach ($datos['tipos_pasantia'] as $internship_id) {
                $stmt2 = $this->pdo->prepare($consulta2);
                $stmt2->bindValue(':career_id', $career_id);
                $stmt2->bindValue(':internship_id', $internship_id);
                if (!$stmt2->execute()) {
                    $this->pdo->rollBack();
                    return false;
                }
            }

            $this->pdo->commit();
            return $career_id;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            if ($e->getCode() == "23000") {
                return false; // Duplicado
            }
            error_log("Error al insertar carrera: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar carreras activas
     */
    public function listarActivas() {
        $consulta = "SELECT * FROM `t-career` WHERE STATUS = 1";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Listar carreras inactivas
     */
    public function listarInactivas() {
        $consulta = "SELECT * FROM `t-career` WHERE STATUS = 0";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Eliminar (desactivar) carrera
     */
    public function eliminar($id, $usuario) {
        $consulta = "UPDATE `t-career` SET ELIM_USER_ID = :usuario, ELIM_USER_DATE = NOW(), STATUS = 0 WHERE CAREER_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    /**
     * Restaurar (activar) carrera
     */
    public function restaurar($id, $usuario) {
        $consulta = "UPDATE `t-career` SET REST_USER_ID = :usuario, REST_USER_DATE = NOW(), STATUS = 1 WHERE CAREER_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':usuario', $usuario);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    /**
     * Buscar carrera por ID (para edición)
     */
    public function buscarPorId($id) {
        $consulta = "SELECT * FROM `t-career` WHERE CAREER_ID = :id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $carrera = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($carrera) {
            $carrera['CAREER_INTERNSHIP_TYPES'] = $this->careerInternshipType($id);
        }
        return $carrera;
    }

    /**
     * Obtener tipos de pasantía asociados a una carrera
     */
    public function careerInternshipType($career_id) {
        $consulta = "SELECT INTERNSHIP_TYPE_ID FROM `t-career_internship_type` WHERE CAREER_ID = :career_id";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':career_id', $career_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Actualizar datos de carrera y sus tipos de pasantía
     */
    public function actualizar($id, $datos) {
        try {
            $this->pdo->beginTransaction();

            $consulta = "UPDATE `t-career`
                SET CAREER_NAME = :nombre, CAREER_CODE = :codigo, MINIMUM_GRADE = :minimo,
                    MODIF_USER_ID = :usuario, MODIF_USER_DATE = NOW()
                WHERE CAREER_ID = :id";
            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':nombre', $datos['nombre']);
            $stmt->bindValue(':codigo', $datos['codigo']);
            $stmt->bindValue(':minimo', $datos['minimo']);
            $stmt->bindValue(':usuario', $datos['usuario']);
            $stmt->execute();

            // Eliminar tipos de pasantía anteriores
            $stmt2 = $this->pdo->prepare("DELETE FROM `t-career_internship_type` WHERE CAREER_ID = :id");
            $stmt2->bindValue(':id', $id);
            $stmt2->execute();

            // Insertar nuevos tipos de pasantía
            $consulta2 = "INSERT INTO `t-career_internship_type` (CAREER_ID, INTERNSHIP_TYPE_ID) VALUES (:career_id, :internship_id)";
            foreach ($datos['tipos_pasantia'] as $internship_id) {
                $stmt3 = $this->pdo->prepare($consulta2);
                $stmt3->bindValue(':career_id', $id);
                $stmt3->bindValue(':internship_id', $internship_id);
                if (!$stmt3->execute()) {
                    $this->pdo->rollBack();
                    return false;
                }
            }

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error al actualizar carrera: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Listar todos los tipos de pasantía activos
     */
    public function internshipsTypeList() {
        $consulta = "SELECT * FROM `T-INTERNSHIP_TYPE` WHERE STATUS = 1";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verificar si un código de carrera ya existe (opcional para validación)
     */
    public function codigoExiste($codigo, $idExcluir = null) {
        $consulta = "SELECT COUNT(*) FROM `t-career` WHERE CAREER_CODE = :codigo" .
            ($idExcluir ? " AND CAREER_ID != :id" : "");
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':codigo', $codigo);
        if ($idExcluir) {
            $stmt->bindValue(':id', $idExcluir);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    /**
     * Verificar si una carrera existe por nombre (opcional para validación)
     */
    public function nombreExiste($nombre, $idExcluir = null) {
        $consulta = "SELECT COUNT(*) FROM `t-career` WHERE CAREER_NAME = :nombre" .
            ($idExcluir ? " AND CAREER_ID != :id" : "");
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(':nombre', $nombre);
        if ($idExcluir) {
            $stmt->bindValue(':id', $idExcluir);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?>