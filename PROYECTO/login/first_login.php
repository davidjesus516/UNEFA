<?php
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header('Location: index.php');
}
if ($_SESSION['STATUS_SESSION'] == 2) {
    echo '
<!DOCTYPE html>
<html style="height: 100%; background: #fff;">

<head>
    <meta charset="utf-8">
    <title>Acceso</title>
    <link rel="stylesheet" href="vistas/css/estilos.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="icon" href="../img/logo_unefa.ico">


</head>

<body>
<section>
    <div class="login-form">
        <!-- <h1>Login</h1> -->
        <div class="container">

                <div class="content" style="height: 100vh;">
                    <h2>Bienvenido ' . $_SESSION['NAME'] . '</h2>
                    <p>Para continuar por favor acepte los <a href="../docs/TÉRMINOS_Y_CONDICIONES.pdf" target="_blank">Términos y Condiciones</a>.</p>
                    <form action="basic_user_config.php" method="POST">

                    <div class:"form_terms"> 
                        <label for="terms">Acepto los terminos y condiciones
                            <input style="width: auto;" type="checkbox" name="terms" id="terms" required>
                        </label>
                    </div>
                    <button class="primary btn" type="submit" value="Aceptar">
                    Aceptar
                    </button>
                    <p style="aling-text: center;" class="account"><a href="logout.php">¿Volver al inicio?</a></p>

                </div>
                <div class="form-img-2">
                    <img src="" alt="">
                </div>

        </div>
    </div>
</section>

    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/contraseña_nueva.js"></script>
</body>

</html>
';
}
