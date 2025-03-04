<?php
session_start();


if (isset($_SESSION['username'])) {
  header('location: vistas/intranet.php');
}
if (!isset($_GET["id"])) {
  header("location: forget_password.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Recuperar</title>
  <link rel="stylesheet" href="vistas/css/estilos.css">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="icon" href="../img/logo_unefa.ico">


</head>

<body>

  <div class="login-form">
    <!-- <h1>Login</h1> -->
    <div class="container">
      <div class="main">
        <div class="content">
          <h2>Nueva Contraseña</h2>
          <form id="task-form" method="post" action="#">
            <input type="hidden" id="id" name="id" value=<?php echo $_GET["id"]; ?>>
            <input type="password" id="password-input1" name="password" required placeholder="Ingrese la nueva contraseña" required autofocus="">
            <input type="password" id="password-input2" name="password2" placeholder="Repita la nueva contraseña" required autofocus="">
            <button class="btn" type="submit" id="submit-button">
              Cambiar la Contraseña
            </button>

          </form>
          <p class="account"><a href="index.php">¿Volver al inicio?</a></p>

        </div>
        <div class="form-img-2">
          <img src="" alt="">
        </div>
      </div>
    </div>
  </div>
  </section>

  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/contraseña_nueva.js"></script>
</body>

</html>