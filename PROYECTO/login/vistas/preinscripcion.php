<?php
require 'header.php';
?>
<span class="text">Ventana -> Pre inscripción -> Agregar Práctica Profesional</span>
<div class="page-content">
    <div id="modal" class="modal">
        <button class="primary">Nuevo <span>+</span></button>

        <dialog id="dialog">
            <h2>Preinscripción.</h2>
            <form action="#" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form"> 
                <input type="hidden" id="reprobado_practice_id" name="reprobado_practice_id">
                <input type="hidden" id="id_estudiante" name="id_estudiante">

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
                            pattern="^\d{7,8}$"
                            title="Formato: V-12345678, E-12345678 o P-12345678"
                            minlength="7"
                            maxlength="8"
                            required>
                    </div>

                    <!-- Estudiante -->
                    <div class="formulario__grupo" id="grupo__estudiante_nombre">
                        <label for="Estudiante" class="formulario__label">Estudiante<span class="obligatorio">*</span></label>
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" id="Estudiante" placeholder="Estudiante" readonly>
                            <!-- The actual student ID is stored in the hidden input with id="id_estudiante" -->
                            <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
                        </div>
                        <p class="formulario__input-error">Validación</p>
                    </div>

                    <!-- Período -->
                    <div class="formulario__grupo">
                        <label for="periodo" class="formulario__label">Período <span class="obligatorio">*</span></label>
                        <select id="periodo" name="periodo" class="formulario__input" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="formulario__mensaje" id="formulario__mensaje">
                        <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellene el formulario correctamente.</p>
                    </div>

                    <!-- Tipo de Practica -->
                    <div class="formulario__grupo" id="grupo__tipo_practica">
                        <label for="telefono_Empresa" class="formulario__label">Tipo Práctica<span class="obligatorio">*</span></label>
                        <div class="formulario__grupo-input">
                            <select class="formulario__input" name="tipo_practica" id="tipo_practica" required>
                                <option value="" disabled selected>Cargando...</option> <!-- Options will be loaded dynamically by JS -->
                            </select>
                            <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
                        </div>
                        <p class="formulario__input-error">Validación</p>
                    </div>
                    <!-- <div class="formulario_grupo grupo__checkbox" id="grupo__checkbox">

                </div> -->
                    <!-- Matricula -->
                    <div class="formulario__grupo" id="grupo__matricula">
                        <label for="matricula" class="formulario__label">Matrícula <span class="obligatorio">*</span></label>
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="matricula" id="matricula" placeholder="Ingrese Matrícula" readonly>
                            <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
                        </div>
                        <p class="formulario__input-error">Validación</p>
                    </div>

                    <div class="formulario__mensaje" id="formulario__mensaje">
                        <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellene el formulario correctamente.</p>
                    </div>
                    <div class="formulario__grupo formulario__grupo-btn-enviar">
                        <button type="submit" class="formulario__btn">Guardar</button>
                        <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                    </div>
            </form>
            <button type="button" aria-label="close" class="x">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos')">Pre Inscripciones Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos')">Pre Inscripciones Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de Pre Inscripciones">
            <thead>
                <tr class="w3-light-grey">
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Período</th>
                    <th>Matrícula</th>
                    <th>Fecha Preinscripción</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display: none;"></tbody>
        </table>
    </div>

</div>
<script src="js/jquery-3.7.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/preinscripcion.js"></script>

<script>
        // Cerrar modal con el botón 'x'
        $('.x').on('click', function () {
        dialog.close();
    });
</script>
<?php
require 'footer.php';
?>