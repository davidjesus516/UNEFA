<?php
require 'header.php';
?>
<style>
    .custom-select-container {
        position: relative;
        font-family: Arial, sans-serif;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: white;
        cursor: pointer;
        min-height: 38px;
        /* Ajustar según la altura de tus inputs */
        display: flex;
        align-items: center;
    }

    .custom-select-options,
    .custom-select-container:hover {
        border-end-end-radius: 0;
    }

    .custom-select-selected {
        padding: 8px 10px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 100%;
        color: #555;
        /* Color de placeholder */
        padding-right: 30px;
        /* Espacio para el icono de flecha */
    }

    .custom-select-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 4px 4px;
        background-color: white;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        scale: 1.006;

    }

    .custom-select-options .option-item {
        padding: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .custom-select-options .option-item:hover {
        background-color: #f0f0f0;
    }

    .custom-select-options .option-item input[type="checkbox"] {
        margin-right: 8px;
    }

    .custom-select-arrow {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        /* Para que el icono no interfiera con el click */
        color: #888;
    }
</style>

<span class="text">Carrera</span>
<div class="page-content">
    <div class="message"></div>
    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario para nueva carrera">
            Nuevo +
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Carrera</h2>
            <form action="" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">
                <!-- Código de Carrera -->
                <div class="formulario__grupo" id="grupo__codigo">
                    <label for="codigo" class="formulario__label">Código <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="codigo" id="codigo" placeholder="Ingrese el código de la carrera">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El código debe contener entre 3 y 10 caracteres alfanuméricos</p>
                </div>
                <!-- Nombre de Carrera -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="nombre" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nombre" id="nombre" placeholder="Ingrese el nombre de la carrera" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre debe contener entre 5 y 100 caracteres</p>
                </div>
                <!-- Nota Mínima -->
                <div class="formulario__grupo" id="grupo__nota">
                    <label for="nota" class="formulario__label">Nota Mínima<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="number" class="formulario__input" name="nota" id="nota" placeholder="Nota mínima aprobatoria" min="0" max="20" step="0.01" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">La nota debe estar entre 0 y 20</p>
                </div>
                <!-- Abreviatura -->
                <div class="formulario__grupo" id="grupo__abreviatura">
                    <label for="abreviatura" class="formulario__label">Abreviatura <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="abreviatura" id="abreviatura" placeholder="Ej: TSU-E, ING-S" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">La abreviatura es requerida (max 15 caracteres)</p>
                </div>
                <!-- Tipos de Pasantías (Checkboxes) -->
                <div class="formulario__grupo" id="grupo__tipos_pasantias">
                    <label class="formulario__label"><a href="tipo_practica.php">Tipos Práctica Profesional</a></label>
                    <div class="formulario__grupo-checkbox" id="checkbox_container">
                        <!-- Se llenará dinámicamente con JS -->
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
            <button onclick="window.dialog.close();" class="x" aria-label="Cerrar formulario">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos', event)">Carreras Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos', event)">Carreras Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de carreras">
            <thead>
                <tr class="w3-light-grey">
                    <th scope="col" class="sortable">Código</th>
                    <th scope="col" class="sortable">Carrera</th>
                    <th scope="col" class="sortable">Nota Mínima</th>
                    <th scope="col" class="sortable">Abreviatura</th>
                    <th scope="col" colspan="3" id="acciones-header">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display:none;"></tbody>
        </table>
    </div>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/carrera.js"></script>


<?php
require 'footer.php';
?>