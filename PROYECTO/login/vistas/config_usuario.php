<?php
require 'header.php';
?>
<span class="text">Ventana -> <a href="usuario.php">Configuración</a> -> Usuario</span>
<div class="page-content">

    <h2>Configuracion de Usuario</h2>

    <form action="#" class="formulario" id="formulario">
        <!-- Grupo: Usuario -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Longitud Minima <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>

        <br>
        <!-- Grupo: Usuario -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Longitud Maxima <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>

        <br>

        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Cantidad de Mayusculas <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener numeros</p>
        </div>
        <br>

        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Cantidad de Minusculas <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener numeros</p>
        </div>
        <br>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Cantidad de Números <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>
        <br>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Cantidad de Caracteres Especiales <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>
        <br>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Tiempo de Inactividad <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <p>días</p>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>




        <div class="formulario__grupo formulario__grupo-btn-enviar">
            <button type="submit" class="formulario__btn">Guardar</button>
            <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
        </div>

    </form>


</div>
</div>
<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<!-- <script src="js/estudiante/main.js"></script> -->
<?php
require 'footer.php';
?>