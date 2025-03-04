<?php
if (isset($_POST['username'])) {
    
require_once 'model/login.php';
$usuario = new Usuario();
$username = $_POST['username'];
$row = $usuario->SearchUsername($username);

}
?>