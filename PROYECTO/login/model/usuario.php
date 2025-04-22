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
        $date = date('Y-m-d H:i:s', strtotime('+'.$this->config['EXPIRATION_DAYS'].' days'));
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
            $statement->bindValue(':USER', $USER);
            $statement->bindValue(':USER_CI', $USER_CI);
            $statement->bindValue(':NAME', $NAME);
            $statement->bindValue(':SECOND_NAME', $SECOND_NAME);
            $statement->bindValue(':SURNAME', $SURNAME);
            $statement->bindValue(':SECOND_SURNAME', $SECOND_SURNAME);
            $statement->bindValue(':EMAIL', $EMAIL);
            $statement->bindValue(':PHONE_NUMBER', $PHONE_NUMBER);
            $statement->bindValue(':CREATION_DATE', date("Y-m-d H:i:s"));
            $statement->bindValue(':LOGIN', 0);
            $statement->bindValue(':TERMS_CONDITIONS', 0);
            $statement->bindValue(':STATUS_SESSION', 2);
            $statement->bindValue(':STATUS', 1);
            $statement->execute();

            $id = $this->pdo->lastInsertId();
            $sql2 = "INSERT INTO `t-user_key`( `USER_ID`, `KEY`, `START_DATE`, `END_DATE`, `STATUS`) VALUES (:USER_ID, :KEY, :START_DATE, :END_DATE, :STATUS)";
            $statement2 = $this->pdo->prepare($sql2);
            $end_date = $this->expiration_date();
            $statement2->bindValue(':USER_ID', $id);
            $statement2->bindValue(':KEY', $KEY);
            $statement2->bindValue(':START_DATE', date("Y-m-d H:i:s"));
            $statement2->bindValue(':END_DATE', $end_date);
            $statement2->bindValue(':STATUS', 1);
            $statement2->execute();
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                return false;
            } else {
                $this->pdo->rollBack();
                throw $e;
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
    public function SearchLastNUserKey($UserId){
        
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
            $sql = "INSERT INTO `t-session_attempts`(`USER_ID`, `ATTEMPT_TIME`, `STATUS`) VALUES (:USER_ID, :ATTEMPT_TIME, :STATUS)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':USER_ID', $UserId);
            $statement->bindValue(':ATTEMPT_TIME', date("Y-m-d H:i:s"));
            $statement->bindValue(':STATUS', 1);
            $statement->execute();
            return true;
        } catch (Exception $e) {
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
    public function BasicLoginConfig($id, $password, $questions_answers,$correo, $telefono)
    {
        try {
            $sql = "UPDATE `t-user` SET `EMAIL`= :correo, `PHONE_NUMBER`= :telefono, `STATUS_SESSION`= 1 WHERE USER_ID = :id";
            $statement = $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':correo', $correo);
            $statement->bindValue(':telefono', $telefono);
            $statement->execute();
            $this->NewPassword($id, $password);
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
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    public function UserBlock($user_id)  {
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
    public function UserUnblock($user_id)  {
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
    public function UserRestart($user_id)  {
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
    public function UserDelete($user_id)  {
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
    public function UserRestore($user_id)  {
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
}
