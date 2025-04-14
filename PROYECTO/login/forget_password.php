<?php
session_start();
// codigo que comprueba la existencia de una sesion activa
if (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 1) {
  header('location: vistas/intranet.php');
} elseif (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 2) {
  header('location: first_login.php');
} elseif (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 3) {
  header('location: basic_user_config.php');
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Recuperar Contraseña</title>
  <link rel="stylesheet" href="vistas/css/estilos.css">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="icon" href="../img/logo_unefa.ico">


</head>

<body>
  
  <div class="modal"></div>
    <div class="login-form">
    <!-- <h1>Recuperar Usuario</h1> -->
      <div class="container">
        <div class="main">
          <div class="content">
            
            <h2>Recuperar Usuario</h2>
            
            <form id = 'UserSearchForm' action="#" method="POST">
              <input type="text" id="username-input" name="username" placeholder="Nombre de Usuario" required autofocus="">
              <button class="btn" type="submit" id="submit-button">Recuperar</button>
            </form>

            <p class="account">¿Volver al Inicio de Sesión? <a href="index.php">Regresar</a></p>
          </div>
          
          <div class="form-img">
            <img src="" alt="">
          </div>
        
        </div>
      </div>
    <!-- </div> -->
  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/forgot_user.js"></script>
</body>

</html>
