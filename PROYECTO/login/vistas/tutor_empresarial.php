<?php
require 'header.php';
?>
<span class="text">Tutor Empresarial</span>
<div class="page-content">


<div id="modal" class="modal">
    <button class="primary" onclick="window.dialog.showModal();">Nuevo</button>

    <dialog id="dialog">
        <h2>Registrar Tutor Empresarial.</h2>


        <form action="" class="formulario" id="formulario">
            <!-- Grupo: Usuario -->
            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Cedula <span class="obligatorio">*</span></label>
                <select id="" class="formulario__input" name="tipo-cedula">
                    <option value="">V-</option>
                    <option value="">E-</option>
                    <option value="">P-</option>
                </select>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Cedula">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
            </div>

            <!-- Grupo:  -->
            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Nombre">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Apellido <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Apellido">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Género <span class="obligatorio">*</span></label>
                <select id="genero" aria-placeholder="Genero" class="selector formulario__input" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="Hombre">Hombre</option>
                    <option value="Mujer">Mujer</option>
                    <option value="Otro">Prefiero no decirlo</option>
                </select>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Dirección <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Dirección">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Profesión <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <select id="profesion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Validacion</p>
            </div>

            <div class="formulario__grupo" id="">
                <label for="" class="formulario__label">Empresa <span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <select id="empresa" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una Empresa</option>>
                    </select>
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
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Género</th>
                <th>Dirección</th>
                <th>Profesión</th>
                <th>Empresa</th>
                <th colspan="2">Accion</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>

</div>
<script src="js/tutor_empresarial/jquery-3.7.0.min.js"></script>
<script src="js/tutor_empresarial/main.js"></script>    
<?php
require 'footer.php';
?>