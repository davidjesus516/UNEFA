<?php require 'header.php';?>
<span class="text">Periodo</span>
<div class="page-content">

<button class="primary">Nuevo <span>+</span></button>
<div class="message"></div>
<div id="modal" class="modal">

    <dialog id="dialog" aria-labelledby="dialog-title">
        <h2 id="dialog-title">Registrar Periodo</h2>

        <form class="formulario" id="formulario" style="grid-auto-columns: auto;">
            <input type="hidden" id="PERIOD_ID" value="">

            <div class="formulario__grupo" id="grupo__lapso">
                <label class="formulario__label">Lapso Académico <span class="obligatorio">*</span></label>

                <div class="formulario__grupo-input formulario__grupo-combinado" style="gap: 0;">
                    <div class="formulario__input-combinado">
                        <select id="lapso-academico" class="formulario__input" required
                            style="border-radius: 4px 0 0 4px;">
                            <option value="" disabled selected>Año</option>
                            <!-- Opciones dinámicas -->
                        </select>
                    </div>

                    <div class="formulario__input-combinado">
                        <select id="turno" class="formulario__input" required
                            style="border-left: none; border-radius: 0 4px 4px 0;">
                            <option value="" disabled selected>Seleccionar opción</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                        </select>
                    </div>

                    <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
                </div>

                <p class="formulario__input-error">Seleccione año y turno válidos</p>
            </div>


            <div class="formulario__grupo">
                <label class="formulario__label">INICIO <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="date" class="formulario__input" id="periodo_inicio" required
                        aria-describedby="inicio-error">
                    <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
                </div>
                <p class="formulario__input-error" id="inicio-error">Seleccione una fecha válida</p>
            </div>

            <div class="formulario__grupo">
                <label class="formulario__label">FIN <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="date" class="formulario__input" id="periodo_fin" required
                        aria-describedby="fin-error">
                    <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
                </div>
                <p class="formulario__input-error" id="fin-error">Seleccione una fecha válida</p>
            </div>

            <div class="formulario__mensaje" id="formulario__mensaje" hidden>
                <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Complete el formulario correctamente</p>
            </div>

            <div class="formulario__grupo formulario__grupo-btn-enviar">
                <button type="submit" class="formulario__btn">Guardar</button>
                <p class="formulario__mensaje-exito" id="formulario__mensaje-exito" hidden>¡Registro exitoso!</p>
            </div>
        </form>

        <button onclick="window.dialog.close();" aria-label="Cerrar diálogo" class="x">❌</button>
    </dialog>
</div>

<!-- Pestañas para activos/inactivos -->
<div class="tabs">
    <button class="tab-button active" onclick="cambiarTabPeriodo('activos', event)">Períodos Activos</button>
    <button class="tab-button" onclick="cambiarTabPeriodo('inactivos', event)">Períodos Inactivos</button>
</div>

<!-- Tabla -->
<div class="table-container">
    <table class="w3-table-all w3-hoverable" aria-label="Listado de períodos">
        <thead>
            <tr class="w3-light-grey">
                <th>Descripción</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="datos-activos"></tbody>
        <tbody id="datos-inactivos" style="display: none;"></tbody>
    </table>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/periodo.js"></script>
<script>
    (function() {
        // Configuración de fechas
        const getCurrentDate = () => {
            const d = new Date();
            return new Date(d.getTime() - (d.getTimezoneOffset() * 60000))
                .toISOString()
                .split('T')[0];
        };

        // Llenar selector de años
        const initYearSelect = () => {
            const select = document.getElementById('lapso-academico');
            const currentYear = new Date().getFullYear();

            for (let i = 0; i <= 5; i++) {
                const option = document.createElement('option');
                option.value = currentYear + i;
                option.textContent = currentYear + i;
                select.appendChild(option);
            }
        };

        // Validación de fecha
        const setupDateValidation = () => {
            const currentDate = getCurrentDate();
            const $startDate = $('#periodo_inicio');

            $startDate.attr('min', currentDate).on('change', function() {
                const selectedDate = $(this).val();
                const $errorMsg = $(this).nextAll('.formulario__input-error');
                const $icon = $(this).siblings('.formulario__validacion-estado');

                if (selectedDate < currentDate) {
                    $errorMsg.show().text('No se permiten fechas anteriores');
                    $icon.removeClass('fa-check-circle').addClass('fa-times-circle');
                    $(this).val(currentDate).css('border-color', '#ff0000');
                } else {
                    $errorMsg.hide();
                    $icon.removeClass('fa-times-circle').addClass('fa-check-circle');
                    $(this).css('border-color', '#008f39');
                }

                // Actualizar fecha final
                if (selectedDate >= currentDate) {
                    const endDate = new Date(selectedDate);
                    endDate.setDate(endDate.getDate() + 112);
                    const endDateString = endDate.toISOString().split('T')[0];
                    $('#periodo_fin').val(endDateString).attr('min', endDateString);
                }
            });
        };

        // Inicialización
        document.addEventListener('DOMContentLoaded', initYearSelect);
        $(document).ready(setupDateValidation);
    })();
</script>

<?php
require 'footer.php';
?> 