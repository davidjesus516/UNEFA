<?php
require 'header.php';
?>

<span class="text">Ventana -> <a href="usuario.php">Configuración</a> -> Preguntas Preestablecida</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Agregar +</button>

        <dialog id="dialog">
            <h2>Agregar Preguntas Preestablecida</h2>

            <form action="" class="formulario" id="formulario">
                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">
                <div class="formulario__grupo" id="grupo__pregunta">
                    <label for="" class="formulario__label">¿Cuál es la Pregunta Preestablecida?<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="pregunta" placeholder="Ingrese el pregunta preestablecida" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>

            <!-- <p>You can also change the styles of the <code>::backdrop</code> from the CSS.</p> -->
            <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        </dialog>
    </div>
</div>

<br>
<hr>
<br>
<table class="w3-table-all w3-hoverable">
    <thead>
        <tr class="w3-light-grey">
            <th>Pregunta Preestablecida</th>
            <th>Fecha de Creación</th>
            <th colspan="2">Acciones</th>
        </tr>
    </thead>
    <tbody id="datos"></tbody>
</table>

</div>
<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/preguntas.js"></script>

<?php
require 'footer.php';
?>