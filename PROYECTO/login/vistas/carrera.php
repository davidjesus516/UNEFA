<?php
require 'header.php';
?>

<style>
    .icon {
        margin-top: 13px;
    }
</style>
<span class="text">Carrera</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Nuevo</button>

        <dialog id="dialog">
            <h2>Registrar Carrera.</h2>

            <form action="" class="formulario" id="formulario">
                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">
                <div class="formulario__grupo" id="grupo__codigo">
                    <label for="" class="formulario__label">Codigo <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="codigo" placeholder="Ingrese el codigo de la carrera" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Carrera" required>
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
            <th>Codigo</th>
            <th>Carrera</th>
            <th colspan="2">Acciones</th>
        </tr>
    </thead>
    <tbody id="datos"></tbody>
</table>

</div>
<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/carrera.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dialog = document.getElementById("dialog");
        const closeButton = document.querySelector("#dialog .x");
        const formulario = document.getElementById("formulario");

        closeButton.addEventListener("click", function() {
            // Cerrar el modal
            dialog.close();

            // Limpiar todos los campos del formulario
            formulario.reset();

            // Ocultar mensajes de error
            const errores = formulario.querySelectorAll(".formulario__input-error");
            errores.forEach(error => error.style.display = "none");

            // Ocultar mensaje de éxito
            const mensajeExito = document.getElementById("formulario__mensaje-exito");
            if (mensajeExito) {
                mensajeExito.style.display = "none";
            }

            // Ocultar mensaje general de error
            const mensajeError = document.getElementById("formulario__mensaje");
            if (mensajeError) {
                mensajeError.style.display = "none";
            }

            // Resetear estilos de validación (iconos y bordes)
            const inputs = formulario.querySelectorAll(".formulario__input");
            inputs.forEach(input => {
                input.classList.remove("formulario__input--incorrecto", "formulario__input--correcto");
            });

            // Ocultar iconos de validación
            const iconosValidacion = formulario.querySelectorAll(".formulario__validacion-estado");
            iconosValidacion.forEach(icono => {
                icono.style.display = "none";
            });
        });
    });
</script>



<?php
require 'footer.php';
?>