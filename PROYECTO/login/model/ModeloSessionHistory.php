<?php
require_once __DIR__ . '/conexion.php';

class ModeloSessionHistory {
    public static function obtenerHistorial() {
        $conexionDB = new Conexion();
        $conexion = $conexionDB->conectar();

        $sql = "SELECT 
                    sh.SESSION_HISTORY_ID,
                    u.USER_ID,
                    u.NAME AS USER_NAME,
                    sh.LOGIN_TIME,
                    sh.LOGOUT_TIME
                FROM `t-session_history` sh
                INNER JOIN `t-user` u ON sh.USER_ID = u.USER_ID
                ORDER BY sh.LOGIN_TIME DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>