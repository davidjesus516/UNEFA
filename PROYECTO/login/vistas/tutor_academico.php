<?php
require 'header.php';
?>
<span class="text">Tutor Academico</span>
<div class="page-content">

<style></style>
    
<div id="modal" class="modal">
	<button class="primary" onclick="window.dialog.showModal();">Nuevo</button>

	<dialog id="dialog">
		<h2>Registrar Tutor Academico.</h2>

		<form action="#" class="formulario" id="formulario">
            <input type="hidden" id="id">
                <!-- Grupo: Usuario -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Cedula <span class="obligatorio">*</span></label>
                    <select id="nacionalidad" class="formulario__input cedula" name="tipo-cedula">
                        <option value="V">V-</option>
                        <option value="E">E-</option>
                        <option value="P">P-</option>
                    </select>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input cedula" name="" id="cedula" placeholder="Ingrese la Cedula">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese la Apellido">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Genero <span class="obligatorio">*</span></label>
                    <select id="genero" aria-placeholder="Genero" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Prefiero no decirlo</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="grupo__">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="telefono" id="tlf" placeholder="Ingrese su numero telefonico">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El telefono solo puede contener numeros y el maximo son 14 dígitos.</p>
                </div>

                <div class="formulario__grupo" id="grupo__">
                    <label for="telefono" class="formulario__label">Correo <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electronico">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
                    <select id="carrera" aria-placeholder="carrera" class="selector formulario__input" required>
                    
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
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
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Genero</th>
                <th>Telefono</th>
                <th>Correo Electronico</th>
                <th>Carrera que imparte</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
    <br>
    <hr>
    <br>
    <form action="#" class="formulario" id="formulario">
    <input type="hidden" id="id">
        <!-- Grupo: Usuario -->
        <div class="formulario__grupo" id="grupo__cedula">
            <label for="" class="formulario__label">Cedula <span class="obligatorio">*</span></label>
            <select id="nacionalidad" class="formulario__input" name="tipo-cedula">
                <option value="V">V-</option>
                <option value="E">E-</option>
                <option value="P">P-</option>
            </select>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="cedula" placeholder="Ingrese la Cedula">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
        </div>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="grupo__nombre">
            <label for="" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <div class="formulario__grupo" id="#grupo__apellido">
            <label for="" class="formulario__label">Apellido <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese la Apellido">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Genero <span class="obligatorio">*</span></label>
            <select id="genero" aria-placeholder="Genero" class="selector formulario__input" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Prefiero no decirlo</option>
            </select>
            <i class="formulario__validacion-estado fas fa-times-circle"></i>
            <p class="formulario__input-error">Validacion</p>
        </div>

          <div class="formulario__grupo" id="grupo__telefono">
            <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="telefono" id="tlf" placeholder="Ingrese su numero telefonico">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">El telefono solo puede contener numeros y el maximo son 14 dígitos.</p>
        </div>

        <div class="formulario__grupo" id="grupo__correo">
            <label for="telefono" class="formulario__label">Correo <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="email" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electronico">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error"></p>
        </div>

        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
            <select id="carrera" aria-placeholder="carrera" class="selector formulario__input" required>
            </select>
            <i class="formulario__validacion-estado fas fa-times-circle"></i>
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
</div>
<script src="js/tutor_academico/jquery-3.7.0.min.js"></script>
<script src="js/tutor_academico/main.js"></script>    
<?php
require 'footer.php';
?>