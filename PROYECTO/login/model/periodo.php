<?php
//inicializo la sesion y la zona horaria

session_start();
require_once("conexion.php");
date_default_timezone_set("America/Caracas");

class Periodo
{
    private $conexion;
    private $pdo;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
    }

    public function listar() //muestra todo
    {
        $consulta = "SELECT * FROM `t-internships_period`";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarCodigo($T_INTERNSHIPS_CODE)
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE T_INTERNSHIPS_CODE = :T_INTERNSHIPS_CODE";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':T_INTERNSHIPS_CODE', $T_INTERNSHIPS_CODE);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarNombre($DESCRIPTION, $excludeId = null)
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE DESCRIPTION = :DESCRIPTION";

        if ($excludeId !== null) {
            $consulta .= " AND PERIOD_ID != :excludeId";
        }

        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':DESCRIPTION', $DESCRIPTION);

        if ($excludeId !== null) {
            $statement->bindValue(':excludeId', $excludeId, PDO::PARAM_INT);
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Agregar este método en la clase Periodo
    public function verificarSuperposicion($START_DATE, $END_DATE, $excludeId = null)
    {
        $consulta = "SELECT * FROM `t-internships_period` 
                WHERE (
                    (:START_DATE BETWEEN START_DATE AND END_DATE) 
                    OR (:END_DATE BETWEEN START_DATE AND END_DATE) 
                    OR (START_DATE BETWEEN :START_DATE AND :END_DATE)
                )";

        if ($excludeId !== null) {
            $consulta .= " AND PERIOD_ID != :excludeId";
        }

        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':START_DATE', $START_DATE);
        $statement->bindValue(':END_DATE', $END_DATE);

        if ($excludeId !== null) {
            $statement->bindValue(':excludeId', $excludeId, PDO::PARAM_INT);
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarPeriodo($DESCRIPTION, $START_DATE, $END_DATE, $PERIOD_STATUS = 1, $STATUS = 1)
    {
        // Verificar superposición
        $superpuestos = $this->verificarSuperposicion($START_DATE, $END_DATE);
        if (count($superpuestos) > 0) {
            return "Existe un período superpuesto con las fechas proporcionadas";
        }
        try {
            $this->pdo->beginTransaction();
            $consulta = "INSERT INTO `t-internships_period` 
                    (DESCRIPTION, START_DATE, END_DATE, CREATION_DATE, PERIOD_STATUS, STATUS) 
                    VALUES (:DESCRIPTION, :START_DATE, :END_DATE, NOW(), :PERIOD_STATUS, :STATUS)";

            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(":DESCRIPTION", $DESCRIPTION);
            $statement->bindValue(":START_DATE", $START_DATE);
            $statement->bindValue(":END_DATE", $END_DATE);
            $statement->bindValue(":PERIOD_STATUS", $PERIOD_STATUS);
            $statement->bindValue(":STATUS", $STATUS);

            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return $e->getMessage();
        }
    }

    public function listarActivos() //LOS TOMO DEL ESTATUS PERIODO
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarInactivos()
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE `STATUS` = 0";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarPeriodo($PERIOD_ID) // AQUI INACTIVA
    {
        $consulta = "UPDATE `t-internships_period` SET `STATUS` = 0 WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
        return $statement->execute();
    }

    public function restaurarPeriodo($PERIOD_ID) // AQUI INACTIVA
    {
        $consulta = "UPDATE `t-internships_period` SET `STATUS` = 1 WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
        return $statement->execute();
    }

    public function obtenerPorID($PERIOD_ID)
    {
        $consulta = "SELECT * FROM `t-internships_period` WHERE PERIOD_ID = :PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarPeriodo($PERIOD_ID, $DESCRIPTION, $START_DATE, $END_DATE, $PERIOD_STATUS, $STATUS)
    {
        if (!is_numeric($PERIOD_STATUS)) {
            $PERIOD_STATUS = ($PERIOD_STATUS === 'PENDIENTE') ? 1 : (($PERIOD_STATUS === 'EN CURSO') ? 2 : 3);
        }
        // Verificar superposición excluyendo el periodo actual
        $superpuestos = $this->verificarSuperposicion($START_DATE, $END_DATE, $PERIOD_ID);

        if (count($superpuestos) > 0) {
            return "Existe un período superpuesto con las fechas proporcionadas";
        }
        // Obtener el estado actual del período
        $periodoActual = $this->obtenerPorID($PERIOD_ID);
        if (count($periodoActual) === 0) return "Período no encontrado";

        $estadoActual = $periodoActual[0]['PERIOD_STATUS'];

        // Validar restricciones de edición
        if ($estadoActual === 'CULMINADO') {
            return "No se puede editar un período culminado";
        }

        if ($estadoActual === 'EN CURSO') {
            // Solo permitir modificar la fecha de fin
            if ($periodoActual[0]['START_DATE'] !== $START_DATE) {
                return "Solo se permite modificar la fecha de fin en períodos en curso";
            }
        }
        try {
            $this->pdo->beginTransaction();

            $consulta = "UPDATE `t-internships_period` 
                    SET DESCRIPTION = :DESCRIPTION,
                        START_DATE = :START_DATE,
                        END_DATE = :END_DATE,
                        PERIOD_STATUS = :PERIOD_STATUS,
                        STATUS = :STATUS
                    WHERE PERIOD_ID = :PERIOD_ID";

            $statement = $this->pdo->prepare($consulta);
            $statement->bindValue(":PERIOD_ID", $PERIOD_ID);
            $statement->bindValue(":DESCRIPTION", $DESCRIPTION);
            $statement->bindValue(":START_DATE", $START_DATE);
            $statement->bindValue(":END_DATE", $END_DATE);
            $statement->bindValue(":PERIOD_STATUS", $PERIOD_STATUS);
            $statement->bindValue(":STATUS", $STATUS);

            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return $e->getMessage();
        }
    }
    // Cambiar Period_Status
    public function cambiarEstadoPeriodo($PERIOD_ID, $newStatus)
    {
        try {
            $this->pdo->beginTransaction();

            // Si estamos activando un período (poniéndolo EN CURSO)
            if ($newStatus == 2) {
                // Primero desactivar cualquier otro período activo
                $consultaDesactivar = "UPDATE `t-internships_period` 
                                 SET PERIOD_STATUS = 1 
                                 WHERE PERIOD_STATUS = 2";
                $stmtDesactivar = $this->pdo->prepare($consultaDesactivar);
                $stmtDesactivar->execute();
            }

            // Ahora actualizar el estado del período actual
            $consultaActualizar = "UPDATE `t-internships_period` 
                              SET PERIOD_STATUS = :newStatus 
                              WHERE PERIOD_ID = :PERIOD_ID";
            $stmtActualizar = $this->pdo->prepare($consultaActualizar);
            $stmtActualizar->bindValue(":newStatus", $newStatus, PDO::PARAM_INT);
            $stmtActualizar->bindValue(":PERIOD_ID", $PERIOD_ID, PDO::PARAM_INT);
            $stmtActualizar->execute();

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return $e->getMessage();
        }
    }
}
