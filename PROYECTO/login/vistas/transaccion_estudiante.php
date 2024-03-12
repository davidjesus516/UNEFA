<?php
require 'header.php';
?>
<span class="text">Transacción Estudiante</span>
<div class="page-content">

<div id="modal" class="modal">
    <button class="primary" onclick="window.dialog.showModal();">Nuevo</button>

    <dialog id="dialog">
        <h2>Registar Periodo.</h2>

        <form action="#" class="formulario" id="formulario">
            <!-- Grupo: Usuario -->
            <input type="hidden" id="id">

            <!-- Campo Núcleo -->
            <div class="formulario__grupo" id="grupo__nucleo">
                <label for="" class="formulario__label">Núcleo <span class="obligatorio">*</span></label>
                <select id="nucleo" aria-placeholder="nucleo" class="selector formulario__input" required name="tipo-extension">
                    <option value=""></option>
                </select>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                <p class="formulario__input-error">Validacion</p>
            </div>

                <!-- Campo Extensión -->
            <div class="formulario__grupo" id="grupo__extension">
                <label for="" class="formulario__label">Extensión <span class="obligatorio">*</span></label>
                <select id="extension" aria-placeholder="extension" class="selector formulario__input" required name="tipo-extension">
                    <option value=""></option>
                </select>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <!-- Campo Carrera -->
            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
                <select id="carrera" aria-placeholder="carrera" class="selector formulario__input" required>
                </select>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <!-- Campo Apellido -->
            <div class="formulario__grupo" id="grupo__apellido">
                <label for="" class="formulario__label">Apellido <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese la Apellido" required>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Este campo solo debe contener letras</p>
            </div>

            <!-- Campo Nombre  -->
            <div class="formulario__grupo" id="grupo__nombre">
                <label for="" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre" required>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Este campo solo debe contener letras</p>
            </div>

            <!-- Campo Cedula -->
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

            <!-- Campo Telefono -->
            <div class="formulario__grupo" id="grupo__telefono">
                <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="telefono" id="tlf" placeholder="Ingrese su numero telefonico">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">El telefono solo puede contener numeros y el maximo son 14 dígitos.</p>
            </div>

            <!-- Campo Correo -->
            <div class="formulario__grupo" id="grupo__correo">
                <label for="telefono" class="formulario__label">Correo <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electronico">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error"></p>
            </div>

            <!-- Campo Empresa/Institucion -->
            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Nombre de la Empresa <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Nombre de la Empresa">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <!-- Campo Tipo de Empresa -->
            <div class="formulario__grupo" id="grupo__tipo_empresa">
                <label for="" class="formulario__label">Tipo de Empresa <span class="obligatorio">*</span></label>
                <select id="tipo_empresa" aria-placeholder="tipo_empresa" class="selector formulario__input" required name="tipo-extension">
                    <option value="">Selecione una Opción</option>
                    <option value="">Pública</option>
                    <option value="">Privada</option>
                </select>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <br>

            <!-- Guardar -->
            <div class="formulario__mensaje" id="formulario__mensaje">
                <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
            </div>
            <div class="formulario__grupo formulario__grupo-btn-enviar">
                <button type="submit" class="formulario__btn">Guardar</button>
                <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
            </div>
            
            <div class="formulario__grupo formulario__grupo-btn-enviar">
                <button type="reset" class="formulario__btn">Limpiar</button>
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
                <th>Núcleo</th>
                <th>Extensión</th>
                <th>Carrera</th>
                <th>Apellidos y Nombres</th>
                <th>Cedula</th>
                <th>Numero de Telefono</th>
                <th>Correo</th>
                <th>Nombre de la Empresa o Institución</th>
                <th>Tipo de Empresa</th>
                <th colspan="2">Accion</th>
                <th></th>
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