<?php
require 'header.php';
?>
<span class="text">Matricula</span>
<div class="page-content">


<div id="modal" class="modal">
	<button class="primary" onclick="window.dialog.showModal();">Nuevo</button>

	<dialog id="dialog">
		<h2>Registrar matricula.</h2>

		<form action="" class="formulario" id="formulario">
			<input type="hidden" id="id">

            <!-- Grupo: Carrera -->
            <div class="formulario__grupo">
            <label for="carrera" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
            <select class="formulario__grupo-input formulario__input" name="carrera" id="carrera" multiple>
                <option value="ingenieria">Ingeniería</option>
                <option value="medicina">Medicina</option>
                <option value="derecho">Derecho</option>
                <option value="arquitectura">Arquitectura</option>
                <option value="psicologia">Psicología</option>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </select>
            <p class="formulario__input-error">Validación</p>
            </div>


			<!-- Grupo: Usuario -->
			<div class="formulario__grupo" id="">
			<label for="" class="formulario__label">INICIO <span class="obligatorio">*</span></label>
			<div class="formulario__grupo-input">
				<input type="date" class="formulario__input" name="" id="matricula" placeholder="Ingrese el codigo del nuevo matricula">
				<i class="formulario__validacion-estado fas fa-times-circle"></i>
			</div>
			<p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
			</div>

			<div class="formulario__grupo" id="">
			<label for="" class="formulario__label">FIN <span class="obligatorio">*</span></label>
			<div class="formulario__grupo-input">
				<input type="date" class="formulario__input" name="" id="matricula" placeholder="Ingrese el codigo del nuevo matricula">
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


<script src="js/matricula/jquery-3.7.0.min.js"></script>    
<script src="js/matricula/main.js"></script>
<?php
require 'footer.php';
?>
