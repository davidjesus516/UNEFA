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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



</head>

<body>

  <div class="modal"></div>
  <div class="login-form">
    <!-- <h1>Recuperar Usuario</h1> -->
    <div class="container">
      <div class="main">
        <div class="content">

          <h2>Recuperar Usuario</h2>

          <form id='UserSearchForm' action="#" method="POST">
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
    <script>
      // Se utiliza la delegación de eventos en el body para que el script funcione
      // con el contenido que se carga dinámicamente (las preguntas de seguridad).
      document.querySelector('body').addEventListener('click', function(event) {
        // Se comprueba si el elemento clickeado tiene la clase 'toggle-password'
        if (event.target.classList.contains('toggle-password')) {
          const togglePassword = event.target;
          const passwordInput = togglePassword.previousElementSibling;

          // Alternar el tipo del campo de contraseña
          const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
          passwordInput.setAttribute("type", type);

          // Alternar el icono del ojo
          togglePassword.classList.toggle("fa-eye-slash");
          togglePassword.classList.toggle("fa-eye");
        }
      });
    </script>
</body>

</html>