<?php
//inicializo la sesion y la zona horaria

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
        // Validar que el año del lapso académico coincida con el año de la fecha de inicio
        if (preg_match('/^(\d{4})-/', $DESCRIPTION, $m)) {
            $anioLapso = $m[1];
            $anioInicio = date('Y', strtotime($START_DATE));
            if ($anioLapso != $anioInicio) {
                return "El año de la fecha de inicio debe coincidir con el año del lapso académico seleccionado.";
            }
        }

        // Validar cronología: solo si NO es el primer período
        $descAnterior = $this->descripcionAnterior($DESCRIPTION);
        if ($descAnterior) {
            // Si no existe ningún período en la tabla, permite registrar el primero
            $consultaTotal = "SELECT COUNT(*) as total FROM `t-internships_period`";
            $stmtTotal = $this->pdo->prepare($consultaTotal);
            $stmtTotal->execute();
            $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
            if ($total > 0) {
                $consulta = "SELECT 1 FROM `t-internships_period` WHERE DESCRIPTION = :descAnterior";
                $stmt = $this->pdo->prepare($consulta);
                $stmt->bindValue(':descAnterior', $descAnterior);
                $stmt->execute();
                if ($stmt->rowCount() === 0) {
                    return "Debe crear primero al menos un período anterior: $descAnterior";
                }
            }
        }

        // Validar que no haya fechas solapadas con ningún otro período (incluso si es el mismo lapso)
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
        // Validar cronología: debe existir al menos un registro con el DESCRIPTION anterior
        $descAnterior = $this->descripcionAnterior($DESCRIPTION);
        if ($descAnterior) {
            $consulta = "SELECT 1 FROM `t-internships_period` WHERE DESCRIPTION = :descAnterior";
            $stmt = $this->pdo->prepare($consulta);
            $stmt->bindValue(':descAnterior', $descAnterior);
            $stmt->execute();
            if ($stmt->rowCount() === 0) {
                return "Debe existir el período anterior: $descAnterior";
            }
        }

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
            // Validar que la fecha de cierre sea al menos 16 semanas después de la fecha de inicio
            $fechaInicio = new DateTime($START_DATE);
            $fechaFin = new DateTime($END_DATE);
            $diferencia = $fechaInicio->diff($fechaFin)->days;
            if ($diferencia < 112) { // 16 semanas * 7 días
                return "La fecha de cierre debe ser al menos 16 semanas después de la fecha de inicio.";
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

            // Solo validar EN CURSO si newStatus == 2
            if ($newStatus == 2) {
                $consulta = "SELECT PERIOD_ID FROM `t-internships_period` WHERE PERIOD_STATUS = 2 AND STATUS = 1 AND PERIOD_ID != :PERIOD_ID";
                $stmt = $this->pdo->prepare($consulta);
                $stmt->bindValue(':PERIOD_ID', $PERIOD_ID, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->pdo->rollBack();
                    return "Ya existe un período EN CURSO. Debe culminarlo antes de activar otro.";
                }

                // Validación de cronología (ya implementada)
                $periodo = $this->obtenerPorID($PERIOD_ID);
                if (!$periodo || count($periodo) === 0) {
                    $this->pdo->rollBack();
                    return "Período no encontrado";
                }
                $descripcion = $periodo[0]['DESCRIPTION'];
                $ordenActual = $this->descripcionAOrden($descripcion);

                // Buscar todos los períodos anteriores
                $consulta = "SELECT * FROM `t-internships_period` WHERE STATUS = 1";
                $stmt = $this->pdo->prepare($consulta);
                $stmt->execute();
                $periodos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($periodos as $p) {
                    if ($this->descripcionAOrden($p['DESCRIPTION']) < $ordenActual && $p['PERIOD_STATUS'] != 3) {
                        $this->pdo->rollBack();
                        return "No puede activar este período hasta que todos los anteriores estén CULMINADOS, ni saltar el orden cronológico!";
                    }
                }
            }

            // Actualizar el estado
            $consultaActualizar = "UPDATE `t-internships_period` SET PERIOD_STATUS = :newStatus WHERE PERIOD_ID = :PERIOD_ID";
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

    // Convierte DESCRIPTION (ej: 2025-I) a un valor comparable
    private function descripcionAOrden($descripcion) {
        if (preg_match('/^(\d{4})-(I{1,2})$/', $descripcion, $m)) {
            $anio = intval($m[1]);
            $turno = ($m[2] === 'I') ? 1 : 2;
            return $anio * 10 + $turno;
        }
        return 0;
    }

    // Devuelve el DESCRIPTION anterior (ej: 2025-II -> 2025-I, 2026-I -> 2025-II)
    private function descripcionAnterior($descripcion) {
        if (preg_match('/^(\d{4})-(I{1,2})$/', $descripcion, $m)) {
            $anio = intval($m[1]);
            $turno = $m[2];
            if ($turno === 'II') return "{$anio}-I";
            if ($turno === 'I') return ($anio - 1) . "-II";
        }
        return null;
    }

    // Cuenta la cantidad de estudiantes asignados a cada periodo
    public function getStudentCountByPeriod() {
        $consulta = "SELECT PERIOD_ID, COUNT(STUDENTS_ID) AS assigned_students FROM t-professional_practices GROUP BY PERIOD_ID";
        $statement = $this->pdo->prepare($consulta);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
