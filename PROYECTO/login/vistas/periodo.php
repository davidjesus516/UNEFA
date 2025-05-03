<?php
require 'header.php';
?>
<span class="text">Periodo</span>
<div class="page-content">


	<div id="modal" class="modal">
		<button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

		<dialog id="dialog">
			<h2>Registrar Periodo.</h2>

			<form action="" class="formulario" id="formulario">
				<input type="hidden" id="id">

				<!-- Grupo:  -->
				<div class="formulario__grupo">
					<label class="formulario__label">Lapso Académico <span class="obligatorio">*</span></label>
					<div class="formulario__grupo-input">
						<!-- Select dinámico de años -->
						<select id="lapso-academico" class="formulario__input" required>
							<option value="" disabled selected>Seleccione el año</option>
						</select>

						<!-- Select existente de Turno -->
						<select style="width: 8rem;" id="turno" class="selector formulario__input" required>
							<option value="" disabled selected>Turno</option>
							<option value="I">I</option>
							<option value="II">II</option>
						</select>
					</div>
					<p class="formulario__input-error">Validación</p>
				</div>

				<br>

				<!-- Grupo: Usuario -->
				<div class="formulario__grupo" id="">
					<label for="" class="formulario__label">INICIO <span class="obligatorio">*</span></label>
					<div class="formulario__grupo-input">
						<input type="date" class="formulario__input" name="" id="periodo_inicio" placeholder="Ingrese el codigo del nuevo periodo">
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
				</div>

				<div class="formulario__grupo" id="">
					<label for="" class="formulario__label">FIN <span class="obligatorio">*</span></label>
					<div class="formulario__grupo-input">
						<input type="date" class="formulario__input" name="" id="periodo_fin" placeholder="Ingrese el codigo del nuevo periodo">
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
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
			<th>Lapso Academico</th>
			<th>Inicio</th>
			<th>Fin</th>
			<th>Estatus</th>
			<th colspan="2">Acciones</th>
		</tr>
	</thead>
	<tbody id="datos"></tbody>
</table>


<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/periodo.js"></script>
<script>
	function llenarLapsoAcademico() {
		const select = document.getElementById("lapso-academico");
		const añoActual = new Date().getFullYear();

		for (let i = 0; i <= 5; i++) {
			const año = añoActual + i;
			const option = document.createElement("option");
			option.value = año;
			option.textContent = año;
			select.appendChild(option);
		}
	}

	// Ejecuta al cargar la página
	document.addEventListener("DOMContentLoaded", llenarLapsoAcademico);
	$(document).ready(function() {
    // Función para obtener fecha actual en formato YYYY-MM-DD
    const getCurrentDate = () => {
        const d = new Date();
        return new Date(d.getTime() - (d.getTimezoneOffset() * 60000)) // Compensar zona horaria
               .toISOString()
               .split('T')[0];
    };

    // Establecer fecha mínima inicial
    const currentDate = getCurrentDate();
    $('#periodo_inicio').attr('min', currentDate);

    $('#periodo_inicio').on('change', function() {
        const selectedDate = $(this).val();
        const inputGroup = $(this).closest('.formulario__grupo');
        const errorMessage = inputGroup.find('.formulario__input-error');
        const errorIcon = inputGroup.find('.formulario__validacion-estado');

        // Comparación directa de strings YYYY-MM-DD
        if (selectedDate < currentDate) {
            // Mostrar error
            errorMessage.text('No se puede seleccionar una fecha anterior a la actual').show();
            errorIcon.removeClass('fa-check-circle').addClass('fa-times-circle');
            $(this).css('border-color', '#ff0000');
            $(this).val(currentDate); // Resetear a fecha actual
        } else {
            // Ocultar error
            errorMessage.hide();
            errorIcon.removeClass('fa-times-circle').addClass('fa-check-circle');
            $(this).css('border-color', '#008f39');
        }

        // Actualizar fecha fin
        if (selectedDate >= currentDate) {
            const startDate = new Date(selectedDate);
            const endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + 112); // 16 semanas exactas (16×7=112 días)
            
            const endDateString = endDate.toISOString().split('T')[0];
            $('#periodo_fin').val(endDateString).attr('min', endDateString);
        }
    });
});
</script>


<?php
require 'footer.php';
?>