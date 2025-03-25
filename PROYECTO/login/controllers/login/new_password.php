<?php
require_once '..\..\model\usuario.php';
$usuario = new Usuario();
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $row = $usuario->NewPassword($user_id, $password);
    if ($row === true) {
        echo 1;
    } else {
        echo 0;
    }
}
