<?php require 'header.php'; ?>
<span class="text">Instituciones</span>

<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" id="btn-nueva-institucion" aria-label="Abrir formulario de nueva institución">
            Nueva <span>+</span>
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Institución</h2>

            <form action="#" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">

                <!-- RIF -->
                <div class="formulario__grupo" id="grupo__rif">
                    <label for="rif" class="formulario__label">RIF <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="rif" id="rif"
                            placeholder="Ej: J-123456789" pattern="[JGVEP]-[0-9]{8,9}"
                            title="Formato: X-123456789" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Formato válido: X-123456789</p>
                </div>

                <!-- Nombre -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="nombre" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nombre" id="nombre"
                            placeholder="Ingrese el nombre de la institución" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre debe tener de 4 a 100 caracteres.</p>
                </div>

                <!-- Dirección -->
                <div class="formulario__grupo" id="grupo__direccion">
                    <label for="direccion" class="formulario__label">Dirección Fiscal<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <textarea class="formulario__input" name="direccion" id="direccion"
                            placeholder="Ingrese la dirección" required></textarea>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">La dirección debe tener al menos 10 caracteres.</p>
                </div>

                <!-- Teléfono -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono_numero" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="operadora" name="operadora" required>
                                <option value="0412" selected>0412</option>
                                <option value="0414">0414</option>
                                <option value="0416">0416</option>
                                <option value="0422">0422</option>
                                <option value="0424">0424</option>
                                <option value="0426">0426</option>
                                <option value="0255">0255</option>
                            </select>
                        </div>

                        <input type="tel" class="formulario__input formulario__telefono-input" name="telefono_numero" id="telefono_numero" placeholder="(555) 000-000" maxlength="7" pattern="\d{7}" title="Debe contener 7 dígitos" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato requerido: XXX-XXXXXXX</p>
                </div>

                <!-- Tipo de Práctica -->
                <div class="formulario__grupo" id="grupo__tipo_practica">
                    <label for="tipo_practica" class="formulario__label">Tipo Práctica <span class="obligatorio">*</span></label>
                    <select id="tipo_practica" name="tipo_practica" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <p class="formulario__input-error">Debe seleccionar un tipo de práctica.</p>
                </div>

                <!-- Carrera (depende de Tipo de Práctica) -->
                <div class="formulario__grupo" id="grupo__carrera">
                    <label for="carrera" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
                    <select id="carrera" name="carrera" class="formulario__input" required disabled>
                        <option value="" disabled selected>Seleccione un tipo de práctica primero</option>
                    </select>
                    <p class="formulario__input-error">Debe seleccionar una carrera.</p>
                </div>

                <!-- Región -->
                <div class="formulario__grupo" id="grupo__region">
                    <label for="region" class="formulario__label">Región <span class="obligatorio">*</span></label>
                    <select id="region" name="region" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <p class="formulario__input-error">Debe seleccionar una región.</p>
                </div>

                <!-- Núcleo -->
                <div class="formulario__grupo" id="grupo__nucleo">
                    <label for="nucleo" class="formulario__label">Núcleo <span class="obligatorio">*</span></label>
                    <select id="nucleo" name="nucleo" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <p class="formulario__input-error">Debe seleccionar un núcleo.</p>
                </div>

                <!-- Extensión -->
                <div class="formulario__grupo" id="grupo__extension">
                    <label for="extension" class="formulario__label">Extensión <span class="obligatorio">*</span></label>
                    <select id="extension" name="extension" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <p class="formulario__input-error">Debe seleccionar una extensión.</p>
                </div>

                <!-- Tipo de Institución -->
                <div class="formulario__grupo" id="grupo__tipo_institucion">
                    <label for="tipo_institucion" class="formulario__label">Tipo Institución <span class="obligatorio">*</span></label>
                    <select id="tipo_institucion" name="tipo_institucion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <p class="formulario__input-error">Debe seleccionar un tipo de institución.</p>
                </div>

                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>

            <!-- Hidden input for career_id to be sent with the form -->
            <input type="hidden" id="career_id_hidden" name="career_id_hidden">

            <button type="button" class="x" id="cerrar-modal" aria-label="Cerrar formulario de institución">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos', event)">Instituciones Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos', event)">Instituciones Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de instituciones">
            <thead>
                <tr class="w3-light-grey">
                    <th>RIF</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Tipo Práctica</th>
                    <th>Carrera</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display: none;"></tbody>
        </table>
    </div>
    <a href="responsables.php" class="btn-link-responsables" style="margin: 1rem 0; display: inline-block;">
        Ir a Responsables Institucionales
    </a>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/Institucion.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php require 'footer.php'; ?>