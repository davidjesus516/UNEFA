<?php 
if(isset($_POST)){
$ID = $_POST['id'];
$password = $_POST['password'];	
require_once '../../model/login.php';
$usuario = new Usuario();

    // llamar al método para buscar un usuario por su codigo
if($row=$usuario->contraseñanueva($ID,$password)){}

echo "contraseña cambiada con exito";

}
?>