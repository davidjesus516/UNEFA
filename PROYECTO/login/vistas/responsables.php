<?php require 'header.php'; ?>
<span class="text" style="margin-left: 1rem;">Responsables Institucionales</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary">
            Nuevo <span>+</span>
        </button>

        <dialog id="dialog-responsable">
            <h2 id="dialogResponsableTitle">Registrar Responsable</h2>
            <form id="formulario" class="formulario">
                <input type="hidden" id="id_form" name="id_form">

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
                               name="MANAGER_CI"
                               id="MANAGER_CI"
                               placeholder="Ej: 12345678"
                               maxlength="9"
                               required>
                    </div>
                    <p id="error-cedula" class="formulario__input-error" style="display: none;">Este número de cédula ya está registrado.</p>
                </div>

                <!-- SELECT DE INSTITUCIONES -->
                <div class="formulario__grupo">
                    <label class="formulario__label"for="institucion_id">Institución <span class="obligatorio">*</span></label>
                    <select name="INSTITUTION_ID" id="INSTITUTION_ID" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una institución</option>
                    </select>
                </div>

                <div class="formulario__grupo">
                    <label class="formulario__label"for="nombre">Primer Nombre <span class="obligatorio">*</span></label>
                    <input type="text" name="NAME" id="NAME" class="formulario__input" placeholder="Ingrese el primer nombre" required>
                </div>

                <div class="formulario__grupo">
                    <label class="formulario__label"for="segundo_nombre">Segundo Nombre</label>
                    <input type="text" name="SECOND_NAME" id="SECOND_NAME" class="formulario__input" placeholder="Ingrese el segundo nombre">
                </div>

                <div class="formulario__grupo">
                    <label class="formulario__label"for="apellido">Primer Apellido <span class="obligatorio">*</span></label>
                    <input type="text" name="SURNAME" id="SURNAME" class="formulario__input" required placeholder="Ingrese el primer apellido">
                </div>

                <div class="formulario__grupo">
                    <label class="formulario__label"for="segundo_apellido">Segundo Apellido</label>
                    <input type="text" name="SECOND_SURNAME" id="SECOND_SURNAME" class="formulario__input" placeholder="Ingrese el segundo apellido">
                </div>
                <!-- Teléfono -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label class="formulario__label"for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="prefijo_telefono" required>
                                <option value="0412">0412</option>
                                <option value="0414">0414</option>
                                <option value="0416">0416</option>
                                <option value="0422">0422</option>
                                <option value="0424">0424</option>
                                <option value="0426">0426</option>
                                <option value="0255">0255</option>
                            </select>
                        </div>

                        <input type="tel" class="formulario__input formulario__telefono-input" name="CONTACT_PHONE" id="CONTACT_PHONE" placeholder="Ej: 1234567" maxlength="7" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato requerido: XXX-XXXXXXX</p>
                </div>

                <div class="formulario__grupo">
                    <label class="formulario__label"for="EMAIL">Correo Electrónico <span class="obligatorio">*</span></label>
                    <input type="email" name="EMAIL" id="EMAIL" class="formulario__input" placeholder="Ingrese el correo electrónico" required >
                    <p id="error-correo" class="formulario__input-error" style="display: none;">Este correo ya está registrado.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                </div>
            </form>
            <button class="x">❌</button>
        </dialog>
    </div>

    <!-- Tabs para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" data-tab="activos">Responsables Activos</button>
        <button class="tab-button" data-tab="inactivos">Responsables Inactivos</button>
    </div>

    <div class="table-container">
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr class="w3-light-grey">
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Institución</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-responsables-activos"></tbody>
            <tbody id="datos-responsables-inactivos" style="display: none;"></tbody>
        </table>
    </div>
<a href="Institucion.php" class="btn-link-responsables" style="margin: 1rem 0; display: inline-block;">
    Volver a Instituciones
</a>
</div>
<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/responsables.js"></script>
<?php require 'footer.php'; ?>
