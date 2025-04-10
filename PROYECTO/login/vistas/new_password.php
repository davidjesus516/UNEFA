<?php
require 'header.php';
?>
<span class="text">Nueva Contraseña</span>
<div class="page-content">

    <h2>Configuracion de Contraseña</h2>

    <form action="#" class="formulario" id="formulario">
        <!-- Grupo: Usuario -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Longitud minima <span class="obligatorio">*</span></label>
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

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label"> <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la " required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>

        <!--  -->
        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Rol<span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <select class="formulario__input" id="telefono_Empresa">
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="rol 1">1</option>
                    <option value="rol 2">2</option>
                </select>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__">
            <label for="" class="formulario__label">Contraseña Provicional <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Contraseña Provicional" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Este campo solo debe contener letras</p>
        </div>

        <div class="formulario__mensaje" id="formulario__mensaje">
            <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
        </div>
        <div class="formulario__grupo formulario__grupo-btn-enviar">
            <button type="submit" class="formulario__btn">Guardar</button>
            <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
        </div>

    </form>

<script src="js/matricula/jquery-3.7.0.min.js"></script>
<!-- <script src="js/matricula/main.js"></script> -->
<?php
require 'footer.php';
?>