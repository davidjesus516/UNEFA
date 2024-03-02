<?php 

session_start();

    $username = $_POST["username"];//guardo lo q mando
    $password = $_POST["password"];

    // incluir la clase Usuario
    require_once("../../model/login.php");

    // crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // llamar al método para buscar un usuario por su codigo
    $_SESSION = $usuario->login($username,$password);
		if(isset( $_SESSION['username'])){
            
            echo "Bienvenido ".ucfirst($_SESSION['username']);           
        
        }else{
            // no existe el usuario
            echo ("usuario o contraseña incorrecta");
        }



?>