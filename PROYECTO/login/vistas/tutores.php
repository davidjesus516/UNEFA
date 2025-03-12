<?php
require 'header.php';
?>
<span class="text">Tutores</span>
<div class="page-content">



<div id="modal" class="modal">
    <button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

    <dialog id="dialog">
        <h2>Registrar Tutor.</h2>

            <form action="#" class="formulario" id="formulario">
                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="" class="formulario__label">Cedula <span class="obligatorio">*</span></label>
                    <select id="nacionalidad" class="formulario__input" name="tipo-cedula">
                        <option value="V">V-</option>
                        <option value="E">E-</option>
                        <option value="P">P-</option>
                    </select>
                    <div class="formulario__grupo-input">
                        <input type="text" maxlength="8" class="formulario__input" name="" id="cedula" placeholder="Ingrese la Cedula"required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Primer Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre"required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Segundo Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre"required>
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

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Sexo <span class="obligatorio">*</span></label>
                    <select id="sexo" aria-placeholder="sexo" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Masculino</option>
                        <option value="">Femenino</option>
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
                    <label for="" class="formulario__label">Condicion <span class="obligatorio">*</span></label>
                    <select id="condicion" aria-placeholder="condicion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Dedicacion<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Categoria<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Profesion<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Matricula<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Nucleo<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
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
                <th>Cédula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Profesion</th>
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