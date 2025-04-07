<?php
require 'header.php';
?>
<span class="text">Matricula</span>
<div class="page-content">


	<div id="modal" class="modal">
		<button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

		<dialog id="dialog">
			<h2>Registrar Matricula.</h2>

			<form action="" class="formulario" id="formulario">
				<input type="hidden" id="id">

				<!-- Lapso  -->
				<div class="formulario__grupo" id="grupo__lapso">
					<label for="lapso" class="formulario__label">Lapso <span class="obligatorio">*</span></label>
					<select id="lapso" class="selector formulario__input" required>
						<option value="" disabled selected>Seleccione una opción</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
					<p class="formulario__input-error">Validacion</p>
				</div>

				<!-- Carrera -->

				<div class="formulario__grupo" id="grupo__carrera">
					<label for="carrera" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
					<select id="carrera" class="selector formulario__input" required>
						<option value="" disabled selected>Seleccione una opción</option>
						<option value="Ingeniería">Ingeniería</option>
						<option value="Medicina">Medicina</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
					<p class="formulario__input-error">Validacion</p>
				</div>

				<!-- Semestre -->

				<div class="formulario__grupo" id="grupo__semestre">
					<label for="semestre" class="formulario__label">Semestre <span class="obligatorio">*</span></label>
					<select id="semestre" class="selector formulario__input" required>
						<option value="" disabled selected>Seleccione una opción</option>
						<option value="semestre1">semestre1</option>
						<option value="semestre2">semestre2</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
					<p class="formulario__input-error">Validacion</p>
				</div>

				<!-- Seccion -->

				<div class="formulario__grupo">
					<label for="seccion" class="formulario__label">Seccion <span class="obligatorio">*</span></label>
					<div class="formulario__grupo-input">
						<input type="text" class="formulario__input" name="" id="" placeholder="Ingrese Lapso Académico">
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<p class="formulario__input-error">Validación</p>
				</div>

				<!-- Turno -->


				<div class="formulario__grupo" id="grupo__turno">
					<label for="turno" class="formulario__label">Turno <span class="obligatorio">*</span></label>
					<select id="turno" class="selector formulario__input" required>
						<option value="" disabled selected>Seleccione una opción</option>
						<option value="turno1">turno1</option>
						<option value="turno2">turno2</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
					<p class="formulario__input-error">Validacion</p>
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
			<th>Codigo Matricula</th>
			<th>Carrera</th>
			<th>Fecha Creacion</th>
			<th colspan="2">Acciones</th>
		</tr>
	</thead>
	<tbody id="datos"></tbody>
</table>


<script src="js/matricula/jquery-3.7.0.min.js"></script>
<script src="js/matricula/main.js"></script>
<?php
require 'footer.php';
?>