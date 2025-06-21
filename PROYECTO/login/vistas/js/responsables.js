$(document).ready(function () {
    const formulario = document.getElementById("formulario");
    const dialog = document.getElementById("dialog-responsable");
    let editando = false;

    // --- Helpers ---
    function mostrarMensaje(titulo, texto, icono) {
        return Swal.fire({
            title: titulo,
            text: texto,
            icon: icono,
            confirmButtonText: 'Aceptar'
        });
    }

    // --- Limpieza y reseteo del modal ---
    function limpiarFormulario() {
        formulario.reset();
        $('#id_form').val('');
        $('#dialogResponsableTitle').text('Registrar Responsable');
        $('#formulario input, #formulario select').prop('disabled', false);
        $('.formulario__btn').show();

        // Limpiar errores de validación
        $('.formulario__input-error').hide();
        editando = false;
    }

    dialog.addEventListener('close', limpiarFormulario);

    // --- Carga de datos inicial ---
    function cargarInstituciones() {
        fetch("../controllers/Institucion/Institucion.php?accion=instituciones_select")
            .then(res => res.json())
            .then(data => {
                const select = $("#INSTITUTION_ID");
                select.html('<option value="" disabled selected>Seleccione una institución</option>');
                data.forEach(inst => {
                    select.append(`<option value="${inst.id}">${inst.nombre}</option>`);
                });
            });
    }

    function listarResponsables(tipo = 'activos') {
        const endpoint = tipo === 'activos' ? 'listar_activas' : 'listar_inactivas';
        const tablaId = `#datos-responsables-${tipo}`;

        fetch(`../controllers/institution_manager/InstitutionManager.php?accion=${endpoint}`)
            .then(response => response.json())
            .then(data => {
                let template = '';
                if (data.length > 0) {
                    data.forEach(p => {
                        template += `
                            <tr data-id="${p.MANAGER_ID}">
                                <td>${p.MANAGER_CI}</td>
                                <td>${p.NAME} ${p.SECOND_NAME ?? ''}</td>
                                <td>${p.SURNAME} ${p.SECOND_SURNAME ?? ''}</td>
                                <td>${p.CONTACT_PHONE}</td>
                                <td>${p.EMAIL}</td>
                                <td>${p.INSTITUTION_NAME ?? ''}</td>
                                <td>
                                    ${tipo === 'activos' ? `
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="task-action task-edit" data-id="${p.MANAGER_ID}" title="Editar">
                                                <span class="texto">Editar</span><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                            </button>
                                            <button class="task-action task-delete" data-id="${p.MANAGER_ID}" title="Desactivar">
                                                <span class="texto">Borrar</span><span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                            </button>
                                            <button class="task-action task-view" data-id="${p.MANAGER_ID}" title="Ver">
                                                <span class="texto">Ver</span><span class="icon"><i class="fa-solid fa-search"></i></span>
                                            </button>
                                        </div>` : `
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button class="task-action task-restore" data-id="${p.MANAGER_ID}" title="Restaurar">
                                                <span class="texto">Restaurar</span><span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                            </button>
                                            <button class="task-action task-view" data-id="${p.MANAGER_ID}" title="Ver">
                                                <span class="texto">Ver</span><span class="icon"><i class="fa-solid fa-search"></i></span>
                                            </button>
                                        </div>`
                                    }
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    template = `<tr><td colspan="7">No hay responsables ${tipo}.</td></tr>`;
                }
                $(tablaId).html(template);
            });
    }

    // --- Manejadores de eventos ---

    // Abrir modal para nuevo registro
    $('.primary').on('click', function () {
        limpiarFormulario();
        dialog.showModal();
    });

    // Cerrar modal con el botón 'x'
    $('.x').on('click', function () {
        dialog.close();
    });

    // Cambiar de pestaña
    $('.tabs').on('click', '.tab-button', function () {
        const tab = $(this).data('tab');
        $('.tab-button').removeClass('active');
        $(this).addClass('active');

        if (tab === 'activos') {
            $('#datos-responsables-activos').show();
            $('#datos-responsables-inactivos').hide();
        } else {
            $('#datos-responsables-activos').hide();
            $('#datos-responsables-inactivos').show();
        }
        listarResponsables(tab);
    });

    // --- CRUD y Acciones ---

    function poblarFormulario(data) {
        const cedula = (data.MANAGER_CI || '').split('-');
        $('#id_form').val(data.MANAGER_ID);
        $('#nacionalidad').val(cedula[0] ?? 'V');
        $('#MANAGER_CI').val(cedula[1] ?? '');
        $('#NAME').val(data.NAME ?? '');
        $('#SECOND_NAME').val(data.SECOND_NAME ?? '');
        $('#SURNAME').val(data.SURNAME ?? '');
        $('#SECOND_SURNAME').val(data.SECOND_SURNAME ?? '');
        
        const telefonoCompleto = data.CONTACT_PHONE || '';
        const partesTelefono = telefonoCompleto.split('-');
        if (partesTelefono.length === 2) {
            $('#prefijo_telefono').val(partesTelefono[0]);
            $('#CONTACT_PHONE').val(partesTelefono[1]);
        } else {
            $('#prefijo_telefono').val('0412');
            $('#CONTACT_PHONE').val(telefonoCompleto);
        }

        $('#EMAIL').val(data.EMAIL);
        $('#INSTITUTION_ID').val(data.INSTITUTION_ID);
    }

    // Ver
    $(document).on('click', '.task-view', function () {
        const id = $(this).data('id');
        fetch(`../controllers/institution_manager/InstitutionManager.php?accion=buscar&id=${id}`)
            .then(res => res.json())
            .then(data => {
                limpiarFormulario();
                poblarFormulario(data);
                $('#dialogResponsableTitle').text('Consultar Responsable');
                $('#formulario input, #formulario select').prop('disabled', true);
                $('.formulario__btn').hide();
                dialog.showModal();
            })
            .catch(err => mostrarMensaje('Error', 'No se pudieron cargar los datos para consultar.', 'error'));
    });

    // Editar
    $(document).on('click', '.task-edit', function () {
        const id = $(this).data('id');
        fetch(`../controllers/institution_manager/InstitutionManager.php?accion=buscar&id=${id}`)
            .then(res => res.json())
            .then(data => {
                limpiarFormulario();
                editando = true;
                poblarFormulario(data);
                $('#dialogResponsableTitle').text('Editar Responsable');
                dialog.showModal();
            })
            .catch(err => mostrarMensaje('Error', 'No se pudieron cargar los datos para editar.', 'error'));
    });

    // Guardar o Actualizar
    $('#formulario').on('submit', function (e) {
        e.preventDefault();
        dialog.close();

        Swal.fire({
            title: '¿Confirmar acción?',
            text: editando ? '¿Deseas actualizar este responsable?' : '¿Deseas registrar un nuevo responsable?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) {
                dialog.showModal();
                return;
            }

            const formData = new FormData(formulario);
            const id = formData.get("id_form");
            formData.set("CONTACT_PHONE", `${$('#prefijo_telefono').val()}-${$('#CONTACT_PHONE').val()}`);
            formData.append("accion", id ? "actualizar" : "insertar");
            formData.append("id", id);

            fetch("../controllers/institution_manager/InstitutionManager.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    mostrarMensaje('Éxito', res.message || 'Operación exitosa', 'success');
                    listarResponsables('activos');
                    listarResponsables('inactivos');
                } else {
                    mostrarMensaje('Error', res.message || res.error || "Error al guardar", 'error')
                        .then(() => dialog.showModal());
                }
            })
            .catch(err => {
                mostrarMensaje('Error', 'Error de comunicación con el servidor.', 'error')
                    .then(() => dialog.showModal());
            });
        });
    });

    // Eliminar (Desactivar)
    $(document).on('click', '.task-delete', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Desactivar responsable?',
            text: "Esta acción moverá el responsable a la lista de inactivos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, desactivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = new FormData();
                form.append("accion", "eliminar");
                form.append("id", id);

                fetch("../controllers/institution_manager/InstitutionManager.php", { method: "POST", body: form })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            mostrarMensaje('Desactivado', 'El responsable ha sido desactivado.', 'success');
                            listarResponsables('activos');
                            listarResponsables('inactivos');
                        } else {
                            mostrarMensaje('Error', res.message || res.error || "No se pudo desactivar.", 'error');
                        }
                    });
            }
        });
    });

    // Restaurar
    $(document).on('click', '.task-restore', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Restaurar responsable?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = new FormData();
                form.append("accion", "restaurar");
                form.append("id", id);

                fetch("../controllers/institution_manager/InstitutionManager.php", { method: "POST", body: form })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            mostrarMensaje('Restaurado', res.message || 'El responsable ha sido restaurado.', 'success');
                            listarResponsables('activos');
                            listarResponsables('inactivos');
                        } else {
                            mostrarMensaje('Error', res.message || res.error || "No se pudo restaurar.", 'error');
                        }
                    });
            }
        });
    });

    // --- Validaciones en tiempo real ---
    $('#MANAGER_CI').on("blur", function () {
        const nacionalidad = $('#nacionalidad').val();
        const cedula = $(this).val().trim();
        const id = $('#id_form').val();
        const errorElement = $('#error-cedula');

        if (cedula) {
            const cedulaCompleta = `${nacionalidad}-${cedula}`;
            fetch(`../controllers/institution_manager/InstitutionManager.php?accion=validar_cedula&cedula=${encodeURIComponent(cedulaCompleta)}&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    errorElement.toggle(data.existe);
                });
        }
    });

    $('#EMAIL').on("blur", function () {
        const correo = $(this).val().trim();
        const id = $('#id_form').val();
        const errorElement = $('#error-correo');

        if (correo) {
            fetch(`../controllers/institution_manager/InstitutionManager.php?accion=validar_correo&correo=${encodeURIComponent(correo)}&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    errorElement.toggle(data.existe);
                });
        }
    });

    // --- Inicialización ---
    cargarInstituciones();
    listarResponsables('activos');
    listarResponsables('inactivos');
});
