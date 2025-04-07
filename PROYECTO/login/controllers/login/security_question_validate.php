<?php
require_once "../../model/usuario.php";
$user_id = $_POST["user_id"];
$question1_id = $_POST["question1_id"];
$question2_id = $_POST["question2_id"];
$answer1 = mb_strtoupper($_POST["answer1"]);
$answer2 = mb_strtoupper($_POST["answer2"]);
$user = new Usuario;
$row = $user->userSecurityQuestionSearchByID($user_id);
if ($row[$question1_id] == $answer1 && $row[$question2_id] == $answer2) {
    $row = 1;
} else {
    $row = 0;
}
echo $row;
?>