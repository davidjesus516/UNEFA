<?php
require 'header.php';
?>
<span class="text">Ventana -> Pre inscripción -> Agregar Práctica Profesional</span>
<div class="page-content">
    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">Nuevo <span>+</span></button>

        <dialog id="dialog">
            <h2>Preinscripción.</h2>
            <form action="#" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">
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
                            <input type="text" class="formulario__input" name="nombre_estudiante_display" id="Estudiante" placeholder="Estudiante" readonly>
                            <input type="hidden" class="formulario__input" name='id_estudiante' id="id_estudiante" disabled>
                            <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
                        </div>
                        <p class="formulario__input-error">Validación</p>
                    </div>

                    <!-- Periodo -->
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
                            <select class="formulario__input" name="tipo_practica" id="tipo_practica">
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="Hospitalaria">HOSPITALARIA</option>
                                <option value="Comunitaria">COMUNITARIA</option>
                                <option value="Ordinaria">ORDINARIA</option>
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

                    <!-- Documentos -->
                    <!-- <div class="formulario__grupo" id="grupo__documentos">
                    <label class="formulario__label">Documentos <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="radio" name="documentos" id="entregado" value="entregado" required>
                        <label for="entregado">Entregado</label>
                        <br>
                        <input type="radio" name="documentos" id="no-entregado" value="no-entregado" required>
                        <label for="no-entregado">No Entregado</label>
                    </div>
                </div> -->

                    <div class="formulario__mensaje" id="formulario__mensaje">
                        <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellene el formulario correctamente.</p>
                    </div>
                    <div class="formulario__grupo formulario__grupo-btn-enviar">
                        <button type="submit" class="formulario__btn">Guardar</button>
                        <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                    </div>
            </form>
            <button type="button" onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
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
                    <th>Contacto</th>
                    <th>Periodo</th>
                    <th>Matrícula</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" styl    e="display: none;"></tbody>
        </table>
    </div>
