<?php
require 'header.php';
?>
<span class="text">Responsable</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

        <dialog id="dialog">
            <h2>Registrar Responsable.</h2>

            <form action="#" class="formulario" id="formulario">
                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">

                <!-- Grupo: Cédula -->
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="cedula" class="formulario__label">Cédula <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-cedula">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="nacionalidad" name="nacionalidad" required>
                                <!-- <option value="" disabled selected>Nac.</option> -->
                                <option value="V">V-</option>
                                <option value="E">E-</option>
                                <option value="P">P-</option>
                            </select>
                        </div>

                        <input type="text"
                            class="formulario__input formulario__cedula-input"
                            name="cedula"
                            id="cedula"
                            placeholder="Ej: 12345678"
                            pattern="[VEP]-\d{1,8}"
                            maxlength="9"
                            required>

                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato válido: X-12345678</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Primer Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Segundo Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="grupo__apellido">
                    <label for="" class="formulario__label">Primer Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese la Apellido" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="grupo__apellido">
                    <label for="" class="formulario__label">Segundo Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese la Apellido" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Contacto -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select">
                                <option value="" selected>0412</option>
                                <option value="">0414</option>
                                <option value="">0416</option>
                                <option value="">0426</option>
                                <option value="">0255</option>
                            </select>
                        </div>

                        <input type="tel" class="formulario__input formulario__telefono-input" name="telefono" id="telefono" placeholder="(555) 000-000" pattern="\(\d{3}\) \d{3}-\d{4}" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato requerido: (XXX) XXX-XXXX</p>
                </div>

                <div class="formulario__grupo" id="grupo__correo">
                    <label for="telefono" class="formulario__label">Correo <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="email" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electronico">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
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
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Institucion</th>
            <th colspan="2">Accion</th>
        </tr>
    </thead>
    <tbody id="datos"></tbody>
</table>
</div>
<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<script src="js/estudiante/main.js"></script>
<?php
require 'footer.php';
?>