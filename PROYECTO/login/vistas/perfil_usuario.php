<?php
require 'header.php';
?>
<input type="hidden" id="name" name="name" value=<?php echo $_SESSION["NAME"]; ?>>
<input type="hidden" id="id" name="id" value=<?php echo $_SESSION["USER"]; ?>>

<span class="text">Perfil de Usuario</span>
<div class="page-content">
    <h1>Mi Cuenta</h1>
    <br>
    <h5 id="name">Nombre</h5>
    <p id="name_user"><?php echo $_SESSION["NAME"]; ?></p>
    <p id="name_user"><?php echo $_SESSION["USER"]; ?></p>

    <br>

    <h5>Información Personal</h5>
    <p>Nombre Completo</p>
    <h5 id=""></h5>
    <p>Correo Electronico</p>
    <h5 id=""></h5>
    <p>Número de Telefono</p>
    <h5 id=""></h5>

    <div id="modal" class="modal">
        <button class="secundario" onclick="window.dialog.showModal();">Editar Información de Usuario</button>

        <dialog id="dialog">
            <h2>Editar Usuario</h2>

            <form action="#" class="formulario" id="formulario">
                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">

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
                    <label for="" class="formulario__label">Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese la Apellido" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="grupo__correo">
                    <label for="telefono" class="formulario__label">Correo <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="email" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electronico">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>

                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="telefono" id="tlf" placeholder="Ingrese su numero telefonico">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El telefono solo puede contener numeros y el maximo son 14 dígitos.</p>
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
    <!-- <script src="js/estudiante/jquery-3.7.0.min.js"></script> -->
    <!-- <script src="js/perfil/main.js"></script> -->
    <?php
    require 'footer.php';
    ?>