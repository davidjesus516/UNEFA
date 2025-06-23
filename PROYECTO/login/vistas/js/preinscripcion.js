cargarPeriodos();

let dialog; // Declara la variable dialog fuera del DOMContentLoaded para que sea accesible globalmente en el script.

// Nueva función para mostrar mensajes con SweetAlert2
function mostrarMensaje(mensaje, tipo = 'info') {
    Swal.fire({
        title: tipo.charAt(0).toUpperCase() + tipo.slice(1), // Capitalize
        text: mensaje,
        icon: tipo,
        confirmButtonText: 'Aceptar'
    });
}

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
                    let accionesHtml = '';
                    if (tipo === 'activos') {
                        accionesHtml = `
                            <td><button class="task-view" onclick="verInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Ver</span><span class="icon"><i class="fa-solid fa-eye"></i></span></button></td>
                            <td><button class="task-delete" onclick="eliminarInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Borrar</span><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button></td>
                            <td></td>`;
                    } else {
                        accionesHtml = `
                            <td><button class="task-restore" onclick="activarInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Restaurar</span><span class="icon"><i class="fa-solid fa-rotate-left"></i></span></button></td>
                            <td></td>
                            <td></td>`;
                    }
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.STUDENTS_CI || ''}</td>
                        <td>${row.ESTUDIANTE || ''}</td>
                        <td>${row.CONTACTO || row.CONTACT_PHONE || row.PHONE || ''}</td>
                        <td>${row.PERIOD_DESCRIPTION || ''}</td>
                        <td>${row.ENROLLMENT || ''}</td>
                        <td>${row.CREATION_DATE ? new Date(row.CREATION_DATE).toLocaleDateString() : ''}</td>
                        ${accionesHtml}
                    `;
                    tbody.appendChild(tr);
                });
            } else if (data.mensaje) {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td colspan="9">${data.mensaje}</td>`;
                tbody.appendChild(tr);
            }
        })
        .catch(() => {
            tbody.innerHTML = `<tr><td colspan="9">Error al cargar inscripciones ${tipo}</td></tr>`;
        });
}

