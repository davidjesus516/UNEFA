<?php
echo '
<div class="modal"></div>
    <div class="login-form">
        <!-- <h1>Recuperar Usuario</h1> -->
    <div class="container">
        <div class="main">
        <div class="content">
                    <form id="SecurityQuestionForm" action="" method="POST">
                        <input type="hidden" id="user_id" name="user" value="">
                        <input type="hidden" id="question1_id" name="user" value="">
                        <input type="hidden" id="question2_id" name="user" value="">
                        <div id="question1">
                            <h2></h2>
                            <div class="formulario__grupo-input" style="position: relative;">
                                <input type="password" id="answer1-input" name="answer1" placeholder="" required autofocus="">
                                <i class="fas fa-eye toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                            </div>
                        </div>
                        <div id="question2">
                            <h2></h2>
                            <div class="formulario__grupo-input" style="position: relative;">
                                <input type="password" id="answer2-input" name="answer2" placeholder="" required autofocus="">
                                <i class="fas fa-eye toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                            </div>
                        </div>
                        <button class="btn" type="submit" id="submit-button">continuar</button>
            </form>
                    <p class="account">¿Volver al Inicio de Sesión? <a href="index.php">Regresar</a></p>
        </div>
                <div class="form-img">
            <img src="" alt="">
        </div>
        </div>
    </div>
    </div>
    
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/forgot_user.js"></script>
    <!-- El script para manejar el icono del ojo se ha movido a forget_password.php y usa delegación de eventos -->

    
    ';
?>