<?php
require_once '../../model/usuario.php';
$user = new Usuario();
$key = password_hash('admin', PASSWORD_DEFAULT);
$user->UserCreate('admin', '00000000', 'admin', '','','', 'admin@admin.com', '00000000000', $key);
?>