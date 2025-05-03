<?php
require 'header.php';
?>
<span class="text">Matrícula</span>
<div class="page-content">

	<div id="modal-matricula" class="modal">
		<button class="primary" id="abrir-modal-matricula">Nuevo <span>+</span></button>

		<dialog id="dialog-matricula" aria-labelledby="titulo-modal-matricula">
			<h2 id="titulo-modal-matricula">Registrar Matrícula</h2>

			<form class="formulario" id="formulario-matricula">
				<input type="hidden" id="id-matricula">

				<div class="formulario__grupo">
					<label for="lapso-matricula" class="formulario__label">Lapso <span class="obligatorio">*</span></label>
					<select id="lapso-matricula" class="formulario__input" required aria-describedby="error-lapso">
						<option value="" disabled selected>Seleccione un lapso</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle" aria-hidden="true"></i>
					<p id="error-lapso" class="formulario__input-error" hidden>Seleccione un lapso válido</p>
				</div>

				<div class="formulario__grupo">
					<label for="carrera-matricula" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
					<select id="carrera-matricula" class="formulario__input" required aria-describedby="error-carrera">
						<option value="" disabled selected>Seleccione una carrera</option>
						<option value="Ingeniería">Ingeniería</option>
						<option value="Medicina">Medicina</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle" aria-hidden="true"></i>
					<p id="error-carrera" class="formulario__input-error" hidden>Seleccione una carrera válida</p>
				</div>

				<div class="formulario__grupo">
					<label for="semestre-matricula" class="formulario__label">Semestre <span class="obligatorio">*</span></label>
					<select id="semestre-matricula" class="formulario__input" required aria-describedby="error-semestre">
						<option value="" disabled selected>Seleccione un semestre</option>
						<option value="semestre1">Semestre 1</option>
						<option value="semestre2">Semestre 2</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle" aria-hidden="true"></i>
					<p id="error-semestre" class="formulario__input-error" hidden>Seleccione un semestre válido</p>
				</div>

				<div class="formulario__grupo">
					<label for="seccion-matricula" class="formulario__label">Sección <span class="obligatorio">*</span></label>
					<div class="formulario__grupo-input">
						<input type="text" class="formulario__input" id="seccion-matricula"
							placeholder="Ej: A-2023" required aria-describedby="error-seccion">
						<i class="formulario__validacion-estado fas fa-times-circle" aria-hidden="true"></i>
					</div>
					<p id="error-seccion" class="formulario__input-error" hidden>Ingrese una sección válida</p>
				</div>

				<div class="formulario__grupo">
					<label for="turno-matricula" class="formulario__label">Turno <span class="obligatorio">*</span></label>
					<select id="turno-matricula" class="formulario__input" required aria-describedby="error-turno">
						<option value="" disabled selected>Seleccione un turno</option>
						<option value="Diurno">Diurno</option>
						<option value="Nocturno">Nocturno</option>
					</select>
					<i class="formulario__validacion-estado fas fa-times-circle" aria-hidden="true"></i>
					<p id="error-turno" class="formulario__input-error" hidden>Seleccione un turno válido</p>
				</div>

				<div class="formulario__grupo formulario__grupo-btn-enviar">
					<button type="submit" class="formulario__btn">Guardar</button>
					<p class="formulario__mensaje-exito" id="mensaje-exito-matricula" hidden>¡Matrícula registrada!</p>
				</div>
			</form>

			<button id="cerrar-modal-matricula" aria-label="Cerrar formulario de matrícula" class="x">❌</button>
		</dialog>
	</div>

	<table class="w3-table-all w3-hoverable" aria-label="Listado de matrículas">
		<thead>
			<tr class="w3-light-grey">
				<th scope="col">Código</th>
				<th scope="col">Carrera</th>
				<th scope="col">Fecha Creación</th>
				<th scope="col" colspan="2">Acciones</th>
			</tr>
		</thead>
		<tbody id="lista-matriculas"></tbody>
	</table>

	<script src="js/matricula/jquery-3.7.0.min.js"></script>
	<script>
		(function() {
			// Control del modal
			const dialog = document.getElementById('dialog-matricula');
			document.getElementById('abrir-modal-matricula').addEventListener('click', () => dialog.showModal());
			document.getElementById('cerrar-modal-matricula').addEventListener('click', () => dialog.close());

			// Validación del formulario
			document.getElementById('formulario-matricula').addEventListener('submit', (e) => {
				e.preventDefault();
				const formularioValido = validarFormulario();

				if (formularioValido) {
					enviarFormulario();
				}
			});

			function validarFormulario() {
				let valido = true;

				// Validar cada campo
				const campos = [{
						id: 'lapso-matricula',
						error: 'error-lapso'
					},
					{
						id: 'carrera-matricula',
						error: 'error-carrera'
					},
					{
						id: 'semestre-matricula',
						error: 'error-semestre'
					},
					{
						id: 'seccion-matricula',
						error: 'error-seccion'
					},
					{
						id: 'turno-matricula',
						error: 'error-turno'
					}
				];

				campos.forEach(({
					id,
					error
				}) => {
					const campo = document.getElementById(id);
					const mensajeError = document.getElementById(error);

					if (!campo.value.trim()) {
						mostrarError(campo, mensajeError);
						valido = false;
					} else {
						ocultarError(campo, mensajeError);
					}
				});

				return valido;
			}

			function mostrarError(campo, mensaje) {
				campo.classList.add('input-error');
				campo.nextElementSibling.classList.add('icono-error-visible');
				mensaje.hidden = false;
			}

			function ocultarError(campo, mensaje) {
				campo.classList.remove('input-error');
				campo.nextElementSibling.classList.remove('icono-error-visible');
				mensaje.hidden = true;
			}

			function enviarFormulario() {
				// Lógica de envío AJAX aquí
				document.getElementById('mensaje-exito-matricula').hidden = false;
				setTimeout(() => dialog.close(), 1500);
			}
		})();
	</script>

	<?php
	require 'footer.php';
