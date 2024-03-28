<?php
if (isset($_POST['username'])) {
    
require_once 'model/login.php';
$usuario = new Usuario();
$username = $_POST['username'];
$row = $usuario->bucar_usuario($username);

$n1 = random_int(1, 3);
$n2 = random_int(1, 3);
while ($n1 === $n2) {
$n1 = random_int(1, 3);
$n2 = random_int(1, 3);
}
}
?>