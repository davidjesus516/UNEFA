<?php
require 'header.php';
?>
<span class="text">Ventana -> Inscripcion</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

        <dialog id="dialog">
            <h2>Inscripcion.</h2>
            <form action="#" class="formulario" id="formulario">

                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="" class="formulario__label">Cedula <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="cedula" placeholder="Cedula del estudiante" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener numeros</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Estudiante<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="">
                            <option value="">seleccione una opcion</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Tutor Academico<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="">
                            <option value="">seleccione una opcion</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Tutor Metodologico<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="">
                            <option value="">seleccione una opcion</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Institucion<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="">
                            <option value="">seleccione una opcion</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Responsable Institucion<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="">
                            <option value="">seleccione una opcion</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Documentos <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="radio" name="documentos" id="entregado" value="entregado" required>
                        <label for="entregado">Entregado</label>
                        <br>
                        <input type="radio" name="documentos" id="no-entregado" value="no-entregado" required>
                        <label for="no-entregado">No Entregado</label>
                    </div>
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
</div>
<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<script src="js/estudiante/main.js"></script>
<?php
require 'footer.php';
?>