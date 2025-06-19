document.addEventListener("DOMContentLoaded", function () {
    // Ensure window.dialog points to the dialog element
    window.dialog = document.getElementById('dialog');

    // SweetAlert2 Helper Functions
    function mostrarMensajeExito(mensaje, callback) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensaje,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            if (typeof callback === 'function') {
                callback();
            }
        });
    }

    function mostrarMensajeError(mensaje, callback) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            if (typeof callback === 'function') {
                callback();
            }
        });
    }

    const expresiones = {
        nombre: /^[a-zA-ZÀ-ÿ\s]{5,100}$/, // 5-100 letras y espacios
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

    async function validateForm() {
        let errores = false;
        // Validate name
        if (!validateInput(document.getElementById('nombre'), expresiones.nombre, 'grupo__nombre', 'El nombre debe contener entre 5 y 100 caracteres alfanuméricos')) {
            errores = true;
        }
        // Validate priority
        const prioridad = document.getElementById('prioridad').value;
        if (!['0', '1', '2'].includes(prioridad)) {
            isIncorrect('grupo__prioridad', 'Seleccione una prioridad válida (0, 1 o 2)');
            errores = true;
        } else {
            isCorrect('grupo__prioridad');
        }
        return !errores;
    }

    function listarPracticas(tipo) {
        const endpoint = tipo === 'activos' ? 'listar_activos' : 'listar_inactivos';
        const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';
        fetch(`../controllers/tipo_practica/TipoPractica.php?accion=${endpoint}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById(tablaId).innerHTML = '';
                if (data.length > 0) {
                    data.forEach(practica => {
                        let acciones = '';
                        // Normalize property names, preferring INTERNSHIP_TYPE_ID and NAME
                        const id = practica.INTERNSHIP_TYPE_ID || practica.id;
                        const name = practica.NAME || practica.name;
                        const priority = practica.PRIORITY ?? practica.priority;

                        if (tipo === 'activos') {
                            acciones = `
                                <button class="task-edit" onclick="editarPractica(${id})" title="Editar">
                                    <span class="texto">Editar</span>
                                    <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                </button>
                                <button class="task-delete" onclick="eliminarPractica(${id})" title="Eliminar">
                                    <span class="texto">Borrar</span>
                                    <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                </button>
                            `;
                        } else {
                            acciones = `
                                <button class="task-restore" onclick="activarPractica(${id})" title="Restaurar">
                                    <span class="texto">Restaurar</span>
                                    <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                </button>
                            `;
                        }
                        document.getElementById(tablaId).innerHTML += `
                                <tr>
                                    <td>${name}</td>
                                    <td>${priority}</td>
                                    <td colspan="2">
                                        <div class="acciones-practica">
                                            ${acciones}
                                        </div>
                                    </td>
                                </tr>
                        `;
                    });
                } else {
                    document.getElementById(tablaId).innerHTML = '<tr><td colspan="3">No hay registros disponibles.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error al listar prácticas:', error);
                mostrarMensajeError('Error al cargar la lista de prácticas. Intente de nuevo.');
            });
    }

    // Initialize both lists
    listarPracticas('activos');
    listarPracticas('inactivos');

    // Handle form submission
    document.getElementById('formulario').addEventListener('submit', async function (e) {
        e.preventDefault();

        // 1. Save dialog state and close it before any Swal.fire
        const wasDialogOpen = window.dialog && window.dialog.open;
        if (wasDialogOpen) {
            window.dialog.close();
        }

        // 2. Validate the form
        if (!(await validateForm())) {
            mostrarMensajeError('Por favor, corrige los errores antes de enviar el formulario.', () => {
                // Reopen the dialog only if it was open and needs correction
                if (wasDialogOpen && !window.dialog.open) {
                    window.dialog.showModal();
                }
            });
            return;
        }

        // If validation passes, proceed with submission confirmation
        Swal.fire({
            title: '¿Quieres proceder con el registro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(async (result) => {
            if (!result.isConfirmed) {
                // If submission was canceled, reopen the dialog if it was open
                if (wasDialogOpen && !window.dialog.open) {
                    window.dialog.showModal();
                }
                console.log('Registro cancelado por el usuario.');
                return;
            }

            // If submission confirmed
            const formData = new FormData(this);
            const id = formData.get("id_form");
            formData.append("id", id);

            try {
                const response = await fetch(`../controllers/tipo_practica/TipoPractica.php?accion=${id ? 'actualizar' : 'insertar'}`, {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    mostrarMensajeExito(data.message || 'Operación exitosa', () => {
                        // Close the dialog if it's still open after success
                        if (window.dialog && window.dialog.open) {
                            window.dialog.close();
                        }
                        this.reset();
                        // Reset visual validations
                        document.querySelectorAll('.formulario__grupo-correcto, .formulario__grupo-incorrecto').forEach(el => {
                            el.classList.remove('formulario__grupo-correcto', 'formulario__grupo-incorrecto');
                        });
                        document.querySelectorAll('.formulario__input-error-activo').forEach(el => {
                            el.classList.remove('formulario__input-error-activo');
                        });
                        document.querySelectorAll('.formulario__grupo i').forEach(icon => {
                            icon.classList.remove("fa-check-circle", "fa-times-circle");
                        });
                        listarPracticas('activos');
                        listarPracticas('inactivos');
                    });
                } else {
                    mostrarMensajeError('Error: ' + (data.error || 'No se pudo completar la operación'), () => {
                        // Reopen the dialog if there was an error and it was open
                        if (wasDialogOpen && !window.dialog.open) {
                            window.dialog.showModal();
                        }
                    });
                }
            } catch (error) {
                console.error('Error al enviar formulario:', error);
                mostrarMensajeError('Error de red o del servidor al enviar el formulario.', () => {
                    // Reopen the dialog if there was a network error and it was open
                    if (wasDialogOpen && !window.dialog.open) {
                        window.dialog.showModal();
                    }
                });
            }
        });
    });

    // Event listener for "Crear nuevo" button
    document.querySelector('.primary').addEventListener('click', function () {
        document.getElementById('dialog').showModal();
        document.getElementById('formulario').reset();
        document.getElementById('id_form').value = ''; // Reset form ID
        // Reset visual validations
        document.querySelectorAll('.formulario__grupo-correcto, .formulario__grupo-incorrecto').forEach(el => {
            el.classList.remove('formulario__grupo-correcto', 'formulario__grupo-incorrecto');
        });
        document.querySelectorAll('.formulario__input-error-activo').forEach(el => {
            el.classList.remove('formulario__input-error-activo');
        });
        document.querySelectorAll('.formulario__grupo i').forEach(icon => {
            icon.classList.remove("fa-check-circle", "fa-times-circle");
        });
    });

    window.editarPractica = function (id) {
        console.log('ID recibido para editar:', id);
        fetch(`../controllers/tipo_practica/TipoPractica.php?accion=buscar_para_editar&id=${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.length > 0) {
                    const practica = data[0];
                    document.getElementById("id_form").value = practica.INTERNSHIP_TYPE_ID || practica.id;
                    document.getElementById('nombre').value = practica.NAME || practica.name;
                    document.getElementById('prioridad').value = practica.PRIORITY ?? practica.priority;
                    document.getElementById('dialog').showModal();
                    // Reset visual validations before showing existing data
                    document.querySelectorAll('.formulario__grupo-correcto, .formulario__grupo-incorrecto').forEach(el => {
                        el.classList.remove('formulario__grupo-correcto', 'formulario__grupo-incorrecto');
                    });
                    document.querySelectorAll('.formulario__input-error-activo').forEach(el => {
                        el.classList.remove('formulario__input-error-activo');
                    });
                    document.querySelectorAll('.formulario__grupo i').forEach(icon => {
                        icon.classList.remove("fa-check-circle", "fa-times-circle");
                    });
                    // Run validation for existing data to show correct/incorrect state
                    validateInput(document.getElementById('nombre'), expresiones.nombre, 'grupo__nombre');
                    const prioridad = document.getElementById('prioridad').value;
                    if (!['0', '1', '2'].includes(prioridad)) {
                        isIncorrect('grupo__prioridad', 'Seleccione una prioridad válida (0, 1 o 2)');
                    } else {
                        isCorrect('grupo__prioridad');
                    }
                } else {
                    mostrarMensajeError('No se encontró la práctica con el ID proporcionado.');
                }
            })
            .catch(error => {
                console.error('Error al buscar la práctica:', error);
                mostrarMensajeError('Error al cargar los datos de la práctica para edición. Intente de nuevo.');
            });
    };

    window.eliminarPractica = function (id) {
        // Close the dialog if it's open before any Swal.fire
        if (window.dialog && window.dialog.open) {
            window.dialog.close();
        }

        Swal.fire({
            title: '¿Está seguro de desactivar esta práctica?',
            text: "¡Esto la moverá a la lista de prácticas inactivas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, desactivar!',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', id);
                fetch('../controllers/tipo_practica/TipoPractica.php?accion=eliminar', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            mostrarMensajeExito(data.message || 'Práctica desactivada correctamente.');
                            listarPracticas('activos');
                            listarPracticas('inactivos');
                        } else {
                            mostrarMensajeError('Error: ' + (data.error || 'No se pudo desactivar la práctica.'));
                        }
                    })
                    .catch(error => {
                        console.error('Error al desactivar la práctica:', error);
                        mostrarMensajeError('Error de red o del servidor al desactivar la práctica.');
                    });
            }
        });
    };

    window.activarPractica = function (id) {
        // Close the dialog if it's open before any Swal.fire
        if (window.dialog && window.dialog.open) {
            window.dialog.close();
        }

        Swal.fire({
            title: '¿Está seguro de reactivar esta práctica?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, reactivar!',
            cancelButtonText: 'No',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', id);
                fetch('../controllers/tipo_practica/TipoPractica.php?accion=restaurar', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            mostrarMensajeExito(data.message || 'Práctica reactivada correctamente.');
                            listarPracticas('activos');
                            listarPracticas('inactivos');
                        } else {
                            mostrarMensajeError('Error: ' + (data.error || 'No se pudo reactivar la práctica.'));
                        }
                    })
                    .catch(error => {
                        console.error('Error al reactivar la práctica:', error);
                        mostrarMensajeError('Error de red o del servidor al reactivar la práctica.');
                    });
            }
        });
    };

    window.cambiarTab = function (tab, event) {
        // Change active buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        if (event) event.target.classList.add('active');
        // Show/hide tables
        if (tab === 'activos') {
            document.getElementById('datos-activos').style.display = '';
            document.getElementById('datos-inactivos').style.display = 'none';
            listarPracticas('activos'); // Refresh the active list
        } else {
            document.getElementById('datos-activos').style.display = 'none';
            document.getElementById('datos-inactivos').style.display = '';
            listarPracticas('inactivos'); // Refresh the inactive list
        }
    };
});