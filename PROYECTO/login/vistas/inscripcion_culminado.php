<?php
require 'header.php';
?>
<span class="text">Ventana -> Pre inscripción -> Prácticas Culminadas</span>
<div class="page-content">
    <div id="modal" class="modal">
        <!-- El botón de "Nuevo" se elimina ya que esta vista es de solo consulta -->

        <dialog id="dialog">
            <h2>Consulta de Preinscripción.</h2>
            <form action="#" class="formulario" id="formulario">
                <!-- Todos los campos serán de solo lectura -->
                <input type="hidden" id="id_form" name="id_form">
                <input type="hidden" id="id_estudiante" name="id_estudiante">

                <!-- Grupo: Cédula -->
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="cedula" class="formulario__label">Cédula</label>

                    <div class="formulario__grupo-input formulario__grupo-cedula">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="nacionalidad" name="nacionalidad" readonly disabled>
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
                            readonly>
                    </div>

                    <!-- Estudiante -->
                    <div class="formulario__grupo" id="grupo__estudiante_nombre">
                        <label for="Estudiante" class="formulario__label">Estudiante</label>
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" id="Estudiante" placeholder="Estudiante" readonly>
                        </div>
                    </div>

                    <!-- Periodo -->
                    <div class="formulario__grupo">
                        <label for="periodo" class="formulario__label">Período</label>
                        <select id="periodo" name="periodo" class="formulario__input" readonly disabled>
                            <option value="" disabled selected>Seleccione una opción</option>
                        </select>
                    </div>

                    <!-- Tipo de Practica -->
                    <div class="formulario__grupo" id="grupo__tipo_practica">
                        <label for="tipo_practica" class="formulario__label">Tipo Práctica</label>
                        <div class="formulario__grupo-input">
                            <select class="formulario__input" name="tipo_practica" id="tipo_practica" readonly disabled>
                                <option value="" disabled selected>Seleccione una opción</option>
                            </select>
                        </div>
                    </div>

                    <!-- Matricula -->
                    <div class="formulario__grupo" id="grupo__matricula">
                        <label for="matricula" class="formulario__label">Matrícula</label>
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="matricula" id="matricula" placeholder="Matrícula" readonly>
                        </div>
                    </div>
            </form>
            <button type="button" onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para Aprobados/Reprobados -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('aprobados', event)">Aprobados</button>
        <button class="tab-button" onclick="cambiarTab('reprobados', event)">Reprobados</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de Pre Inscripciones Culminadas">
            <thead>
                <tr class="w3-light-grey">
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Período</th>
                    <th>Matrícula</th>
                    <th>Tipo Práctica</th>
                    <th>Fecha Culminación</th>
                    <th colspan="1">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-aprobados"></tbody>
            <tbody id="datos-reprobados" style="display: none;"></tbody>
        </table>
    </div>
    <a href="inscripcion_m.php" class="btn-link-responsables" style="margin: 1rem 0; display: inline-block;">
        Volver a Inscripciones
    </a>

</div>
<script src="js/jquery-3.7.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/inscripcion_culminada.js"></script>


<?php
require 'footer.php';
?>