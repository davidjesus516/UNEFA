<?php
if (isset($_POST['id'])) {
require_once '..\..\model\usuario.php';
$usuario = new Usuario();
$id = $_POST['id'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$question1 = $_POST['question1'];
$answer1 = mb_strtoupper($_POST['answer1']);
$question2 = $_POST['question2'];
$answer2 = mb_strtoupper($_POST['answer2']);   
$question3 = $_POST['question3'];
$answer3 = mb_strtoupper($_POST['answer3']);
$questions_answers = array(
    $question1 => $answer1,
    $question2 => $answer2,
    $question3 => $answer3
);
$search_actual_password = $usuario->SearchUserKey($_SESSION["USER_ID"]);
if (password_verify($_POST['passwordinput0'], $search_actual_password['KEY'])) {
    $row = $usuario->basic_login_config($id, $password, $questions_answers);
if ($row === true) {
    echo 1;
} else {
    echo 0;   
}
}
else {
    echo 2; // Contraseña actual incorrecta
}
} else {
    echo 0; // Error al procesar la solicitud

}
?>