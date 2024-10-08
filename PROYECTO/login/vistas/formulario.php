<?php
require 'header.php';
?>
<span class="text">Formulario</span>
<div class="page-content">
	<form action="" class="formulario" id="formulario">
		<!-- Grupo: Usuario -->
		<div class="formulario__grupo" id="grupo__usuario">
			<label for="usuario" class="formulario__label">Usuario</label>
			<div class="formulario__grupo-input">
				<input type="text" class="formulario__input" name="usuario" id="usuario" placeholder="Ingrese su nombre de usuario">
				<i class="formulario__validacion-estado fas fa-times-circle"></i>
			</div>
			<p class="formulario__input-error">El usuario tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
		</div>

		<!-- Grupo: Nombre -->
		<div class="formulario__grupo" id="grupo__nombre">
			<label for="nombre" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input type="text" class="formulario__input" name="nombre" id="nombre" placeholder="Ingrese su nombre">
				<i class="formulario__validacion-estado fas fa-times-circle"></i>
			</div>
			<p class="formulario__input-error">El usuario tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
		</div>

		<!-- Grupo: Contraseña -->
		<div class="formulario__grupo" id="grupo__password">
			<label for="password" class="formulario__label">Contraseña</label>
			<div class="formulario__grupo-input">
				<input type="password" class="formulario__input" name="password" id="password">
				<i class="formulario__validacion-estado fas fa-times-circle"></i>
			</div>
			<p class="formulario__input-error">La contraseña tiene que ser de 4 a 12 dígitos.</p>
		</div>

		<!-- Grupo: Contraseña 2 -->
		<div class="formulario__grupo" id="grupo__password2">
			<label for="password2" class="formulario__label">Repetir Contraseña</label>
			<div class="formulario__grupo-input">
				<input type="password" class="formulario__input" name="password2" id="password2">
				<i class="formulario__validacion-estado fas fa-times-circle"></i>
			</div>
			<p class="formulario__input-error">Ambas contraseñas deben ser iguales.</p>
		</div>

		<!-- Grupo: Correo Electronico -->
		<div class="formulario__grupo" id="grupo__correo">
			<label for="correo" class="formulario__label">Correo Electrónico</label>
			<div class="formulario__grupo-input">
				<input type="email" class="formulario__input" name="correo" id="correo" placeholder="Ingrese su correo electronico">
				<i class="formulario__validacion-estado fas fa-times-circle"></i>
			</div>
			<p class="formulario__input-error">El correo solo puede contener letras, numeros, puntos, guiones y guion bajo.</p>
		</div>

		<!-- Grupo: Teléfono -->
		<div class="formulario__grupo" id="grupo__telefono">
			<label for="telefono" class="formulario__label">Teléfono</label>
			<div class="formulario__grupo-input">
				<input type="text" class="formulario__input" name="telefono" id="telefono" placeholder="Ingrese su numero telefonico">
				<i class="formulario__validacion-estado fas fa-times-circle"></i>
			</div>
			<p class="formulario__input-error">El telefono solo puede contener numeros y el maximo son 14 dígitos.</p>
		</div>

		<!-- Grupo: Terminos y Condiciones -->
		<div class="formulario__grupo" id="grupo__terminos">
			<label class="formulario__label">
				<input class="formulario__checkbox" type="checkbox" name="terminos" id="terminos">
				Acepto los Terminos y Condiciones
			</label>
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
<?php
require 'footer.php';
?>