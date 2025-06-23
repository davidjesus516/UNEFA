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
        .then(data => { // Add console.log for debugging
            console.log(`Data received for ${tipo} inscripciones:`, data);
            const tbody = document.getElementById(tablaId);
            tbody.innerHTML = '';
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    let accionesHtml = '';
                    if (tipo === 'activos') {
                        accionesHtml = `
                            <td><button class="task-edit" onclick="editarInscripcion(${row.INSCRIPCION_ID})"><span class="texto"></span><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button></td>
                            <td><button class="task-view" onclick="verInscripcion(${row.INSCRIPCION_ID})"><span class="texto"></span><span class="icon"><i class="fa-solid fa-search"></i></span></button></td>
                            <td><button class="task-note" onclick="culminarInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Culminar</span><span class="icon"><i class="fa-solid fa-clipboard-check"></i></span></button></td>
                            <td><button class="task-delete" onclick="eliminarInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Borrar</span><span class="icon"><i class="fa-solid fa-trash-can"></i></span></button></td>
                        `;
                    } else {
                        accionesHtml = `
                            <td><button class="task-restore" onclick="activarInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Restaurar</span><span class="icon"><i class="fa-solid fa-rotate-left"></i></span></button></td>
                            <td><button class="task-view" onclick="verInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Ver</span><span class="icon"><i class="fa-solid fa-search"></i></span></button></td>
                            <td></td>
                            <td></td>
                        `;
                    }
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.ESTUDIANTE || ''}</td>
                        <td>${row.TUTOR_ACADEMICO_NOMBRE || ''} ${row.TUTOR_ACADEMICO_APELLIDO || ''}</td>
                        <td>${row.TUTOR_METODOLOGICO_NOMBRE || ''} ${row.TUTOR_METODOLOGICO_APELLIDO || ''}</td>
                        <td>${row.INSTITUTION_NAME || ''}</td>
                        <td>${row.RESPONSABLE_NOMBRE || ''} ${row.RESPONSABLE_APELLIDO || ''}</td>
                        <td>${row.TIPO_PRACTICA || ''}</td>
                        <td>${row.PRACTICE_START_DATE ? new Date(row.PRACTICE_START_DATE).toLocaleDateString() : ''}</td>
                        ${accionesHtml}
                    `;
                    tbody.appendChild(tr);
                });
            } else { // Modified to catch empty arrays or non-array data without 'mensaje'
                const tr = document.createElement('tr');
                tr.innerHTML = `<td colspan="11">${data.mensaje || `No hay inscripciones ${tipo} disponibles.`}</td>`;
                tbody.appendChild(tr);
            }
        })
        .catch(error => { // Catch network errors
            console.error(`Error al cargar inscripciones ${tipo}:`, error);
            const tbody = document.getElementById(tablaId);
            tbody.innerHTML = `<tr><td colspan="9">Error al cargar inscripciones ${tipo}. Por favor, intente de nuevo.</td></tr>`;
        });
}

document.addEventListener("DOMContentLoaded", function() {
    const dialog = document.getElementById("dialog");

    document.querySelector('.primary').addEventListener('click', function() {
        // Ensure all fields are enabled and the save button is visible for a new entry
        const form = document.getElementById('formulario');
        form.querySelectorAll('input, select, textarea').forEach(input => input.disabled = false);
        document.getElementById('Estudiante').readOnly = true; // Keep these readonly as they are auto-filled
        document.getElementById('tipo_practica').readOnly = true; // Keep these readonly as they are auto-filled
        form.querySelector('.formulario__btn').style.display = 'block';

        dialog.showModal();
        document.getElementById('formulario').reset();
        document.getElementById('id_form').value = ''; // Resetear ID del formulario
    });

    dialog.addEventListener('close', function() {
        const form = document.getElementById('formulario');
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.disabled = false); // Re-enable fields
        document.getElementById('Estudiante').readOnly = true;
        document.getElementById('tipo_practica').readOnly = true;
        form.querySelector('.formulario__btn').style.display = 'block';
        // No reseteamos el formulario aquí para que los datos persistan si se cierra por error
    });

    const formulario = document.getElementById("formulario");
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
                        option.value = responsable.MANAGER_ID;
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
        if (this.value.length >= 7 && this.value.length <= 8) {
            this.setCustomValidity(""); // Resetea el mensaje de error
            const nacionalidad = document.getElementById("nacionalidad").value;
            fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_preinscripcion_activa_por_cedula&cedula=${nacionalidad}-${cedulaInput.value}`)
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(errorData => { throw new Error(errorData.error || `Error ${res.status}`); });
                    }
                    return res.json();
                })
                .then(data => {
                    // Success case
                    document.getElementById("id_form").value = data.PROFESSIONAL_PRACTICE_ID;
                    document.getElementById("id_estudiante").value = data.STUDENTS_ID;
                    document.getElementById("Estudiante").value = data.NOMBRE_COMPLETO;
                    document.getElementById("tipo_practica").value = data.TIPO_PRACTICA;
                    isCorrect("grupo__cedula");

                    // Populate combos
                    const combos = data.combos;
                    if (combos) {
                        const tutorAcademicoSelect = document.getElementById("tutor_academico");
                        const tutorMetodologicoSelect = document.getElementById("tutor_metodologico");
                        const institucionSelect = document.getElementById("institucion");

                        tutorAcademicoSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                        tutorMetodologicoSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                        if (Array.isArray(combos.tutores)) {
                            combos.tutores.forEach(tutor => {
                                const option = `<option value="${tutor.TUTOR_ID}">${tutor.NAME} ${tutor.SURNAME}</option>`;
                                tutorAcademicoSelect.innerHTML += option;
                                tutorMetodologicoSelect.innerHTML += option;
                            });
                        }

                        institucionSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                        if (Array.isArray(combos.instituciones)) {
                            combos.instituciones.forEach(inst => {
                                institucionSelect.innerHTML += `<option value="${inst.INSTITUTION_ID}">${inst.INSTITUTION_NAME}</option>`;
                            });
                        }
                    }
                    document.getElementById("institucion").addEventListener('change', cargarResponsables);
                })
                .catch(error => {
                    document.getElementById("id_form").value = '';
                    document.getElementById("id_estudiante").value = '';
                    document.getElementById("Estudiante").value = 'Estudiante no preinscrito';
                    document.getElementById("tipo_practica").value = '';
                    document.getElementById("tutor_academico").innerHTML = '<option value="">Seleccione una opción</option>';
                    document.getElementById("tutor_metodologico").innerHTML = '<option value="">Seleccione una opción</option>';
                    document.getElementById("institucion").innerHTML = '<option value="">Seleccione una opción</option>';
                    document.getElementById("responsable_institucion").innerHTML = '<option value="">Seleccione una opción</option>';
                    isIncorrect("grupo__cedula", error.message);
                });
        } else {
            this.setCustomValidity("Formato inválido. Debe tener entre 7 y 8 dígitos.");
        }
    });

    // Registrar o actualizar inscripción
    formulario.addEventListener("submit", function(e) {
        e.preventDefault();
        // Validar tutores antes de enviar
        if (!validarTutoresDistintos()) {
            return;
        }

        const formData = new FormData(formulario);

        fetch(`../controllers/profesional_practices/profesional_practices.php?accion=inscribir_practica`, {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    dialog.close(); // Ocultar el modal inmediatamente
                    Swal.fire({
                        title: 'Éxito', text: res.message || "Operación exitosa", icon: 'success', confirmButtonText: 'Aceptar'
                    }).then(() => {
                        formulario.reset(); // Resetear el formulario después de la operación exitosa
                        listarInscripciones('activos');
                        listarInscripciones('inactivos');
                    });
                } else {
                    Swal.fire({
                        title: 'Error', text: res.error || "Error al guardar", icon: 'error', confirmButtonText: 'Aceptar'
                    });
                }
            }).catch(() => {
                Swal.fire({
                    title: 'Error de Conexión', text: 'No se pudo comunicar con el servidor.', icon: 'error', confirmButtonText: 'Aceptar'
                });
            });
    });

    window.verInscripcion = function(id) {
        fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_inscripcion_por_id&id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    Swal.fire('Error', data.error, 'error');
                    return;
                }

                const form = document.getElementById('formulario');
                form.reset();
                
                document.getElementById('id_form').value = data.INSCRIPCION_ID;
                document.getElementById('id_estudiante').value = data.STUDENTS_ID;
                document.getElementById('nacionalidad').value = data.NACIONALIDAD;
                document.getElementById('cedula').value = data.CEDULA;
                document.getElementById('Estudiante').value = data.ESTUDIANTE;
                document.getElementById('tipo_practica').value = data.TIPO_PRACTICA;

                const combos = data.combos;
                const tutorAcademicoSelect = document.getElementById("tutor_academico");
                const tutorMetodologicoSelect = document.getElementById("tutor_metodologico");
                const institucionSelect = document.getElementById("institucion");
                const responsableSelect = document.getElementById("responsable_institucion");

                tutorAcademicoSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                tutorMetodologicoSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                if (Array.isArray(combos.tutores)) {
                    combos.tutores.forEach(tutor => {
                        const option = `<option value="${tutor.TUTOR_ID}">${tutor.NAME} ${tutor.SURNAME}</option>`;
                        tutorAcademicoSelect.innerHTML += option;
                        tutorMetodologicoSelect.innerHTML += option;
                    });
                }

                institucionSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                if (Array.isArray(combos.instituciones)) {
                    combos.instituciones.forEach(inst => {
                        institucionSelect.innerHTML += `<option value="${inst.INSTITUTION_ID}">${inst.INSTITUTION_NAME}</option>`;
                    });
                }
                
                responsableSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                if (Array.isArray(combos.responsables)) {
                    combos.responsables.forEach(resp => {
                        responsableSelect.innerHTML += `<option value="${resp.MANAGER_ID}">${resp.NAME} ${resp.SURNAME}</option>`;
                    });
                }

                tutorAcademicoSelect.value = data.TUTOR_ID;
                tutorMetodologicoSelect.value = data.TUTOR_M_ID;
                institucionSelect.value = data.INSTITUTION_ID;
                responsableSelect.value = data.MANAGER_ID;

                // Modo solo lectura
                form.querySelectorAll('input, select, textarea').forEach(input => input.disabled = true);
                form.querySelector('.formulario__btn').style.display = 'none';
                
                dialog.showModal();
            });
    };

    window.culminarInscripcion = function(id) {
        Swal.fire({
            title: 'Culminar Práctica Profesional',
            text: 'Seleccione el estado final de la práctica:',
            icon: 'question',
            input: 'radio',
            inputOptions: {
                '2': 'Aprobado',
                '3': 'Reprobado'
            },
            inputValidator: (value) => !value && 'Debe seleccionar una opción',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const intershipStatus = result.value;
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=culminar_inscripcion`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}&intership_status=${intershipStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Éxito!', data.message, 'success');
                        listarInscripciones('activos');
                        listarInscripciones('inactivos');
                    } else {
                         Swal.fire('Error', data.error, 'error');
                    }
                })
                .catch(error => Swal.fire('Error', 'Error de conexión al intentar culminar la práctica.', 'error'));
            }
        });
    };

    window.eliminarInscripcion = function(id) {
        Swal.fire({
            title: '¿Eliminar Inscripción?',
            text: "La inscripción se moverá a la lista de inactivas.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=eliminar_inscripcion&id=${id}`, { method: "POST" })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Eliminada!', data.message, 'success');
                            listarInscripciones('activos');
                            listarInscripciones('inactivos');
                        } else {
                            Swal.fire('Error', data.error, 'error');
                        }
                    }).catch(() => Swal.fire('Error', "Error de conexión.", 'error'));
            }
        });
    };

    window.activarInscripcion = function(id) {
        Swal.fire({
            title: '¿Activar Inscripción?',
            text: "¿Deseas restaurar esta inscripción a la lista de activas?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, activar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=activar_inscripcion&id=${id}`, { method: "POST" })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Activada!', data.message, 'success');
                            listarInscripciones('activos');
                            listarInscripciones('inactivos');
                        } else {
                            Swal.fire('Error', data.error, 'error');
                        }
                    }).catch(() => Swal.fire('Error', "Error de conexión.", 'error'));
            }
        });
    };

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
        listarInscripciones(tab); // Call listarInscripciones when tab changes
    };

    // Si necesitas cargar selects dinámicamente, agrega aquí tus AJAX para llenar los combos
    listarInscripciones('activos');
    listarInscripciones('inactivos');
});
