<?php
require_once '../../model/usuario.php';
$user = new Usuario();
$key = password_hash('admin', PASSWORD_DEFAULT);
if(
$user->UserCreate('admin', '00000000', 'admin', '','','', 'admin@admin.com', '00000000000', $key)){
    echo "Usuario creado correctamente";
}else{
    echo "Error al crear el usuario";
};
?>