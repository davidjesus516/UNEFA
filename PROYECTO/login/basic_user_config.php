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
  <title>Actualizar Contraseña</title>
  <link rel="stylesheet" href="vistas/css/estilos.css">
  <!-- <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" href="../img/logo_unefa.ico">


</head>
<style>
  .hidden {
    display: none;
  }
</style>

<body>

  <div class="login-form">
    <!-- <h1>Login</h1> -->
    <div class="container">
      <div class="main">
        <div class="content_user content">
          <h2>Nueva Contraseña</h2>
          <form id="task-form">
            <input type="hidden" id="id" name="id" value=<?php echo $_SESSION["USER_ID"]; ?>>

            <div class="formulario__grupo" id="grupo__password0">
              <h5>Contraseña Actual: <span class="obligatorio">*</span></h5>
              <div class="formulario__grupo-input">
                <input type="password" id="password-input0" name="password" required placeholder="Ingrese la contraseña actual" required autofocus="">
                <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
              </div>
              <p class="formulario__input-error">La Contraseña no es valida</p>
            </div>

            <div class="formulario__grupo" id="grupo__password01">
              <div class="formulario__grupo-input">
                <input type="password" id="password-input01" name="password" required placeholder="Repita la contraseña actual" required autofocus="">
                <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
              </div>
              <p class="formulario__input-error">La Contraseña no coincide</p>
            </div>

            <div class="formulario__grupo" id="grupo__password1">
              <h5>Contraseña Nueva: <span class="obligatorio">*</span></h5>
              <div class="formulario__grupo-input">
                <input type="password" id="password-input1" name="password" required placeholder="Ingrese la nueva contraseña" required autofocus="">
                <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>
            <div class="formulario__grupo" id="grupo__password2">
              <div class="formulario__grupo-input">
                <input type="password" id="password-input2" name="password2" placeholder="Repita la nueva contraseña" required>
                <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>


            <br>

            <div class="formulario__grupo" id="grupo__question1">
              <h4>Preguntas de recuperacion: <span class="obligatorio">*</span></h4>
              <select id="question1" class="selector formulario__input" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="¿Cuál era el apodo de tu mejor amigo de la infancia?">¿Cuál era el apodo de tu mejor amigo de la infancia?</option>
                <option value="¿En qué ciudad se conocieron sus padres?">¿En qué ciudad se conocieron sus padres?</option>
                <option value="¿Cuál es el apellido de tu vecino?">¿Cuál es el apellido de tu vecino?</option>
                <option value="¿Cuántas mascotas tenías a los 10 años?">¿Cuántas mascotas tenías a los 10 años?</option>
                <option value="¿En qué mes te casaste?">¿En qué mes te casaste?</option>
              </select>
              <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
              <p class="formulario__input-error">Validacion</p>
            </div>
            <div class="formulario__grupo" id="grupo__answer1">
              <div class="formulario__grupo-input">
                <input type="password" id="answer1" name="answer1" placeholder="ingresar respuesta" required>
                <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>

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
              <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
              <p class="formulario__input-error">Validacion</p>
            </div>
            <div class="formulario__grupo" id="grupo__answer2">
              <div class="formulario__grupo-input">
                <input type="password" id="answer2" name="answer2" placeholder="ingresar respuesta" required>
                <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>

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
              <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
              <p class="formulario__input-error">Validacion</p>
            </div>
            <div class="formulario__grupo" id="grupo__answer3">
              <div class="formulario__grupo-input">
                <input type="password" id="answer3" name="answer3" placeholder="ingresar respuesta" required>
                <i class="fas fa-eye toggle-password" id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>

              </div>
              <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>

              <div class="formulario__grupo" id="grupo__correo">
                <h5>Correo Electronico: <span class="obligatorio">*</span></h5>
                <div class="formulario__grupo-input">
                  <input type="email" id="correo" name="correo" required placeholder="Ingrese su correo" required autofocus="">
                </div>
                <p class="formulario__input-error">No es valido</p>
              </div>

              <div class="formulario__grupo" id="grupo__telefono">
                <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                  <input type="tel" class="formulario__input" name="number_tel" id="number_tel" placeholder="Ingrese su numero telefonico">
                </div>
                <p class="formulario__input-error">El telefono solo puede contener numeros y el maximo son 14 dígitos.</p>
              </div>
              <button class="btn" type="submit" id="submit-button">
                Enviar
              </button>
            </div>


          </form>
          <p class="account" style="text-align: center;"><a href="logout.php">¿Volver al inicio?</a></p>

        </div>
      </div>
    </div>
  </div>
  </section>

  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/basic_login_config.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const password0 = document.getElementById("password-input0"); // Contraseña actual
      const password01 = document.getElementById("password-input01"); // Confirmar contraseña actual
      const password1 = document.getElementById("password-input1"); // Nueva contraseña
      const password2 = document.getElementById("password-input2"); // Repetir nueva contraseña

      const groupPassword1 = document.getElementById("grupo__password1");
      const groupPassword2 = document.getElementById("grupo__password2");
      const questions = ["grupo__question1", "grupo__answer1", "grupo__question2", "grupo__answer2", "grupo__question3", "grupo__answer3"];

      // Elementos de error
      const errorTextCurrent = document.querySelector("#grupo__password01 .formulario__input-error");
      const errorTextNew = document.querySelector("#grupo__password1 .formulario__input-error");
      const errorTextRepeat = document.querySelector("#grupo__password2 .formulario__input-error");

      // Ocultar los campos adicionales al inicio
      groupPassword1.style.display = "none";
      groupPassword2.style.display = "none";
      questions.forEach(id => document.getElementById(id).style.display = "none");

      function validarCamposActuales() {
        if (password01.value !== "") {
          if (password0.value.length >= 5 && password01.value === password0.value) {
            groupPassword1.style.display = "block";
            errorTextCurrent.style.display = "none";
          } else {
            groupPassword1.style.display = "none";
            groupPassword2.style.display = "none";
            questions.forEach(id => document.getElementById(id).style.display = "none");
            errorTextCurrent.style.display = "block";
          }
        } else {
          errorTextCurrent.style.display = "none";
        }
      }

      function validarNuevaContrasena() {
        const nuevaContrasena = password1.value;
        const regexMayuscula = /[A-Z]/;
        const regexMinuscula = /[a-z]/;
        const regexNumero = /[0-9]/;

        if (nuevaContrasena !== "") {
          if (nuevaContrasena === password0.value) {
            errorTextNew.textContent = "La nueva contraseña no puede ser igual a la anterior.";
            errorTextNew.style.display = "block";
            groupPassword2.style.display = "none";
            questions.forEach(id => document.getElementById(id).style.display = "none");
          } else if (
            nuevaContrasena.length < 8 ||
            !regexMayuscula.test(nuevaContrasena) ||
            !regexMinuscula.test(nuevaContrasena) ||
            !regexNumero.test(nuevaContrasena)
          ) {
            errorTextNew.textContent = "La contraseña debe tener mínimo 8 caracteres, incluyendo mayúsculas, minúsculas y números.";
            errorTextNew.style.display = "block";
            groupPassword2.style.display = "none";
            questions.forEach(id => document.getElementById(id).style.display = "none");
          } else {
            errorTextNew.style.display = "none";
            groupPassword2.style.display = "block";
          }
        } else {
          errorTextNew.style.display = "none";
          groupPassword2.style.display = "none";
          questions.forEach(id => document.getElementById(id).style.display = "none");
        }
      }

      function validarConfirmacionNueva() {
        if (password2.value !== "") {
          if (password1.value === password2.value) {
            errorTextRepeat.style.display = "none";
            questions.forEach(id => document.getElementById(id).style.display = "block");
          } else {
            errorTextRepeat.style.display = "block";
            questions.forEach(id => document.getElementById(id).style.display = "none");
          }
        } else {
          errorTextRepeat.style.display = "none";
          questions.forEach(id => document.getElementById(id).style.display = "none");
        }
      }

      password01.addEventListener("input", validarCamposActuales);
      password1.addEventListener("input", validarNuevaContrasena);
      password2.addEventListener("input", validarConfirmacionNueva);
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const telefonoInput = document.getElementById('number_tel');
      const errorMensaje = document.getElementById('telefono-error');

      // Solo permite números
      telefonoInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, ''); // Elimina cualquier carácter no numérico
      });

      // Validar al salir del input
      telefonoInput.addEventListener('blur', function() {
        if (telefonoInput.value.length < 10) {
          errorMensaje.style.display = 'block';
          telefonoInput.classList.add('formulario__input--incorrecto');
          telefonoInput.classList.remove('formulario__input--correcto');
        } else {
          errorMensaje.style.display = 'none';
          telefonoInput.classList.remove('formulario__input--incorrecto');
          telefonoInput.classList.add('formulario__input--correcto');
        }
      });
    });
  </script>


  <script>
    // Seleccionamos todos los elementos con la clase 'toggle-password'
    const togglePasswords = document.querySelectorAll('.toggle-password');

    // Iteramos sobre todos los elementos encontrados
    togglePasswords.forEach(togglePassword => {
      const passwordInput = togglePassword.previousElementSibling; // El campo de contraseña está justo antes del icono del ojo

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
    });
  </script>

</body>

</html>