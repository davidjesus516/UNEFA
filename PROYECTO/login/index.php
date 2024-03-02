<?php

session_start();


if (isset($_SESSION['username'])) {
  header('location: vistas/intranet.php');
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Inicio de Sesión</title>
  <link rel="stylesheet" href="vistas/css/estilos.css">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="icon" href="img/logo_unefa.ico">

</head>

<body>

  <div class="login-form">
    <!-- <h1>Login</h1> -->
    <div class="container">
      <div class="main">
        <div class="content">
          <h2>Iniciar Sesión</h2>
          <form id="task-form" method="post">
            <input type="text" id="username-input" name="username" placeholder="Nombre de Usuario" required autofocus="">
            <input type="password" id="password-input" name="password" placeholder="Contraseña de Usuario" required autofocus="">
            <button class="btn" type="submit" id="submit-button">
              Iniciar
            </button>

          </form>
          <p class="account">¿Olvidaste tu contraseña? <a href="olvidar.php">Recuperar contraseña</a></p>

        </div>
        <div class="form-img">
          <img src="" alt="">
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/login.js"></script>

</body>

</html>