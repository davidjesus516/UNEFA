<?php
require 'header.php';
?>
<span class="text">Ventana -> <a href="seguimiento.php">Seguimiento</a> -> Registro de Visitas</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

        <dialog id="dialog">
            <h2>Registro de Visitas</h2>
            <form action="#" class="formulario" id="formulario">

                <!-- Campo Oculto para ID -->
                <input type="hidden" id="id_visita">

                <!-- Fecha y Hora -->
                <div class="formulario__grupo" id="grupo__fecha">
                    <label for="fecha" class="formulario__label">Fecha/Hora <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="datetime-local" class="formulario__input" name="fecha" id="fecha" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Seleccione una fecha válida</p>
                </div>

                <!-- Actividad Solicitada -->
                <div class="formulario__grupo" id="grupo__actividad_solicitada">
                    <label for="actividad_solicitada" class="formulario__label">Actividad Solicitada <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <textarea class="formulario__input formulario__textarea" name="actividad_solicitada" id="actividad_solicitada" placeholder="Detalle de la actividad solicitada" required rows="3"></textarea>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Máximo 255 caracteres</p>
                </div>

                <!-- Actividad Realizada -->
                <div class="formulario__grupo" id="grupo__actividad_realizada">
                    <label for="actividad_realizada" class="formulario__label">Actividad Realizada <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <textarea class="formulario__input formulario__textarea" name="actividad_realizada" id="actividad_realizada" placeholder="Detalle de la actividad realizada" required rows="3"></textarea>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Campo obligatorio</p>
                </div>

                <!-- Observación -->
                <div class="formulario__grupo" id="grupo__observacion">
                    <label for="observacion" class="formulario__label">Observación</label>
                    <div class="formulario__grupo-input">
                        <textarea class="formulario__input formulario__textarea" name="observacion" id="observacion" placeholder="Notas adicionales" rows="2"></textarea>
                    </div>
                </div>

                <!-- Motivo de Edición (Solo en modo edición) -->
                <div class="formulario__grupo" id="grupo__motivo_edicion" style="display: none;">
                    <label for="motivo_edicion" class="formulario__label">Motivo de Edición <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <textarea class="formulario__input formulario__textarea" name="motivo_edicion" id="motivo_edicion" placeholder="Describa el motivo de la edición" required rows="2"></textarea>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Debe especificar el motivo</p>
                </div>

                <!-- Mensajes y Botones -->
                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor complete todos los campos requeridos </p>
                </div>
                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Registro guardado exitosamente!</p>
                </div>
            </form>
            <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        </dialog>
    </div>

    <!-- Tabla de Registros -->
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>Fecha/Hora</th>
                <th>Actividad Solicitada</th>
                <th>Actividad Realizada</th>
                <th>Observación</th>
                <th>Tutor</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="datos-visitas">
            <!-- Datos se cargarán dinámicamente -->
            <tr>
                <td>2023-10-05 14:30</td>
                <td>Revisión de documentación</td>
                <td>Revisión completa de expediente</td>
                <td>Falta firma en página 3</td>
                <td>
                    <button class="task-delete ">
                        <spam class="texto">Borrar</spam><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
                            </svg></span>
                    </button>
                </td>
                <td>
                    <button class="task-edit" onclick="window.dialog.showModal();">
                        <spam class="texto">Editar</spam>
                        <spam class="icon"><svg viewBox="0 0 512 512">
                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                            </svg></spam>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script src="js/visitas/jquery-3.7.0.min.js"></script>
<script src="js/visitas/main.js"></script>
<script>
    document.querySelectorAll('.task-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('grupo__motivo_edicion').style.display = 'block';

            window.dialog.showModal();
        });
    });
</script>
<script>
    document.querySelectorAll('.primary').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('grupo__motivo_edicion').style.display = 'none';

            window.dialog.showModal();
        });
    });
</script>
<?php
require 'footer.php';
?>