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
  <link rel="icon" href="../img/logo_unefa.ico">
</head>

<body>
  <div class="modal">
  </div>
      <div><a href="../index.html"><button><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0,0,300,150"
style="fill:#111a41;">
<g fill="#111a41" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M12,2.09961l-11,9.90039h3v9h6v-7h4v7h6v-9h3z"></path></g></g>
</svg></button></a></div>
  <div class="login-form">
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