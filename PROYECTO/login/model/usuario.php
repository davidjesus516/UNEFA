<?php
session_start();
//me voy a traer la conexion
require_once("conexion.php");
require_once("config.php");
// me traigo la configuracion
date_default_timezone_get();

//instancio la clase usuario
class Usuario
{
    //creo los atributos    
    private $config;
    private $conexion;
    private $pdo;

    //hago el metodo constructor para usar la conexion en todo lo que va de la clase
    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->pdo = $this->conexion->conectar();
        $this->config = new config();
        $this->config = $this->config->getConfig();
    }

    private function expiration_date()
    {
        $date = date('Y-m-d H:i:s', strtotime('+' . $this->config['EXPIRATION_DAYS'] . ' days'));
        return $date;
    }
    public function userSecurityQuestionSearchByID($user_id)
    {
        $sql5 = "SELECT c.USER_ID, b.PRESET_QUESTION_ID ,b.DESCRIPTION, b.ANSWER FROM `t-user` c LEFT join `t-security_questions` a on c.USER_ID = a.USER_ID INNER join `t-preset_questions` b ON a.PRESET_QUESTION_ID = b.PRESET_QUESTION_ID WHERE c.USER_ID = :user_id AND c.STATUS_SESSION = 1 AND c.STATUS = 1 AND b.STATUS = 1";
        $statement5 = $this->pdo->prepare($sql5);
        $statement5->bindValue(':user_id', $user_id);
        $statement5->execute();
        while ($row2 = $statement5->fetch(PDO::FETCH_ASSOC)) {
            $json[$row2["PRESET_QUESTION_ID"]] = $row2["ANSWER"];
        }
        return $json;
    }
    public function userSecurityQuestionSearch($username)
    {
        $sql5 = "SELECT c.USER_ID, b.PRESET_QUESTION_ID ,b.DESCRIPTION, b.ANSWER FROM `t-user` c LEFT join `t-security_questions` a on c.USER_ID = a.USER_ID INNER join `t-preset_questions` b ON a.PRESET_QUESTION_ID = b.PRESET_QUESTION_ID WHERE c.USER = :username AND c.STATUS_SESSION = 1 AND c.STATUS = 1 AND b.STATUS = 1";
        $statement5 = $this->pdo->prepare($sql5);
        $statement5->bindValue(':username', $username);
        $statement5->execute();
        $json = array();
        while ($row2 = $statement5->fetch(PDO::FETCH_ASSOC)) {
            $json[] = array(
                'USER_ID' => $row2["USER_ID"],
                'PRESET_QUESTION_ID' => $row2["PRESET_QUESTION_ID"],
                'DESCRIPTION' => $row2["DESCRIPTION"],
                'ANSWER' => $row2["ANSWER"]
            );
        }
        return $json;
    }
    public function UserCreate($USER, $USER_CI, $NAME, $SECOND_NAME, $SURNAME, $SECOND_SURNAME, $EMAIL, $PHONE_NUMBER, $KEY)
    {
        try {
            $sql = "INSERT INTO `t-user`(`USER`, `USER_CI`, `NAME`, `SECOND_NAME`, `SURNAME`, `SECOND_SURNAME`, `EMAIL`, `PHONE_NUMBER`, `CREATION_DATE`, `LOGIN`, `TERMS_CONDITIONS`, `STATUS_SESSION`, `STATUS`) VALUES (:USER, :USER_CI, :NAME, :SECOND_NAME, :SURNAME, :SECOND_SURNAME, :EMAIL, :PHONE_NUMBER, :CREATION_DATE, :LOGIN, :TERMS_CONDITIONS, :STATUS_SESSION, :STATUS)";
            $statement = $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':USER', mb_strtoupper($USER));
            $statement->bindValue(':USER_CI', mb_strtoupper($USER_CI));
            $statement->bindValue(':NAME', mb_strtoupper($NAME));
            $statement->bindValue(':SECOND_NAME', mb_strtoupper($SECOND_NAME));
            $statement->bindValue(':SURNAME', mb_strtoupper($SURNAME));
            $statement->bindValue(':SECOND_SURNAME', mb_strtoupper($SECOND_SURNAME));
            $statement->bindValue(':EMAIL', mb_strtolower($EMAIL));
            $statement->bindValue(':PHONE_NUMBER', mb_strtoupper($PHONE_NUMBER));
            $statement->bindValue(':CREATION_DATE', date("Y-m-d H:i:s"));
            $statement->bindValue(':LOGIN', 0);
            $statement->bindValue(':TERMS_CONDITIONS', 0);
            $statement->bindValue(':STATUS_SESSION', 2);
            $statement->bindValue(':STATUS', 1);
            $statement->execute();

            $userId = $this->pdo->lastInsertId(); // Obtener el ID del usuario insertado en t-user

            if (!$userId || $userId == 0) { // Verificar si se obtuvo un ID válido
                $this->pdo->rollBack();
                error_log("UserCreate: No se pudo obtener lastInsertId después de insertar en t-user.");
                return false;
            }

            $sql2 = "INSERT INTO `t-user_key`( `USER_ID`, `KEY`, `START_DATE`, `END_DATE`, `STATUS`) VALUES (:USER_ID, :KEY, :START_DATE, :END_DATE, :STATUS)";
            $statement2 = $this->pdo->prepare($sql2);
            $end_date = $this->expiration_date();
            $statement2->bindValue(':USER_ID', $userId); // Usar el userId obtenido
            $statement2->bindValue(':KEY', $KEY);
            $statement2->bindValue(':START_DATE', date("Y-m-d H:i:s"));
            $statement2->bindValue(':END_DATE', $end_date);
            $statement2->bindValue(':STATUS', 1);
            $statement2->execute();
            $this->pdo->commit();
            return $userId; // Devolver el ID del usuario creado
        } catch (Exception $e) {
            $this->pdo->rollBack(); // Asegurar rollback en caso de excepción
            if ($e->getCode() == 23000) {
                error_log("UserCreate: Error de duplicado (23000) - " . $e->getMessage());
                return false;
            } else {
                error_log("UserCreate: Excepción - " . $e->getMessage());
                return false; // Devolver false en otros errores para un manejo consistente
            }
        }
    }
    public function SearchUsername($username)
    {

        $consulta = "SELECT * FROM `t-user` WHERE `USER` = :username";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function SearchLastNUserKey($UserId)
    {

        $consulta = "SELECT * FROM `t-user_key` WHERE `USER_ID` = :UserId ORDER BY USER_KEY_ID DESC LIMIT 3";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':UserId', $UserId);
        $statement->execute();
        $json = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $json[] = array(
                'KEY' => $row["KEY"]
            );
        }
        return $json;
    }
    public function SearchUserKey($UserId)
    {

        $consulta = "SELECT * FROM `t-user_key` WHERE `USER_ID` = :UserId AND STATUS = 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':UserId', $UserId);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function Login($username)
    {
        $consulta = "SELECT * FROM `t-user` u left join `t-user_key` k on u.USER_ID = k.USER_ID WHERE `USER` = :username AND u.STATUS = 1 AND k.STATUS = 1 ORDER BY k.USER_KEY_ID DESC LIMIT 1";
        $statement = $this->pdo->prepare($consulta);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function LoginSucces($UserId)
    {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-user` SET `LOGIN`= 1 WHERE USER_ID = :UserId";
            $sql2 = "INSERT INTO `t-session`(`USER_ID`, `LOGIN_TIME`, `STATUS`) VALUES (:USER_ID, :LOGIN_TIME, :STATUS)";
            $sql3 = "UPDATE `t-session_attempts` SET `STATUS`= 0 WHERE USER_ID = :UserId AND STATUS = 1";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':UserId', $UserId);
            $statement->execute();
            $statement2 = $this->pdo->prepare($sql2);
            $statement2->bindValue(':USER_ID', $UserId);
            $statement2->bindValue(':LOGIN_TIME', date("Y-m-d H:i:s"));
            $statement2->bindValue(':STATUS', 1);
            $statement2->execute();
            $statement3 = $this->pdo->prepare($sql3);
            $statement3->bindValue(':UserId', $UserId);
            $statement3->execute();
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    public function LoginFail($UserId)
    {
        try {
            $sql = "INSERT INTO `t-session_attempts`(`USER_ID`, `ATTEMPT_TIME`, `STATUS`, `ACTION`) 
                VALUES (:USER_ID, :ATTEMPT_TIME, :STATUS, :ACTION)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':USER_ID', $UserId);
            $statement->bindValue(':ATTEMPT_TIME', date("Y-m-d H:i:s"));
            $statement->bindValue(':STATUS', 1);
            $statement->bindValue(':ACTION', 1); // Valor para el campo ACTION
            $statement->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error en LoginFail: " . $e->getMessage());
            throw $e;
        }
    }
    public function CountLoginFail($UserId)
    {
        $sql = "SELECT COUNT(*) as COUNT FROM `t-session_attempts` WHERE USER_ID = :UserId AND STATUS = 1";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':UserId', $UserId);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    private function getSession($UserId)
    {
        $sql = "SELECT * FROM `t-session` WHERE USER_ID = :UserId AND STATUS = 1";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':UserId', $UserId);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function Logout($UserId)
    {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-user` SET `LOGIN`= 0 WHERE USER_ID = :UserId";
            $sql2 = "UPDATE `t-session` SET `STATUS`= 0 WHERE USER_ID = :UserId AND STATUS = 1";
            $sql3 = "INSERT INTO `t-session_History` (`SESSION_ID`, `USER_ID`, `LOGIN_TIME`, `LOGOUT_TIME`, `STATUS`) VALUES (:SESSION_ID, :USER_ID, :LOGIN_TIME, :LOGOUT_TIME, :STATUS)";
            $sInfo = $this->getSession($UserId);
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':UserId', $UserId);
            $statement->execute();
            $statement2 = $this->pdo->prepare($sql2);
            $statement2->bindValue(':UserId', $UserId);
            $statement2->execute();
            $statement3 = $this->pdo->prepare($sql3);
            $statement3->bindValue(':SESSION_ID', $sInfo['SESSION_ID']);
            $statement3->bindValue(':USER_ID', $UserId);
            $statement3->bindValue(':LOGIN_TIME', $sInfo['LOGIN_TIME']);
            $statement3->bindValue(':LOGOUT_TIME', date("Y-m-d H:i:s"));
            $statement3->bindValue(':STATUS', 1);
            $statement3->execute();
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function BasicLoginConfig($id, $password, $questions_answers, $correo, $telefono)
    {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE `t-user` SET `EMAIL`= :correo, `PHONE_NUMBER`= :telefono, `STATUS_SESSION`= 1 WHERE USER_ID = :id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':correo', $correo);
            $statement->bindValue(':telefono', $telefono);
            $statement->execute();
            
            // Eliminamos la llamada a NewPassword aquí. El controlador la manejará.
            // $this->NewPassword($id, $password); 

            $sql5 = "SELECT a.PRESET_QUESTION_ID FROM `t-security_questions` a INNER join `t-preset_questions` b ON a.PRESET_QUESTION_ID = b.PRESET_QUESTION_ID WHERE a.USER_ID = :id AND b.STATUS = 1";
            $statement5 = $this->pdo->prepare($sql5);
            $statement5->bindValue(':id', $id);
            $statement5->execute();
            $json = array();
            while ($row2 = $statement5->fetch(PDO::FETCH_ASSOC)) {
                $json[] = array(
                    'PRESET_QUESTION_ID' => $row2["PRESET_QUESTION_ID"],
                );
            }
            if ($json) {
                $sql6 = "UPDATE `t-preset_questions` SET `STATUS`= 0 WHERE PRESET_QUESTION_ID = :id";
                foreach ($json as $key => $value) {
                    $statement6 = $this->pdo->prepare($sql6);
                    $statement6->bindValue(':id', $value['PRESET_QUESTION_ID']);
                    $statement6->execute();
                }
            }
            foreach ($questions_answers as $key => $value) {
                $sql7 = "INSERT INTO `t-preset_questions` (`DESCRIPTION`, `ANSWER`, `STATUS`) VALUES (:DESCRIPTION, :ANSWER, :STATUS)";
                $statement7 = $this->pdo->prepare($sql7);
                $statement7->bindValue(':DESCRIPTION', $key);
                $statement7->bindValue(':ANSWER', $value);
                $statement7->bindValue(':STATUS', 1);
                $statement7->execute();
                $id2 = $this->pdo->lastInsertId();
                $sql8 = "INSERT INTO `t-security_questions`(`USER_ID`, `PRESET_QUESTION_ID`) VALUES (:USER_ID, :PRESET_QUESTION_ID)";
                $statement8 = $this->pdo->prepare($sql8);
                $statement8->bindValue(':USER_ID', $id);
                $statement8->bindValue(':PRESET_QUESTION_ID', $id2);
                $statement8->execute();
            }
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    function NewPassword($id, $password)
    {
        try {
            $this->pdo->beginTransaction();
            $sql2 = "SELECT * FROM `T-USER_KEY` WHERE `USER_ID` = :id AND STATUS = 1";
            $statement2 = $this->pdo->prepare($sql2);
            $statement2->bindValue(':id', $id);
            $statement2->execute();
            $row = $statement2->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $sql3 = "UPDATE `t-user_key` SET `STATUS`= 0, END_DATE = :END_DATE WHERE USER_KEY_ID = :id";
                $statement3 = $this->pdo->prepare($sql3);
                $statement3->bindValue(':id', $row['USER_KEY_ID']);
                $statement3->bindValue(':END_DATE', date("Y-m-d H:i:s"));
                $statement3->execute();
            }
            $sql4 = "INSERT INTO `t-user_key`( `USER_ID`, `KEY`, `START_DATE`, `END_DATE`, `STATUS`) VALUES (:USER_ID, :KEY, :START_DATE, :END_DATE, :STATUS)";
            $end_date = $this->expiration_date();
            $statement4 = $this->pdo->prepare($sql4);
            $statement4->bindValue(':USER_ID', $id);
            $statement4->bindValue(':KEY', $password);
            $statement4->bindValue(':START_DATE', date("Y-m-d H:i:s"));
            $statement4->bindValue(':END_DATE', $end_date);
            $statement4->bindValue(':STATUS', 1);
            $statement4->execute();
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Error en NewPassword: " . $e->getMessage()); // Log del error
            return false; // Devolver false en lugar de lanzar una excepción
        }
    }
    public function UserBlock($user_id)
    {
        try {
            $sql = "UPDATE `t-user` SET `STATUS_SESSION`= 0 WHERE USER_ID = :user_id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function UserUnblock($user_id)
    {
        try {
            $sql = "UPDATE `t-user` SET `STATUS_SESSION`= 1 WHERE USER_ID = :user_id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function UserRestart($user_id)
    {
        try {
            $sql = "UPDATE `t-user` SET `STATUS_SESSION`= 3 WHERE USER_ID = :user_id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function UserDelete($user_id)
    {
        try {
            $sql = "UPDATE `t-user` SET `STATUS`= 0 WHERE USER_ID = :user_id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function UserRestore($user_id)
    {
        try {
            $sql = "UPDATE `t-user` SET `STATUS`= 1 WHERE USER_ID = :user_id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function Viewconfig()
    {
        $row = $this->config;
        return $row;
    }

    public function listarUsuariosActivos()
    {
        $sql = "SELECT USER_ID, USER, NAME, STATUS_SESSION FROM `t-user` WHERE STATUS = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarUsuariosPorEstado($estado = 1)
    {
        $sql = "SELECT USER_ID, USER, NAME, STATUS_SESSION FROM `t-user` WHERE STATUS = :estado";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':estado', $estado);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ActualizarNombre($user_id, $nombre)
    {
        $sql = "UPDATE `t-user` SET `NAME` = :nombre WHERE USER_ID = :id";
        $stmt = $this->pdo->prepare($sql); // Convertir a mayúsculas
        $stmt->bindValue(':nombre', mb_strtoupper($nombre));
        $stmt->bindValue(':id', $user_id);
        return $stmt->execute();
    }

    public function getUltimoUsuarioID()
    {
        return $this->pdo->lastInsertId();
    }

    public function AsignarRol($userId, $rolId)
    {
        $sql = "INSERT INTO `t-user_roles` (`ID_USER`, `ID_ROLES`) VALUES (:userId, :rolId)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':rolId', $rolId);
        return $stmt->execute();
    }

    public function ActualizarRol($userId, $rolId)
    {
        $sql = "UPDATE `t-user_roles` SET `ID_ROLES` = :rolId WHERE `ID_USER` = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':rolId', $rolId);
        $stmt->bindValue(':userId', $userId);
        return $stmt->execute();
    }


    public function listarUsuariosConRol($estado = 1)
    {
        $sql = "SELECT u.USER_ID, u.USER, u.NAME, ur.ID_ROLES,
                CASE ur.ID_ROLES 
                    WHEN 1 THEN 'Administrador' 
                    WHEN 2 THEN 'Asistente' 
                END AS ROLE_NAME
                FROM `t-user` u
                LEFT JOIN `t-user_roles` ur ON u.USER_ID = ur.ID_USER
                WHERE u.STATUS = :estado";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':estado', $estado);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function RegistrarUsuarioConRol($username, $nombre, $correo, $telefono, $password, $rol)
    {
        try {
            $this->pdo->beginTransaction();

            // Insertar usuario
            $sql = "INSERT INTO `t-user` (`USER`, `NAME`, `EMAIL`, `PHONE_NUMBER`, `STATUS`, `STATUS_SESSION`, `LOGIN`) 
                VALUES (:username, :nombre, :correo, :telefono, 1, 1, 0)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':username', mb_strtoupper($username));
            $stmt->bindValue(':nombre', mb_strtoupper($nombre));
            $stmt->bindValue(':correo', mb_strtolower($correo));
            $stmt->bindValue(':telefono', mb_strtoupper($telefono));
            $stmt->execute();

            $userId = $this->pdo->lastInsertId();

            // Guardar contraseña
            $this->NewPassword($userId, $password);

            // Asignar rol
            $this->AsignarRol($userId, $rol);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function obtenerUsuarioParaEditar($userId)
    {
        $sql = "SELECT 
                u.USER_ID,
                u.USER,
                u.NAME,
                IFNULL(ur.ID_ROLS, 0) AS ID_ROLS,
                k.KEY
            FROM `t-user` u
            LEFT JOIN `t-user_roles` ur ON u.USER_ID = ur.ID_USER
            LEFT JOIN `t-user_key` k ON u.USER_ID = k.USER_ID AND k.STATUS = 1
            WHERE u.USER_ID = :userId";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ActualizarUsername($userId, $username)
    {
        $sql = "UPDATE `t-user` SET `USER` = :user WHERE USER_ID = :id";
        $stmt = $this->pdo->prepare($sql); // Convertir a mayúsculas
        $stmt->bindValue(':user', mb_strtoupper($username));
        $stmt->bindValue(':id', $userId);
        return $stmt->execute();
    }
}