document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.primary').addEventListener('click', function() {
        document.getElementById('cedula').disabled = false; // Habilitar campo de cédula
        document.getElementById('nacionalidad').disabled = false; // Habilitar nacionalidad
        document.getElementById('reprobado_practice_id').value = ''; // Clear reprobado ID
        document.getElementById('dialog').showModal();
        document.getElementById('formulario').reset();
        document.getElementById('id_form').value = ''; // Resetear ID del formulario
    });
    const formulario = document.getElementById("formulario"); // formulario puede seguir siendo local
    dialog = document.getElementById("dialog"); // Asigna el elemento del modal a la variable global
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

            const fullCedula = `${nacionalidad}-${cedulaInput.value}`;

            // First, try to find a reprobado practice
            fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_reprobada_por_cedula&cedula=${fullCedula}`)
                .then(res => {
                    if (res.ok) return res.json();
                    throw new Error('No reprobado practice found or error fetching.');
                })
                .then(reprobadoData => {
                    // If a reprobado practice is found, populate fields and set flag
                    document.getElementById("id_estudiante").value = reprobadoData.STUDENTS_ID;
                    document.getElementById("Estudiante").value = reprobadoData.NOMBRE_COMPLETO; // Assuming NOMBRE_COMPLETO is returned
                    document.getElementById("matricula").value = ''; // Matricula might not be relevant for reprobado re-registration
                    document.getElementById("reprobado_practice_id").value = reprobadoData.PROFESSIONAL_PRACTICE_ID;
                    isCorrect("grupo__cedula");
                    mostrarMensaje(`Se encontró una práctica reprobada (${reprobadoData.INTERNSHIP_TYPE_NAME} - ${reprobadoData.PERIOD_DESCRIPTION}). Puede preinscribir una nueva práctica.`, 'info');

                    // Load internship types for the student's career (assuming career_id is available in reprobadoData or can be fetched)
                    // For simplicity, let's re-use the buscar_por_cedula to get combos
                    return fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_por_cedula&cedula=${fullCedula}`);
                })
                .catch(error => {
                    // If no reprobado practice, proceed with normal student lookup
                    document.getElementById("reprobado_practice_id").value = ''; // Clear reprobado ID
                    return fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_por_cedula&cedula=${fullCedula}`);
                })
                .then(res => {
                    if (!res.ok) throw new Error('Estudiante no encontrado.');
                    return res.json();
                })
                .then(studentData => {
                    if (studentData) {
                        document.getElementById("id_estudiante").value = studentData.STUDENTS_ID;
                        document.getElementById("Estudiante").value = studentData.NOMBRE_COMPLETO;
                        document.getElementById("matricula").value = studentData.ENROLLMENT || '';
                        isCorrect("grupo__cedula");
                        document.getElementById("tipo_practica").innerHTML = '';
                        if (studentData['combos'] && Array.isArray(studentData['combos'].internship_types)) {
                            studentData['combos'].internship_types.forEach(tipo => {
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
                        document.getElementById("id_form").value = ''; // Reset form ID if student not found
                        document.getElementById("Estudiante").value = 'estudiante no encontrado';
                        isIncorrect("grupo__cedula", "Estudiante no encontrado");
                    }
                })
                .catch(error => {
                    document.getElementById("id_form").value = '';
                    document.getElementById("id_estudiante").value = '';
                    document.getElementById("Estudiante").value = 'Estudiante no encontrado';
                    document.getElementById("matricula").value = '';
                    document.getElementById("tipo_practica").innerHTML = '<option value="" disabled selected>Cargando...</option>'; // Reset type practice
                    isIncorrect("grupo__cedula", error.message);
                });
        } else {
            this.setCustomValidity("Formato inválido. Debe tener entre 7 y 8 dígitos.");
        }

    });

    // Registrar o actualizar Preinscripción
    formulario.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(formulario);
        const id = formData.get("id_form");
        const reprobadoPracticeId = document.getElementById('reprobado_practice_id').value;

        if (reprobadoPracticeId) {
            formData.append('reprobado_practice_id', reprobadoPracticeId);
        }


        const accion = id ? "actualizar_preinscripcion" : "insertar_preinscripcion";
        formData.append("id", id);

        fetch(`../controllers/profesional_practices/profesional_practices.php?accion=${accion}`, {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    dialog.close();
                    mostrarMensaje(res.message || "Operación exitosa", 'Exito');
                    formulario.reset();
                    listarPreinscripciones('activos');
                    listarPreinscripciones('inactivos');
                } else {
                    mostrarMensaje(res.error || "Error al guardar", 'error');
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
                    document.getElementById("cedula").disabled = true; // Disable cedula field
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
    // 4. eliminarInscripcion: elimina una Preinscripción activa
    window.eliminarInscripcion = function (id) {
        Swal.fire({
            title: '¿Eliminar Preinscripción?',
            text: "¿Estás seguro? La Preinscripción se moverá a la lista de inactivas.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=eliminar_preinscripcion&id=${id}`, {
                        method: "POST"
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            mostrarMensaje(data.message || "Preinscripción eliminada exitosamente", 'Exito');
                            listarPreinscripciones('activos');
                            listarPreinscripciones('inactivos');
                        } else {
                            mostrarMensaje(data.error || "Error al eliminar la preinscripción", 'error');
                        }
                    }).catch(() => {
                        mostrarMensaje("Error de conexión al intentar eliminar.", 'error');
                    });
            }
        });
    };
    // 5. activarInscripcion: activa una Preinscripción inactiva
    window.activarInscripcion = function (id) {
        Swal.fire({
            title: '¿Activar Preinscripción?',
            text: "¿Estás seguro de que deseas activar esta Preinscripción?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, activar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`../controllers/profesional_practices/profesional_practices.php?accion=activar_preinscripcion&id=${id}`, {
                        method: "POST"
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            mostrarMensaje(data.message || "Preinscripción activada exitosamente", 'Exito');
                            listarPreinscripciones('activos');
                            listarPreinscripciones('inactivos');
                        } else {
                            mostrarMensaje(data.error || "Error al activar la preinscripción", 'error');
                        }
                    }).catch(() => {
                        mostrarMensaje("Error de conexión al intentar activar.", 'error');
                    });
            }
        });
    };

    // Cerrar modal con el botón 'x'
    $('.x').on('click', function () {
        dialog.close(); // Usa la variable dialog que ahora es accesible globalmente en el script
    });

    // 3. cambiarTab: muestra/oculta correctamente los tbodys de activos/inactivos
    window.cambiarTab = function (tab) {
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

    // 2. verInscripcion: muestra los datos en el formulario para visualizar
    window.verInscripcion = function (id) {
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
                    document.getElementById("cedula").disabled = true; // Disable cedula field
                    document.getElementById("nacionalidad").value = data.NACIONALIDAD || '';
                    document.getElementById("nacionalidad").disabled = true; // Deshabilitar nacionalidad
                    document.getElementById("Estudiante").value = data.ESTUDIANTE || '';
                    document.getElementById("id_estudiante").value = data.STUDENTS_ID || '';
                    document.querySelector('.formulario__btn').style.display = 'none';
                    document.getElementById("periodo").value = data.PERIOD_ID || '';
                    document.getElementById("tipo_practica").value = data.INTERNSHIP_TYPE_ID || '';
                    document.getElementById("matricula").value = data.ENROLLMENT || '';

                    // Deshabilitar todos los campos del formulario
                    const form = document.getElementById("formulario");
                    form.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);

                    dialog.showModal();
                }
            });
    };

    // Escuchar el evento de cierre del diálogo
    document.getElementById("dialog").addEventListener('close', function () {
        // Habilitar todos los campos del formulario
        const form = document.getElementById("formulario");
        form.querySelectorAll('input, select, textarea, button').forEach(el => el.disabled = false);

        // Mostrar el botón de guardar y resetear el formulario
        document.querySelector('.formulario__btn').style.display = '';
    });