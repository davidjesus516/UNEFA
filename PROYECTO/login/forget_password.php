<?php

require_once 'controllers/login/buscar_usuario.php';
session_start();
// codigo que comprueba la existencia de una sesion activa

if (isset($_SESSION['username'])) {
  // en caso de que exista sesion activa  redirige a la intranet
  header('location: vistas/intranet.php');
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
  <?php if (!isset($_POST['username'])  or !isset($row["ID"])) {
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
            </dialog>
    <div class="login-form">
    <!-- <h1>Recuperar Usuario</h1> -->
      <div class="container">
        <div class="main">
          <div class="content">
            
            <h2>Recuperar Usuario</h2>
            
            <form action="#" method="POST">
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


    ';
    if (isset($_POST['username'])) {
      echo "<script>window.dialog.showModal(); </script>";
    };
  }
  if (isset($_POST['username'])) {
    echo '

    <div class="login-form">
      <div class="container">
        <div class="main">
          <div class="content">
            <h2>Preguntas de Seguridad</h2>
            <form action="controllers\login\validar.php" method="POST">
            <input type="hidden" name="ID" value=' . $row["ID"] . ' />
            <input type="hidden" name="n1" value="' . $n1 . '"/>
            <input type="hidden" name="n2" value="' . $n2 . '"/>
            <label for="">' . ucfirst($row["pregunta" . $n1 . ""]) . '</label>
            <input  type="text" id="respuesta-input" name="respuesta1" required/>
            <label for="">' . ucfirst($row["pregunta" . $n2 . ""]) . '</label>
            <input  type="text" id="respuesta-input" name="respuesta2" required/>
            <button class="btn" type="submit" id="submit-button">Recuperar</button>
            <p class="account">¿Volver al Inicio de Sesión? <a href="index.php">Regresar</a></p>
          </div>
          </form>
          <div class="form-img">
            <img src="" alt="">
          </div>
          </div>
        </div>
      </div>
      </div>
  
';
  }
  ?>
  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/login.js"></script>
</body>

</html>
