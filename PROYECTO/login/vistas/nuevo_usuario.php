<?php
require 'header.php';
?>
<span class="text">Ventana -> <a href="usuario.php">Configuración</a> -> Nuevo Usuario</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

        <dialog id="dialog">
            <h2>Registrar Usuario.</h2>

            <form action="#" class="formulario" id="formulario">
                <!-- Grupo: Usuario -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Nombre Usuario <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese el Nombre de Usuario" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese el Nombre" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Rol<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="telefono_Empresa">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="rol 1">1</option>
                            <option value="rol 2">2</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Contraseña Provicional <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Contraseña Provicional" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
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
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
</div>
</div>
<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<script src="js/estudiante/main.js"></script>
<?php
require 'footer.php';
?>