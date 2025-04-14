<?php
require 'header.php';
?>
<span class="text">Ventana -> <a href="usuario.php">Configuración</a> -> Preguntas Preestablecidas</span>
<div class="page-content">
<a href="preguntas.php">Listado de Preguntas de Seuridad</a>
    <h2>Configuracion de Preguntas Preestablecidas</h2>

    <form action="#" class="formulario" id="formulario">
        <!-- Grupo: Usuario -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Preguntas por Usuario <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>

        <br>
        <!-- Grupo: Usuario -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Preguntas Preestablecidas por Usuario <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>

        <br>

        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Longitud Minima Pregunta <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener numeros</p>
        </div>
        <br>

        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Longitud Maxima Pregunta <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener numeros</p>
        </div>
        <br>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Respuestas por Usuario <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>
        <br>

        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Longitud Minima Respuesta <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener numeros</p>
        </div>
        <br>

        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Longitud Maxima Respuesta <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener numeros</p>
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