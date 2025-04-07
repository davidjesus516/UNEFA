<?php

session_start();


if (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 1) {
  header('location: vistas/intranet.php');
} elseif (isset($_SESSION['USER_ID']) && $_SESSION['STATUS_SESSION'] == 2) {
  header('location: first_login.php');
} elseif (isset($_SESSION['USER_ID']) && $_SESSION['STATUS_SESSION'] == 3) {
  header('location: basic_user_config.php');
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Inicio de Sesión</title>
  <link rel="stylesheet" href="vistas/css/estilos.css">
  <link rel="icon" href="../img/logo_unefa.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
  <div class="modal"></div>

  <div class="login-form">
    <div class="container">
      <div class="main">
        <div class="content">
          <h2>Iniciar Sesión</h2>
          <form id="task-form" method="post">
            <input type="text" id="username-input" name="username" placeholder="Nombre de Usuario" required autofocus="">
            <div class="formulario__grupo-input" style="position: relative;">
              <input type="password" id="password-input" name="password" required placeholder="Ingrese su contraseña">
              <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
            </div>

            <button class="btn" type="submit" id="submit-button">
              Iniciar
            </button>

          </form>
          <p class="account">¿Olvidaste tu contraseña? <a href="forget_password.php">Recuperar contraseña</a></p>

        </div>
        <div class="form-img">
          <img src="" alt="">
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/login.js"></script>
  <script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password-input');

    // Mostrar contraseña al mantener presionado
    togglePassword.addEventListener('mousedown', () => {
      passwordInput.setAttribute('type', 'text');
      togglePassword.classList.remove('fa-eye');
      togglePassword.classList.add('fa-eye-slash');
    });

    // Ocultar contraseña al soltar
    togglePassword.addEventListener('mouseup', () => {
      passwordInput.setAttribute('type', 'password');
      togglePassword.classList.remove('fa-eye-slash');
      togglePassword.classList.add('fa-eye');
    });

    // Para dispositivos móviles
    togglePassword.addEventListener('touchstart', () => {
      passwordInput.setAttribute('type', 'text');
      togglePassword.classList.remove('fa-eye');
      togglePassword.classList.add('fa-eye-slash');
    });

    togglePassword.addEventListener('touchend', () => {
      passwordInput.setAttribute('type', 'password');
      togglePassword.classList.remove('fa-eye-slash');
      togglePassword.classList.add('fa-eye');
    });
  </script>


</body>

</html>