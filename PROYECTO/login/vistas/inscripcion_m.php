<?php require 'header.php'; ?>
<span class="text">Ventana -> Inscripción</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario de nueva Inscripción">
            Nueva <i class="fas fa-plus"></i>
            <span></span>
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Inscripción</h2>

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
                            pattern="^\d{7,8}$"
                            title="Formato: V-12345678, E-12345678 o P-12345678"
                            minlength="7"
                            maxlength="8"
                            required>
                    </div>

                    <p class="formulario__input-error">Formato válido: X-12345678</p>
                </div>

                <!-- Estudiante -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Estudiante<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="NULL" class="formulario__input" name="" id="Estudiante" placeholder="Estudiante" disabled>
                        <input type="hidden" class="formulario__input" name='id_estudiante' id="id_estudiante" disabled>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!-- Tipo de Practica -->
                <div class="formulario__grupo" id="grupo__tipo_practica">
                    <label for="tipo_practica" class="formulario__label">Tipo Práctica<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="NULL" class="formulario__input" name="tipo_practica" id="tipo_practica" placeholder="Tipo Práctica" disabled>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validación</p>
                </div>

                <!-- Tutor Academico -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Tutor Académico<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="tutor_academico">
                            <option value="">Seleccione una opción</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validación</p>
                </div>

                <!-- Tutor Metodologico -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Tutor Metodológico<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="tutor_metodologico">
                            <option value="">Seleccione una opción</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validación</p>
                </div>

                <!-- Institucion -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Institución<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="institucion">
                            <option value="">Seleccione una opción</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validación</p>
                </div>

                <!-- Responsable Institucion -->
                <div class="formulario__grupo" id="grupo__responsable_institucion">
                    <label for="responsable_institucion" class="formulario__label">Responsable Institución<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="responsable_institucion" name="responsable_institucion">
                            <option value="">Seleccione una opción</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validación</p>
                </div>


                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>

            <button onclick="window.dialog.close();" class="x" aria-label="Cerrar formulario de institución">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos')">Inscripciones Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos')">Inscripciones Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de instituciones">
            <thead>
                <tr class="w3-light-grey">
                    <th>Estudiante</th>
                    <th>Tutor Académico</th>
                    <th>Tutor Metodológico</th>
                    <th>Institución</th>
                    <th>Responsable</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display: none;"></tbody>
        </table>
    </div>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script>
    // Validación: tutor metodológico y académico no pueden ser iguales
    function validarTutoresDistintos() {
        const tutorAcademico = document.getElementById("tutor_academico");
        const tutorMetodologico = document.getElementById("tutor_metodologico");
        if (tutorAcademico && tutorMetodologico) {
            if (tutorAcademico.value && tutorMetodologico.value && tutorAcademico.value === tutorMetodologico.value) {
                alert("El tutor metodológico no puede ser igual al tutor académico.");
                tutorMetodologico.value = '';
                tutorMetodologico.focus();
                return false;
            }
        }
        return true;
    }

    function listarInscripciones(tipo) {
        const endpoint = tipo === 'activos' ? 'listar_inscripciones_activos' : 'listar_inscripciones_inactivos';
        const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';
        fetch(`../controllers/profesional_practices/profesional_practices.php?accion=${endpoint}`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById(tablaId);
                tbody.innerHTML = '';
                if (Array.isArray(data)) {
                    data.forEach(row => {
                        let acciones = `<button onclick="editarInscripcion(${row.INSCRIPCION_ID})">✏️</button>`;
                        if (tipo === 'activos') {
                            acciones += `<button onclick="eliminarInscripcion(${row.INSCRIPCION_ID})">🗑️</button>`;
                        } else {
                            acciones += `<button onclick="activarInscripcion(${row.INSCRIPCION_ID})">♻️</button>`;
                        }
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.ESTUDIANTE || ''}</td>
                            <td>${row.TUTOR_ACADEMICO_NOMBRE || ''} ${row.TUTOR_ACADEMICO_APELLIDO || ''}</td>
                            <td>${row.TUTOR_METODOLOGICO_NOMBRE || ''} ${row.TUTOR_METODOLOGICO_APELLIDO || ''}</td>
                            <td>${row.INSTITUTION_NAME || ''}</td>
                            <td>${row.RESPONSABLE_NOMBRE || ''} ${row.RESPONSABLE_APELLIDO || ''}</td>
                            <td colspan="2">${acciones}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else if (data.mensaje) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="7">${data.mensaje}</td>`;
                    tbody.appendChild(tr);
                }
            })
            .catch(() => {
                const tbody = document.getElementById(tablaId);
                tbody.innerHTML = `<tr><td colspan="7">Error al cargar inscripciones ${tipo}</td></tr>`;
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.primary').addEventListener('click', function() {
            document.getElementById('dialog').showModal();
            document.getElementById('formulario').reset();
            document.getElementById('id_form').value = ''; // Resetear ID del formulario
        });
        const formulario = document.getElementById("formulario");
        const dialog = document.getElementById("dialog");
        const expresiones = {
            cedula: /^\d{7,8}$/ // Cédula debe tener entre 7 y 8 dígitos
        };
        // Asigna la validación cada vez que se cambia alguno de los dos selects
        const tutorAcademico = document.getElementById("tutor_academico");
        const tutorMetodologico = document.getElementById("tutor_metodologico");
        if (tutorAcademico && tutorMetodologico) {
            tutorAcademico.addEventListener('change', validarTutoresDistintos);
            tutorMetodologico.addEventListener('change', validarTutoresDistintos);
        }

        function isCorrect(id) {
            const grupo = document.getElementById(id);
            if (!grupo) return;
            grupo.classList.add("formulario__grupo-correcto");
            grupo.classList.remove("formulario__grupo-incorrecto");
            const icon = grupo.querySelector('i');
            if (icon) {
                icon.classList.add("fa-check-circle");
                icon.classList.remove("fa-times-circle");
            }
            const errorMsg = grupo.querySelector('.formulario__input-error');
            if (errorMsg) errorMsg.classList.remove("formulario__input-error-activo");
        }

        function isIncorrect(id, message) {
            const grupo = document.getElementById(id);
            if (!grupo) return;
            grupo.classList.add("formulario__grupo-incorrecto");
            grupo.classList.remove("formulario__grupo-correcto");
            const icon = grupo.querySelector('i');
            if (icon) {
                icon.classList.add("fa-times-circle");
                icon.classList.remove("fa-check-circle");
            }
            const errorMsg = grupo.querySelector('.formulario__input-error');
            if (errorMsg) {
                errorMsg.classList.add("formulario__input-error-activo");
                if (message) errorMsg.textContent = message;
            }
        }

        function validateInput(input, regex, id, message) {
            if (regex.test(input.value)) {
                isCorrect(id);
                return true;
            } else {
                isIncorrect(id, message || 'El campo no es válido');
                return false;
            }
        }

        function cargarResponsables() {
            const idInstitucion = document.getElementById("institucion").value;
            if (!idInstitucion) {
                isIncorrect("grupo__responsable_institucion", "Seleccione una institución primero.");
                return;
            }
            fetch(`../controllers/profesional_practices/profesional_practices.php?accion=cargar_responsables&institucion_id=${idInstitucion}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Error al cargar responsables');
                    }
                    return res.json();
                })
                .then(data => {
                    const select = document.getElementById("responsable_institucion");
                    select.innerHTML = ''; // Limpiar opciones previas
                    if (Array.isArray(data)) {
                        data.forEach(responsable => {
                            const option = document.createElement("option");
                            option.value = responsable.TUTOR_ID;
                            option.textContent = responsable.NAME + ' ' + responsable.SURNAME;
                            select.appendChild(option);
                        });
                    } else {
                        // Manejo de error si no hay responsables
                        const option = document.createElement("option");
                        option.value = '';
                        option.textContent = 'No hay responsables disponibles';
                        select.appendChild(option);
                    }
                })
                .catch(error => {
                    // Manejo de error
                    const select = document.getElementById("responsable_institucion");
                    select.innerHTML = '';
                    const option = document.createElement("option");
                    option.value = '';
                    option.textContent = 'Error al cargar responsables';
                    select.appendChild(option);
                });
        }
        document.getElementById('cedula').addEventListener('input', function() {
            // Validar cédula
            const cedulaInput = this;
            const regex = new RegExp(expresiones.cedula);
            const isValid = validateInput(cedulaInput, regex, 'grupo__cedula', 'Formato inválido. Debe tener entre 7 y 8 dígitos.');
            const nacionalidad = document.getElementById("nacionalidad").value;
            if (this.value.length >= 7 && this.value.length <= 8) {
                this.setCustomValidity(""); // Resetea el mensaje de error
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_por_cedula&cedula=${nacionalidad}-${cedulaInput.value}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            document.getElementById("id_estudiante").value = data.STUDENTS_ID;
                            document.getElementById("Estudiante").value = data.NOMBRE_COMPLETO;
                            isCorrect("grupo__cedula");
                            document.getElementById("tipo_practica").value = data.internship_types || '';
                            document.getElementById("tutor_academico").innerHTML = ''; // Limpiar opciones previas
                            if (data['combos'] && Array.isArray(data['combos'].tutores)) {
                                const defaultOption = document.createElement("option");
                                defaultOption.value = '';
                                defaultOption.textContent = 'Seleccione un tutor académico';
                                defaultOption.disabled = true;
                                defaultOption.selected = true;
                                document.getElementById("tutor_academico").appendChild(defaultOption);
                                // Llenar el select de tutores académicos
                                data['combos'].tutores.forEach(tutor => {
                                    const option = document.createElement("option");
                                    option.value = tutor.TUTOR_ID;
                                    option.textContent = `${tutor.NAME} ${tutor.SURNAME}`;
                                    document.getElementById("tutor_academico").appendChild(option);
                                });
                                if (document.getElementById("tutor_academico").value === document.getElementById("tutor_metodologico").value) {
                                    isIncorrect("grupo__tutor_academico", "El tutor académico no puede ser el mismo que el metodológico.");
                                } else {
                                    isCorrect("grupo__tutor_academico");
                                }
                            } else {
                                isIncorrect("grupo__tutor_academico", "No se encontraron tutores académicos.");
                            }
                            document.getElementById("tutor_metodologico").innerHTML = ''; // Limpiar opciones previas
                            if (data['combos'] && Array.isArray(data['combos'].tutores)) {
                                const defaultOption = document.createElement("option");
                                defaultOption.value = '';
                                defaultOption.textContent = 'Seleccione un tutor metodológico';
                                defaultOption.disabled = true;
                                defaultOption.selected = true;
                                document.getElementById("tutor_metodologico").appendChild(defaultOption);
                                // Llenar el select de tutores metodológicos
                                data['combos'].tutores.forEach(tutor => {
                                    const option = document.createElement("option");
                                    option.value = tutor.TUTOR_ID;
                                    option.textContent = `${tutor.NAME} ${tutor.SURNAME}`;
                                    document.getElementById("tutor_metodologico").appendChild(option);
                                });
                                if (document.getElementById("tutor_academico").value === document.getElementById("tutor_metodologico").value) {
                                    isIncorrect("grupo__tutor_academico", "El tutor académico no puede ser el mismo que el metodológico.");
                                } else {
                                    isCorrect("grupo__tutor_academico");
                                }
                            } else {
                                isIncorrect("grupo__tutor_metodologico", "No se encontraron tutores metodológicos.");
                            }
                            institucion = document.getElementById("institucion");
                            institucion.innerHTML = ''; // Limpiar opciones previas
                            if (data['combos'] && Array.isArray(data['combos'].instituciones)) {
                                const defaultOption = document.createElement("option");
                                defaultOption.value = '';
                                defaultOption.textContent = 'Seleccione una institución';
                                defaultOption.disabled = true;
                                defaultOption.selected = true;
                                institucion.appendChild(defaultOption);
                                data['combos'].instituciones.forEach(institucion => {
                                    const option = document.createElement("option");
                                    option.value = institucion.INSTITUTION_ID;
                                    option.textContent = institucion.INSTITUTION_NAME;
                                    document.getElementById("institucion").appendChild(option);
                                });
                            } else {
                                isIncorrect("grupo__institucion", "No se encontraron instituciones.");
                            }
                            document.getElementById("institucion").addEventListener('change', function() {
                                cargarResponsables();
                            });
                            // Aquí podrías llenar otros campos si es necesario
                        } else {
                            document.getElementById("id_estudiante").value = '';
                            document.getElementById("Estudiante").value = 'estudiante no encontrado';
                            isIncorrect("grupo__cedula", "Estudiante no encontrado");
                        }
                    });
            } else {
                this.setCustomValidity("Formato inválido. Debe tener entre 7 y 8 dígitos.");
            }

        });
        // Aquí deberías cargar los select con AJAX si es necesario

        // Registrar o actualizar inscripción
        formulario.addEventListener("submit", function(e) {
            // Validar tutores antes de enviar
            if (!validarTutoresDistintos()) {
                e.preventDefault();
                return;
            }
            e.preventDefault();
            const formData = new FormData(formulario);
            const id = formData.get("id_form");
            const accion = id ? "actualizar" : "insertar";
            formData.append("id", id);

            fetch(`../controllers/Inscripcion/Inscripcion.php?accion=${accion}`, {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        alert(res.message || "Operación exitosa");
                        formulario.reset();
                        dialog.close();
                        // Aquí podrías recargar una lista de inscripciones si tienes una tabla
                    } else {
                        alert(res.error || "Error al guardar");
                    }
                });
        });

        // Si necesitas editar una inscripción, deberías tener una función similar a esta:
        window.editarInscripcion = function(id) {
            fetch(`../controllers/Inscripcion/Inscripcion.php?accion=buscar_por_id&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        document.getElementById("id_form").value = data.INSCRIPCION_ID;
                        document.getElementById("cedula").value = data.CEDULA;
                        document.getElementById("nacionalidad").value = data.NACIONALIDAD;
                        // Asigna los valores a los demás campos según corresponda
                        // Por ejemplo:
                        // document.getElementById("Estudiante").value = data.ESTUDIANTE;
                        // document.getElementById("tutor_academico").value = data.TUTOR_ACADEMICO;
                        // document.getElementById("tutor_metodologico").value = data.TUTOR_METODOLOGICO;
                        // document.getElementById("institucion").value = data.INSTITUCION;
                        // document.getElementById("responsable_institucion").value = data.RESPONSABLE_INSTITUCION;
                        // document.querySelector(`input[name="documentos"][value="${data.DOCUMENTOS}"]`).checked = true;

                        dialog.showModal();
                    }
                });
        };

        // Si tienes pestañas para inscripciones activas/inactivas, puedes adaptar la función cambiarTab
        window.cambiarTab = function(tab) {
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            if (tab === 'activos') {
                document.getElementById('datos-activos').style.display = '';
                document.getElementById('datos-inactivos').style.display = 'none';
            } else {
                document.getElementById('datos-activos').style.display = 'none';
                document.getElementById('datos-inactivos').style.display = '';
            }
        };

        // Si necesitas cargar selects dinámicamente, agrega aquí tus AJAX para llenar los combos
        listarInscripciones('activos');
        listarInscripciones('inactivos');
    });
</script>

<?php require 'footer.php'; ?>