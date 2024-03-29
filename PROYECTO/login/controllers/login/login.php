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
            
            echo '      
            <dialog id="dialog">
            <h2>Bienvenido '.ucfirst($_SESSION['username']).'.</h2>
            <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
            <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            </dialog>';           
        
        }else{
            // no existe el usuario
            echo '       
            <dialog id="dialog">
            <h2>usuario o contraseña incorrecta </h2>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
            <button aria-label="close" class="x">❌</button>
            </dialog>';
        }



?>