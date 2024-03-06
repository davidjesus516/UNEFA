<?php
require 'header.php';
?>
<span class="text">Carrera</span>
<div class="page-content">

    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>Codigo</th>
                <th>Carrera</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
    <br>
    <hr>
    <br>
    <form action="" class="formulario" id="formulario">
        <!-- Grupo: Usuario -->
        <input type="hidden" id="id">
        <div class="formulario__grupo" id="grupo__codigo">
            <label for="" class="formulario__label">Codigo</label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="codigo" placeholder="Ingrese el codigo de la carrera" required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
        </div>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__nombre">
            <label for="" class="formulario__label">Carrera</label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Carrera"required>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <div class="formulario__mensaje" id="formulario__mensaje">
            <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
        </div>

        <div class="formulario__grupo formulario__grupo-btn-enviar">
            <button type="submit" class="formulario__btn">Guardar</button>
            <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
        </div>
    </form>
</div>
<script src="js/carrera/jquery-3.7.0.min.js"></script>
<script src="js/carrera/main.js"></script>
<?php
require 'footer.php';
?>