<?php
if (isset($_POST['id'])) {
require_once '..\..\model\login.php';
$usuario = new Usuario();
$id = $_POST['id'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$question1 = $_POST['question1'];
$answer1 = $_POST['answer1'];
$question2 = $_POST['question2'];
$answer2 = $_POST['answer2'];   
$question3 = $_POST['question3'];
$answer3 = $_POST['answer3'];
$questions_answers = array(
    $question1 => $answer1,
    $question2 => $answer2,
    $question3 => $answer3
);
$row = $usuario->basic_login_config($id, $password, $questions_answers);
if ($row == true) {
    echo 1;
} else {
    echo 0;   
}
}
?>