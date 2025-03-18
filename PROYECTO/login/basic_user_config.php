<?php
session_start();


if (!isset($_SESSION['USER_ID'])) {
  header('Location: index.php');
} elseif (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 1) {
  header('location: vistas/intranet.php');
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
        <div class="content_user content">
          <h2>Nueva Contraseña</h2>
          <form id="task-form" method="post" action="#">
            <input type="hidden" id="id" name="id" value=<?php echo $_SESSION["USER_ID"]; ?>>
            <div class="fo"></div>
            <div class="formulario__grupo" id="grupo__password1">
              <div class="formulario__grupo-input">
                <input type="password" id="password-input1" name="password" required placeholder="Ingrese la nueva contraseña" required autofocus="">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>
            <div class="formulario__grupo" id="grupo__password2">
              <div class="formulario__grupo-input">
              <input type="password" id="password-input2" name="password2" placeholder="Repita la nueva contraseña" required>
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>

            <h4>Preguntas de recuperacion:</h4>
            
            <div class="formulario__grupo" id="grupo__question1">
              <select id="question1" class="selector formulario__input" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="¿Cuál era el apodo de tu mejor amigo de la infancia?">¿Cuál era el apodo de tu mejor amigo de la infancia?</option>
                <option value="¿En qué ciudad se conocieron sus padres?">¿En qué ciudad se conocieron sus padres?</option>
                <option value="¿Cuál es el apellido de tu vecino?">¿Cuál es el apellido de tu vecino?</option>
                <option value="¿Cuántas mascotas tenías a los 10 años?">¿Cuántas mascotas tenías a los 10 años?</option>
                <option value="¿En qué mes te casaste?">¿En qué mes te casaste?</option>
              </select>
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
              <p class="formulario__input-error">Validacion</p>
            </div>
            <div class="formulario__grupo" id="grupo__answer1">
              <div class="formulario__grupo-input">
              <input type="password" id="answer1" name="answer1" placeholder="ingresar respuesta" required>
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>
            <div class="formulario__grupo" id="grupo__question2">
              <select id="question2" class="selector formulario__input" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="¿Cuál era el apodo de tu mejor amigo de la infancia?">¿Cuál era el apodo de tu mejor amigo de la infancia?</option>
                <option value="¿En qué ciudad se conocieron sus padres?">¿En qué ciudad se conocieron sus padres?</option>
                <option value="¿Cuál es el apellido de tu vecino?">¿Cuál es el apellido de tu vecino?</option>
                <option value="¿Cuántas mascotas tenías a los 10 años?">¿Cuántas mascotas tenías a los 10 años?</option>
                <option value="¿En qué mes te casaste?">¿En qué mes te casaste?</option>
              </select>
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
              <p class="formulario__input-error">Validacion</p>
            </div>
            <div class="formulario__grupo" id="grupo__answer2">
              <div class="formulario__grupo-input">
              <input type="password" id="answer2" name="answer2" placeholder="ingresar respuesta" required>
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>
            <div class="formulario__grupo" id="grupo__question3">
              <select id="question3" class="selector formulario__input" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="¿Cuál era el apodo de tu mejor amigo de la infancia?">¿Cuál era el apodo de tu mejor amigo de la infancia?</option>
                <option value="¿En qué ciudad se conocieron sus padres?">¿En qué ciudad se conocieron sus padres?</option>
                <option value="¿Cuál es el apellido de tu vecino?">¿Cuál es el apellido de tu vecino?</option>
                <option value="¿Cuántas mascotas tenías a los 10 años?">¿Cuántas mascotas tenías a los 10 años?</option>
                <option value="¿En qué mes te casaste?">¿En qué mes te casaste?</option>
              </select>
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
              <p class="formulario__input-error">Validacion</p>
            </div>
            <div class="formulario__grupo" id="grupo__answer3">
              <div class="formulario__grupo-input">
              <input type="password" id="answer3" name="answer3" placeholder="ingresar respuesta" required>
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>
            <button class="btn" type="submit" id="submit-button">
              Enviar
            </button>

          </form>
          <p class="account"><a href="logout.php">¿Volver al inicio?</a></p>

        </div>
        <!-- <div class="form-img-2">
          <img src="" alt="">
        </div> -->
      </div>
    </div>
  </div>
  </section>

  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/basic_login_config.js"></script>
</body>

</html>