</div>
<script>
    cargarPeriodos();

    function cargarPeriodos() {
        fetch('../controllers/profesional_practices/profesional_practices.php?accion=listar_periodos')
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById("periodo");
                select.innerHTML = ''; // Limpiar opciones previas
                if (Array.isArray(data)) {
                    data.forEach(periodo => {
                        const option = document.createElement("option");
                        option.value = periodo.PERIOD_ID;
                        option.textContent = periodo.DESCRIPTION;
                        select.appendChild(option);
                    });
                } else {
                    const option = document.createElement("option");
                    option.value = '';
                    option.textContent = 'No hay periodos disponibles';
                    select.appendChild(option);
                }
            })
            .catch(() => {
                const select = document.getElementById("periodo");
                select.innerHTML = '';
                const option = document.createElement("option");
                option.value = '';
                option.textContent = 'Error al cargar periodos';
                select.appendChild(option);
            });
    }
    // Nueva función: listarPreinscripciones
    function listarPreinscripciones(tipo) {
        const endpoint = tipo === 'activos' ? 'listar_preinscripciones_activos' : 'listar_preinscripciones_inactivos';
        const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';

        // Asegura que existan ambos tbodys
        let tbody = document.getElementById(tablaId);
        if (!tbody) {
            tbody = document.createElement('tbody');
            tbody.id = tablaId;
            if (tipo === 'inactivos') tbody.style.display = 'none';
            const table = document.querySelector('table');
            table.appendChild(tbody);
        }

        fetch(`../controllers/profesional_practices/profesional_practices.php?accion=${endpoint}`)
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = '';
                if (Array.isArray(data)) {
                    data.forEach(row => {
                        let acciones = ``;
                        if (tipo === 'activos') {
                            acciones += `<button onclick="editarInscripcion(${row.INSCRIPCION_ID})">✏️</button>
                            <button onclick="eliminarInscripcion(${row.INSCRIPCION_ID})">🗑️</button>`;
                        } else {
                            acciones += `<button onclick="activarInscripcion(${row.INSCRIPCION_ID})">♻️</button>`;
                        }
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.STUDENTS_CI || ''}</td>
                            <td>${row.ESTUDIANTE || ''}</td>
                            <td>${row.CONTACTO || row.CONTACT_PHONE || row.PHONE || ''}</td>
                            <td>${row.PERIOD_DESCRIPTION || ''}</td>
                            <td>${row.ENROLLMENT || ''}</td>
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
                tbody.innerHTML = `<tr><td colspan="7">Error al cargar inscripciones ${tipo}</td></tr>`;
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.primary').addEventListener('click', function() {
            document.getElementById('cedula').disabled = false; // Habilitar campo de cédula
            document.getElementById('nacionalidad').disabled = false; // Habilitar nacionalidad
            document.getElementById('dialog').showModal();
            document.getElementById('formulario').reset();
            document.getElementById('id_form').value = ''; // Resetear ID del formulario
        });
        const formulario = document.getElementById("formulario");
        const dialog = document.getElementById("dialog");
        const expresiones = {
            cedula: /^\d{7,8}$/ // Cédula debe tener entre 7 y 8 dígitos
        };

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
                            document.getElementById("matricula").value = data.ENROLLMENT || '';
                            isCorrect("grupo__cedula");
                            document.getElementById("tipo_practica").innerHTML = ''; // Limpiar opciones previas
                            if (data['combos'] && Array.isArray(data['combos'].internship_types)) {
                                data['combos'].internship_types.forEach(tipo => {
                                    const option = document.createElement("option");
                                    option.value = tipo.INTERNSHIP_TYPE_ID;
                                    option.textContent = tipo.NAME;
                                    document.getElementById("tipo_practica").appendChild(option);
                                });
                                isCorrect("grupo__tipo_practica");
                            } else {
                                isIncorrect("grupo__tipo_practica", "No se encontraron tipos de práctica para esta carrera.");
                            }

                        } else {
                            document.getElementById("id_form").value = '';
                            document.getElementById("Estudiante").value = 'estudiante no encontrado';
                            isIncorrect("grupo__cedula", "Estudiante no encontrado");
                        }
                    });
            } else {
                this.setCustomValidity("Formato inválido. Debe tener entre 7 y 8 dígitos.");
            }

        });

        // Registrar o actualizar inscripción
        formulario.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(formulario);
            const id = formData.get("id_form");
            const accion = id ? "actualizar_preinscripcion" : "insertar_preinscripcion";
            formData.append("id", id);

            fetch(`../controllers/profesional_practices/profesional_practices.php?accion=${accion}`, {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        alert(res.message || "Operación exitosa");
                        formulario.reset();
                        dialog.close();
                        listarPreinscripciones('activos');
                        listarPreinscripciones('inactivos');
                    } else {
                        alert(res.error || "Error al guardar");
                    }
                });
        });

        // 2. editarInscripcion: muestra los datos en el formulario para editar
        window.editarInscripcion = function(id) {
            fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_preinscripcion_por_id&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        tipo_practica.innerHTML = ''; // Limpiar opciones previas
                        if (data['combos'] && Array.isArray(data['combos'].internship_types)) {
                            data['combos'].internship_types.forEach(tipo => {
                                const option = document.createElement("option");
                                option.value = tipo.INTERNSHIP_TYPE_ID;
                                option.textContent = tipo.NAME;
                                tipo_practica.appendChild(option);
                            });
                        } else {
                            const option = document.createElement("option");
                            option.value = '';
                            option.textContent = 'No hay tipos de práctica disponibles';
                            tipo_practica.appendChild(option);
                        }
                        document.getElementById("id_form").value = data.INSCRIPCION_ID || '';
                        document.getElementById("cedula").value = data.CEDULA || '';
                        document.getElementById("cedula").disabled = true; // Deshabilitar campo de cédula
                        document.getElementById("nacionalidad").value = data.NACIONALIDAD || '';
                        document.getElementById("nacionalidad").disabled = true; // Deshabilitar nacionalidad
                        document.getElementById("Estudiante").value = data.ESTUDIANTE || '';
                        document.getElementById("id_estudiante").value = data.STUDENTS_ID || '';
                        document.getElementById("periodo").value = data.PERIOD_ID || '';
                        document.getElementById("tipo_practica").value = data.INTERNSHIP_TYPE_ID || '';
                        document.getElementById("matricula").value = data.ENROLLMENT || '';
                        dialog.showModal();
                    }
                });
        };
        // 4. eliminarInscripcion: elimina una inscripción activa
        window.eliminarInscripcion = function(id) {
            if (confirm("¿Estás seguro de eliminar esta inscripción?")) {
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=eliminar_preinscripcion&id=${id}`, {
                        method: "POST"
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || "Inscripción eliminada exitosamente");
                            listarPreinscripciones('activos'); // Recargar lista de activos
                        } else {
                            alert(data.error || "Error al eliminar inscripción");
                        }
                    });
            }
        };
        // 5. activarInscripcion: activa una inscripción inactiva
        window.activarInscripcion = function(id) {
            if (confirm("¿Estás seguro de activar esta inscripción?")) {
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=activar_preinscripcion&id=${id}`, {
                        method: "POST"
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || "Inscripción activada exitosamente");
                            listarPreinscripciones('inactivos'); // Recargar lista de inactivos
                        } else {
                            alert(data.error || "Error al activar inscripción");
                        }
                    });
            }
        };

        // 3. cambiarTab: muestra/oculta correctamente los tbodys de activos/inactivos
        window.cambiarTab = function(tab) {
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            document.getElementById('datos-activos').style.display = (tab === 'activos') ? '' : 'none';
            document.getElementById('datos-inactivos').style.display = (tab === 'inactivos') ? '' : 'none';
            tab === 'activos' ? listarPreinscripciones('activos') : listarPreinscripciones('inactivos');
        };

        // Si necesitas cargar selects dinámicamente, agrega aquí tus AJAX para llenar los combos
        listarPreinscripciones('activos');
    });
</script>
<?php
require 'footer.php';
?>