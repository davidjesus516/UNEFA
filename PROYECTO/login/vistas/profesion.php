<?php
require 'header.php';
?>
<span class="text">Profesión</span>
<div class="page-content">


<div id="modal" class="modal">
	<button class="primary" onclick="window.dialog.showModal();">Nuevo</button>

	<dialog id="dialog">
		<h2>Registrar Profesión.</h2>

        <form action="" class="formulario" id="formulario">
            <input type="hidden" id="id">
            <!-- Grupo: Usuario -->
            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Codigo <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese el codigo de la Profesión">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>

            <!-- Grupo:  -->
            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Profesión <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Profesión">
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
                <th>Profesión</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
    
</div>
<script src="js/profesion/jquery-3.7.0.min.js"></script>    
<script src="js/profesion/main.js"></script>    
<?php
require 'footer.php';
?>