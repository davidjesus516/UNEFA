<?php
session_start();
// codigo que comprueba la existencia de una sesion activa
if (!isset($_SESSION['USER_ID'])) {
    header('location: index.php');
    exit();
}
// codigo que comprueba si la sesion es de un usuario activo
if (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 1) {
    header('location: vistas/intranet.php');
} elseif (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 2) {
    header('location: first_login.php');
} elseif (isset($_SESSION['USER']) && $_SESSION['STATUS_SESSION'] == 3) {
    header('location: basic_user_config.php');
} ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nueva Contraseña</title>
    <link rel="stylesheet" href="vistas/css/estilos.css">
    <link rel="icon" href="../img/logo_unefa.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

    <div class="login-form">
        <!-- <h1>Login</h1> -->
        <div class="container">
            <div class="main">
                <div class="content">
                    <h2>Nueva Contraseña</h2>
                    <form id="NewPasswordForm" method="post" action="#">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($_SESSION['USER_ID']); ?>">
                        <div class="formulario__grupo" id="grupo__password1">
                            <div class="formulario__grupo-input">
                                <input type="password" id="password-input1" name="password" required placeholder="Ingrese la nueva contraseña" autofocus="">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.</p>
                        </div>
                        <div class="formulario__grupo" id="grupo__password2">
                            <div class="formulario__grupo-input">
                                <input type="password" id="password-input2" name="password2" placeholder="Repita la nueva contraseña" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <p class="formulario__input-error">Las contraseñas no coinciden.</p>
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

    <div class="modal"></div>

    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/new_password.js"></script>
    <script>
        // Este script es para un toggle de ver/ocultar contraseña, pero no hay un elemento con id 'toggle-password' en el HTML.
        // Si lo necesitas, asegúrate de añadir el icono del ojo en los inputs de contraseña.
        // Ejemplo: <i id="toggle-password-1" class="fas fa-eye toggle-password"></i>
        
        // const togglePassword = document.getElementById('toggle-password');
        // const passwordInput = document.getElementById('password-input');

        // if (togglePassword && passwordInput) {
        //     // Mostrar contraseña al mantener presionado
        //     togglePassword.addEventListener('mousedown', () => {
        //         passwordInput.setAttribute('type', 'text');
        //         togglePassword.classList.remove('fa-eye');
        //         togglePassword.classList.add('fa-eye-slash');
        //     });

        //     // Ocultar contraseña al soltar
        //     togglePassword.addEventListener('mouseup', () => {
        //         passwordInput.setAttribute('type', 'password');
        //         togglePassword.classList.remove('fa-eye-slash');
        //         togglePassword.classList.add('fa-eye');
        //     });

        //     // Para dispositivos móviles
        //     togglePassword.addEventListener('touchstart', () => {
        //         passwordInput.setAttribute('type', 'text');
        //         togglePassword.classList.remove('fa-eye');
        //         togglePassword.classList.add('fa-eye-slash');
        //     });

        //     togglePassword.addEventListener('touchend', () => {
        //         passwordInput.setAttribute('type', 'password');
        //         togglePassword.classList.remove('fa-eye-slash');
        //         togglePassword.classList.add('fa-eye');
        //     });
        // }
    </script>


</body>

</html>
