<?php
require 'header.php';
?>
<span class="text">Ventana -> Pre Inscripcion -> Agregar Practica Profesional</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

        <dialog id="dialog">
            <h2>Pre Inscripcion.</h2>
            <form action="#" class="formulario" id="formulario">

                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">
                <div class="formulario__grupo" id="grupo__periodo">
                    <label for="" class="formulario__label">Periodo<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="num" maxlength="8" class="formulario__input" name="" id="periodo" placeholder="Periodo" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="" class="formulario__label">CI Estudiante <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input">
                        <input type="text" maxlength="8" class="formulario__input" name="" id="cedula" placeholder="Ingrese la Cedula" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>


                <!-- Grupo: Usuario -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Estudiante <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Estudiante" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Tipo de Practica<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="telefono_Empresa">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Hospitalaria">Hospitalaria</option>
                            <option value="Comunitaria">Comunitaria</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>
                
                <!-- Lapso  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Matricula <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese Matricula">
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
<table class="w3-table-all w3-hoverable">
    <thead>
        <tr class="w3-light-grey">
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Sexo</th>
            <th>Contacto</th>
            <th>Carrera</th>
            <th colspan="2">Acciones</th>
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