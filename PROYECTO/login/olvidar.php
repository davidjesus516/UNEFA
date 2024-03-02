<?php
require_once 'model/conexion.php';
if (isset($_POST['username'])) {
  $username = $_POST['username'];

  $db = new Conexion('localhost', 'unefa', 'root', '');
  $query = $db->conectar()->prepare('SELECT *FROM usuarios WHERE username = :username');
  $query->execute(['username' => $username]);

  $row = $query->fetch(PDO::FETCH_ASSOC);
}
$n1 = random_int(1, 3);
$n2 = random_int(1, 3);
while ($n1 === $n2) {
  $n1 = random_int(1, 3);
  $n2 = random_int(1, 3);
}

session_start();


if (isset($_SESSION['username'])) {
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
  <link rel="icon" href="img/logo_unefa.ico">

</head>

<body>
  <?php if (!isset($_POST['username'])) {
    echo '
    <div class="login-form">
    <!-- <h1>Recuperar Usuario</h1> -->
    <div class="container">
      <div class="main">
        <div class="content">
          <h2>Recuperar Usuario</h2>
          <form id="task-form" action="#" method="POST">
            <input type="text" id="username-input" name="username" placeholder="Nombre de Usuario" required autofocus="">
            <button class="btn" type="submit" id="submit-button">
              Recuperar
            </button>
          </form>
          <p class="account">¿Volver al Inicio de Sesión? <a href="index.php">Regresar</a></p>
        </div>
        <div class="form-img">
          <img src="" alt="">
        </div>
      </div>
    </div>
  </div>


    ';
  }
  if (isset($_POST['username'])) {
    echo '

    <div class="login-form">
      <div class="container">
        <div class="main">
          <div class="content">
            <h2>Preguntas de Seguridad</h2>
            <form id="task-form" action="controllers\login\validar.php" method="POST">
            <input type="hidden" name="ID" value=' . $row["ID"] . ' />
            <input type="hidden" name="n1" value="' . $n1 . '"/>
            <input type="hidden" name="n2" value="' . $n2 . '"/>
            <input  type="text" id="respuesta-input" name="respuesta1" required/>
            <label for="">' . ucfirst($row["pregunta" . $n1 . ""]) . '</label>
            <input  type="text" id="respuesta-input" name="respuesta2" required/>
            <label for="">' . ucfirst($row["pregunta" . $n2 . ""]) . '</label>
          </div>
            <button class="btn" type="submit" id="submit-button">
                Recuperar
              </button>
            </form>
          </div>
          <div class="form-img">
            <img src="" alt="">
          </div>
        </div>
      </div>
      </div>
  
';
  }
  ?>
  <script src="js/jquery-3.7.0.min.js"></script>
</body>

</html>

<!-- <section>
  <div class="form-box">
    <div class="form-value">
      <form action="#" method="POST">
        <h2>Login</h2>
        <div class="inputbox">
          <i class="fi fi-rr-user"></i>
          <input type="text" id="username-input" name="username" required>
          <label for="">username</label>
        </div>
        <button id="submit-button">validar</button>
      </form>
    </div>
  </div>
</section> 


  <section>
      <div class="form-box">
        <div class="form-value">
          <form action="controllers\controllers_login\validar.php" method="POST">
            <h2>Preguntas de Seguridad</h2>
            <input type="hidden" name="ID" value=' . $row["ID"] . ' />
            <input type="hidden" name="n1" value="' . $n1 . '"/>
            <input type="hidden" name="n2" value="' . $n2 . '"/>
            <div class="inputbox">
              <i class="fi fi-rr-user"></i>
            <input  type="text" id="respuesta-input" name="respuesta1" required/>
              <label for="">' . ucfirst($row["pregunta" . $n1 . ""]) . '</label>
            </div>
            <div class="inputbox">
              <i class="fi fi-rr-lock"></i>
              <input  type="text" id="respuesta-input" name="respuesta2" required/>
              <label for="">' . ucfirst($row["pregunta" . $n2 . ""]) . '</label>
            </div>
            <button id="submit-button">validar</button>
          </form>
        </div>
      </div>
  </section>
-->