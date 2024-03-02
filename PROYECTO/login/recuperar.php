<?php
 session_start();

    
    if(isset($_SESSION['username'])){
    header('location: views/intranet.php');
    }
    if (!isset($_GET["id"])) {
    header("location: olvidar.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Recuperar</title>
	  <link rel="stylesheet" href="views/css/login.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="icon" href="img/logo_unefa.ico">

</head>
<body>
<div class="boton">
      <a href="index.php">Atras</a>
    </div>
	<section>
      <div class="form-box">
        <div class="form-value">
          <form id="task-form"  method="post" action="#">
          
            <h2>Regenerar Contraseña</h2>
            <input type="hidden" id="id" name="id" value=<?php echo $_GET["id"];?>>
            <div class="inputbox">
              <i class="fi fi-rr-user"></i>
              <input type="password" id="password-input1" name="password" required>
              <label for="">Introduzca su nueva contraseña</label>
            </div>
            <div class="inputbox">
              <i class="fi fi-rr-lock"></i>
              <input type="password" id="password-input2" name="password2" required>
              <label for="">Repita su nueva contraseña</label>
            </div>
            <button id="submit-button">Cambiar Contraseña</button>
          </form>
        </div>
      </div>
    </section>

  <script src="js/jquery-3.7.0.min.js"></script>
	<script src="js/contraseña_nueva.js"></script>
</body>
</html>