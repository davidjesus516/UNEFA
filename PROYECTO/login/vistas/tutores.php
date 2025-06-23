<?php require 'header.php'; ?>

<span class="text">Tutores</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario de nuevo tutor">
            Nuevo <span>+</span>
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Tutor</h2>
            <form action="#" class="formulario" id="formulario">
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
                            name="cedula"
                            id="cedula"
                            placeholder="Ej: 12345678"
                            maxlength="9"
                            required>
                    </div>

                    <p class="formulario__input-error">Formato válido: X-12345678</p>
                </div>

                <!-- Nombres -->
                <?php
                $campos = [
                    ['primer_nombre', 'Primer Nombre', true],
                    ['segundo_nombre', 'Segundo Nombre', false],
                    ['primer_apellido', 'Primer Apellido', true],
                    ['segundo_apellido', 'Segundo Apellido', false]
                ];
                foreach ($campos as [$id, $label, $requerido]) : ?>
                    <div class="formulario__grupo" id="grupo__<?= $id ?>">
                        <label for="<?= $id ?>" class="formulario__label"><?= $label ?><?= $requerido ? ' <span class="obligatorio">*</span>' : '' ?></label>
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="<?= $id ?>" id="<?= $id ?>" placeholder="Ingrese <?= strtolower($label) ?>" <?= $requerido ? 'required' : '' ?>>
                            <i class="formulario__validacion-estado fas fa-times-circle"></i>
                        </div>
                        <?php if ($id === 'primer_nombre') : ?>
                            <p class="formulario__input-error">Este campo solo debe contener letras</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <!-- Sexo -->
                <div class="formulario__grupo" id="grupo__sexo">
                    <label for="sexo" class="formulario__label">Sexo <span class="obligatorio">*</span></label>
                    <select id="sexo" name="sexo" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="MASCULINO">MASCULINO</option>
                        <option value="FEMENINO">FEMENINO</option>
                    </select>
                </div>

                <!-- Teléfono -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="operadora" required>
                                <option value="0412">0412</option>
                                <option value="0414">0414</option>
                                <option value="0416">0416</option>
                                <option value="0422">0422</option>
                                <option value="0424">0424</option>
                                <option value="0426">0426</option>
                                <option value="0255">0255</option>
                            </select>
                        </div>

                        <input type="tel" class="formulario__input formulario__telefono-input" name="telefono" id="telefono" placeholder="(555) 000-000" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato requerido: (XXX) XXX-XXXX</p>
                </div>

                <!-- Correo -->
                <div class="formulario__grupo" id="grupo__correo">
                    <label for="e_mail" class="formulario__label">Correo Electrónico <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="email" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electrónico" required>
                    </div>
                </div>

                <!-- Selects dinámicos -->
                <?php
                $selects = [
                    ['condicion', 'Condición'],
                    ['dedicacion', 'Dedicación'],
                    ['categoria', 'Categoría']
                ];
                foreach ($selects as [$id, $label]) : ?>
                    <div class="formulario__grupo">
                        <label for="<?= $id ?>" class="formulario__label"><?= $label ?> <span class="obligatorio">*</span></label>
                        <select id="<?= $id ?>" name="<?= $id ?>" class="selector formulario__input" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                        </select>
                    </div>
                <?php endforeach; ?>

                <div class="formulario__grupo">
                    <label for="profesion" class="formulario__label"> Profesión <span class="obligatorio">*</span></label>
                    <select id="profesion" name="profesion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                </div>

                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>
            <button onclick="document.getElementById('dialog').close(); $('#formulario').trigger('reset');" aria-label="Cerrar" class="x">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos')">Tutores Activos</button>
        <button class="tab-button" onclick="cambiarTab('inactivos')">Tutores Inactivos</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de tutores">
            <thead>
                <tr class="w3-light-grey">
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Sexo</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Profesión</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display:none"></tbody>
        </table>
    </div>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/tutores.js"></script>


<?php require 'footer.php'; ?>