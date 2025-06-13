<?php
require 'header.php';
?>
<span class="text">Gestión de Listas y Valores</span>
<div class="page-content">

    <div class="modal">
        <dialog id="respuesta-modal"></dialog>
    </div>

    <!-- Modal para Listas -->
    <div id="list-modal" class="modal">


        <dialog id="list-dialog">
            <h2>Registrar Nueva Lista</h2>


            <form action="" class="formulario" id="list_form">

                <!-- Campo oculto para ID -->
                <input type="hidden" id="list_id" name="list_id">

                <!-- Grupo: Nombre de Lista -->
                <div class="formulario__grupo" id="grupo__nombre_lista">
                    <label for="list_name" class="formulario__label">Nombre de Lista <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="list_name" id="list_name"
                            placeholder="Ej: Tipos de Documento" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre debe tener entre 3 y 40 caracteres</p>
                </div>

                <!-- Mensajes de error y éxito -->
                <div class="formulario__mensaje" id="list_form__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor complete el campo correctamente.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="list_form__mensaje-exito">Lista guardada exitosamente!</p>
                </div>
            </form>
            <button onclick="document.getElementById('list-dialog').close();"
                aria-label="Cerrar"
                class="x">❌</button>
        </dialog>
    </div>

    <!-- Modal para Valores de Lista -->
    <div id="value-list-modal" class="modal">

        <dialog id="value-list-dialog">
            <h2>Registrar Nuevo Valor</h2>

            <form action="" class="formulario" id="value_list_form">

                <!-- Campo oculto para ID -->
                <input type="hidden" id="value_list_id" name="value_list_id">

                <!-- Grupo: Lista Padre -->
                <div class="formulario__grupo" id="grupo__lista_padre">
                    <label for="list_select" class="formulario__label">Lista Padre <span class="obligatorio">*</span></label>
                    <select id="list_select" name="list_select" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una lista</option>
                        <!-- Opciones se llenarán dinámicamente -->
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Seleccione una lista</p>
                </div>

                <!-- Grupo: Nombre de Valor -->
                <div class="formulario__grupo" id="grupo__nombre_valor">
                    <label for="value_name" class="formulario__label">Nombre del Valor <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="value_name" id="value_name"
                            placeholder="Ej: Cédula de Identidad" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre debe tener entre 3 y 45 caracteres</p>
                </div>

                <!-- Grupo: Abreviatura -->
                <div class="formulario__grupo" id="grupo__abreviatura">
                    <label for="value_abbreviation" class="formulario__label">Abreviatura</label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="value_abbreviation" id="value_abbreviation"
                            placeholder="Ej: CI"
                            pattern="[A-Z]{2,8}">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">La abreviatura debe tener entre 2 y 8 letras mayúsculas</p>
                </div>

                <!-- Mensajes de error y éxito -->
                <div class="formulario__mensaje" id="value_list_form__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor complete los campos requeridos correctamente.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="value_list_form__mensaje-exito">Valor guardado exitosamente!</p>
                </div>
            </form>
            <button onclick="document.getElementById('value-list-dialog').close();"
                aria-label="Cerrar"
                class="x">❌</button>
        </dialog>
    </div>

    <!-- Tabla de Listas -->
    <h3>Listas Disponibles</h3>

    <!-- <button class="primary" onclick="document.getElementById('list-dialog').showModal();">Nueva Lista +</button> -->



    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>Nombre</th>
                <th>Fecha Creación</th>
                <th>Estado</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="list_table"></tbody>
    </table>


    <br>
    <br>
    <br>
    <hr />
    <br>
    <br>
    <br>

    <!-- Tabla de Valores de Lista -->
    <h3>Valores de Lista</h3>

    <button class="primary" onclick="document.getElementById('value-list-dialog').showModal();">Nuevo Valor +</button>

    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>Nombre</th>
                <th>Abreviatura</th>
                <th>Lista Padre</th>
                <th>Fecha Creación</th>
                <th>Estado</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="value_list_table"></tbody>
    </table>



</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/ListManager.js"></script>

<?php
require 'footer.php';
?>