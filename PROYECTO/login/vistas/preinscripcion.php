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

                <!-- Periodo -->
                <div class="formulario__grupo">
                    <label for="periodo" class="formulario__label">Periodo <span class="obligatorio">*</span></label>
                    <select id="periodo" name="periodo" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                </div>
                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
                </div>

                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="cedula" class="formulario__label">CI Estudiante <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" maxlength="8" class="formulario__input" name="cedula" id="cedula" placeholder="Ingrese la Cedula" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>

                <!-- Grupo: Nombre -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="nombre" class="formulario__label">Estudiante <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nombre" id="nombre" placeholder="Estudiante" required readonly>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Tipo de Practica -->
                <div class="formulario__grupo" id="grupo__tipo_practica">
                    <label for="telefono_Empresa" class="formulario__label">Tipo de Practica<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" name="telefono_Empresa" id="telefono_Empresa">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Hospitalaria">Hospitalaria</option>
                            <option value="Comunitaria">Comunitaria</option>
                            <option value="Ordinaria">Ordinaria</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>
                <!-- <div class="formulario_grupo grupo__checkbox" id="grupo__checkbox">

                </div> -->
                <!-- Matricula -->
                <div class="formulario__grupo" id="grupo__matricula">
                    <label for="matricula" class="formulario__label">Matricula <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="matricula" id="matricula" placeholder="Ingrese Matricula" readonly>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!-- Documentos -->
                <div class="formulario__grupo" id="grupo__documentos">
                    <label class="formulario__label">Documentos <span class="obligatorio">*</span></label>
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
            <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        </dialog>
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

<?php
require 'footer.php';
?>