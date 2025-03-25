<?php
echo '
<div class="modal"></div>
  <div class="login-form">
    <!-- <h1>Login</h1> -->
    <div class="container">
      <div class="main">
        <div class="content">
          <h2>Nueva Contraseña</h2>
          <form id = "NewPasswordForm" method="post" action="#">
            <input type="hidden" id="user_id" name="user_id" value="">
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
    
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/forgot_user.js"></script>
';
?>