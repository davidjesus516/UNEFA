<?php
require 'header.php';
?>

<span class="text">Tipos Práctica Profesional</span>
<div class="page-content">
    <div class="message"></div>
    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario para nuevo tipo de práctica">
            Nuevo +
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Tipo Práctica</h2>
            <form action="" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">
                <!-- Nombre de Práctica -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="nombre" class="formulario__label">Nombre Práctica <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nombre" id="nombre" placeholder="Ingrese el nombre de la práctica" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre debe contener entre 5 y 100 caracteres</p>
                </div>
                <!-- Prioridad -->
                <div class="formulario__grupo" id="grupo__prioridad">
                    <label for="prioridad" class="formulario__label">Prioridad <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" name="prioridad" id="prioridad" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Seleccione una prioridad válida</p>
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
        <button class="tab-button active" onclick="cambiarTab('activos', event)">Prácticas Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos', event)">Prácticas Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de prácticas">
            <thead>
                <tr class="w3-light-grey">
                    <th scope="col" class="sortable">Nombre</th>
                    <th scope="col" class="sortable">Prioridad</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display:none;"></tbody>
        </table>
    </div>
    <a href="carrera.php" class="btn-link-responsables" style="margin: 1rem 0; display: inline-block;">
        Volver a Carrera
    </a>
</div>
<style>
    /* Estilo para las acciones de los botones */
    .acciones-practica {
        display: flex;
        gap: 0.5rem;
        /* Espaciado entre los botones */
        justify-content: center;
        /* Centrar los botones horizontalmente */
    }

    .task-edit,
    .task-delete,
    .task-restore {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.7rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        /* transition: background 0.2s; */
    }

    .task-edit:hover {
        background: rgb(45, 42, 133);
    }

    .task-delete:hover {
        background: rgb(121, 11, 50);
    }

    .task-restore:hover {
        background: rgb(72, 173, 72);
    }

    .icon i {
        margin-left: 0.2rem;
    }
</style>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/tipo_practica.js"></script>

<?php
require 'footer.php';
?>