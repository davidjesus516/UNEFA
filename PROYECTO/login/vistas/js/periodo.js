$(document).ready(() => {
    let edit = false;
    let errores = false;
    let currentEditStatus = 1;
    let currentEditPeriodStatus = 1;

    console.log("jQuery está funcionando");

    // Asegúrate de que window.dialog apunte al elemento dialog
    window.dialog = document.getElementById('dialog');

    // Mostrar solo activos al cargar la página
    $('#datos-activos').show();
    $('#datos-inactivos').hide();
    $('.tab-button').removeClass('active');
    $('.tab-button').first().addClass('active');

    fetchTask();

    // Manejador de cambio de fecha de inicio
    $('#periodo_inicio').change(function () {
        const fechaInicio = $(this).val();
        if (!fechaInicio) return;

        const numweeks = 16;
        const fechaInicioDate = new Date(fechaInicio);
        const minDate = new Date(fechaInicioDate.getTime() + numweeks * 7 * 24 * 60 * 60 * 1000);
        const formattedMinDate = minDate.toISOString().split('T')[0];

        $('#periodo_fin').attr('min', formattedMinDate);

        const fechaFinActual = $('#periodo_fin').val();
        if (!fechaFinActual || fechaFinActual < formattedMinDate) {
            $('#periodo_fin').val(formattedMinDate);
        }
    });

    // Manejador de cambio del lapso académico
    $('#lapso-academico').change(function () {
        const lapsoYear = $(this).val();
        if (!lapsoYear) return;

        const minDate = `${lapsoYear}-01-01`;
        const maxDate = `${lapsoYear}-12-31`;
        $('#periodo_inicio').attr('min', minDate).attr('max', maxDate);

        const currentStart = $('#periodo_inicio').val();
        if (!currentStart || currentStart.substring(0, 4) !== lapsoYear) {
            $('#periodo_inicio').val(minDate).trigger('change');
        }
    });

    // Manejador de envío del formulario
    $('#formulario').submit(function (e) {
        e.preventDefault();

        const lapsoYear = $('#lapso-academico').val();
        const turnoVal = $('#turno').val(); // Captura el valor del turno aquí
        const startDate = $('#periodo_inicio').val();
        const endDate = $('#periodo_fin').val();

        // ** CIERRA EL DIALOG ANTES DE CUALQUIER VALIDACIÓN QUE MUESTRE SWEETALERT2 **
        // Esto asegura que SweetAlert2 siempre se muestre por encima del modal.
        const wasDialogOpen = window.dialog && window.dialog.open;
        if (wasDialogOpen) {
            window.dialog.close();
        }

        // Validaciones previas a la confirmación de envío
        if (errores) {
            mostrarMensajeError("Debe llenar correctamente el formulario", () => {
                // Si el dialog estaba abierto, lo reabrimos para que el usuario corrija.
                if (wasDialogOpen && !window.dialog.open) {
                    window.dialog.showModal();
                }
            });
            return;
        }

        if (lapsoYear && startDate) {
            const startYear = new Date(startDate).getFullYear().toString();
            if (lapsoYear !== startYear) {
                mostrarMensajeError("El año de la fecha de inicio debe coincidir con el año del lapso académico seleccionado.", () => {
                    // ** AQUÍ ES DONDE AÑADIMOS LA REAPERTURA DEL MODAL **
                    // Si el dialog estaba abierto, lo reabrimos para que el usuario corrija.
                    if (wasDialogOpen && !window.dialog.open) {
                        window.dialog.showModal();
                    }
                });
                return;
            }
        }

        if (startDate && endDate) {
            const diffDays = (new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24);
            if (diffDays < 112) {
                mostrarMensajeError("La fecha de cierre debe ser al menos 16 semanas después de la fecha de inicio.", () => {
                    // Si el dialog estaba abierto, lo reabrimos para que el usuario corrija.
                    if (wasDialogOpen && !window.dialog.open) {
                        window.dialog.showModal();
                    }
                });
                return;
            }
        }
        
        // Si todas las validaciones previas pasan, ahora mostramos la confirmación de envío.
        // El dialog ya debería estar cerrado por la lógica inicial del submit.
        Swal.fire({
            title: '¿Quieres proceder con el registro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            // Reabre el dialog solo si se CANCELÓ la confirmación de envío.
            if (!result.isConfirmed) {
                if (wasDialogOpen && !window.dialog.open) { // Si el dialog estaba abierto antes del Swal
                    window.dialog.showModal(); // Lo reabrimos para que el usuario siga editando.
                }
                console.log('Registro cancelado por el usuario.');
                return; // No proceder con AJAX
            }

            // Si se confirmó el envío
            const postData = {
                DESCRIPTION: `${lapsoYear}-${turnoVal}`, 
                START_DATE: startDate,
                END_DATE: endDate,
                PERIOD_STATUS: 1,
                STATUS: 1
            };

            if (edit) {
                postData.id = $('#PERIOD_ID').val();
                postData.PERIOD_STATUS = currentEditPeriodStatus;
                postData.STATUS = currentEditStatus;
            }

            const url = '../controllers/periodo/Periodo.php?accion=' + (edit ? 'actualizar' : 'insertar');
            $.ajax({
                url,
                type: 'POST',
                dataType: 'json',
                data: postData,
                success: response => handleFormResponse(response),
                error: xhr => mostrarMensajeError(`Error en el servidor: ${xhr.statusText}`, () => {
                    // Si hubo un error en el AJAX y el dialog estaba abierto, lo reabrimos.
                    if (wasDialogOpen && !window.dialog.open) {
                        window.dialog.showModal();
                    }
                })
            });
        });
    });

    // Función para manejar la respuesta del formulario
    const handleFormResponse = response => {
        if (response.success) {
            mostrarMensajeExito('Operación exitosa', () => {
                fetchTask();
                // El dialog se cierra con éxito aquí
                if (window.dialog && window.dialog.open) {
                    window.dialog.close(); 
                }
                resetFormFields(); // Limpiar el formulario solo después de un envío exitoso
            });
        } else if (response.message) {
            // mostrarMensajeError ya maneja su propio callback.
            mostrarMensajeError(response.message); 
        } else {
            mostrarMensajeError('Error desconocido al procesar la solicitud');
        }
    }

    // Función para obtener y mostrar los períodos (sin cambios)
    function fetchTask() {
        $.ajax({
            url: '../controllers/periodo/Periodo.php?accion=listar',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                renderTasks(response);
            },
            error: function (xhr) {
                mostrarMensajeError(`Error al cargar los períodos: ${xhr.statusText}`);
            }
        });
    }

    // Nueva función para renderizar períodos en activos/inactivos (sin cambios)
    function renderTasks(data) {
        let templateActivos = '';
        let templateInactivos = '';

        (data.activos || []).forEach(task => {
            const statusInfo = getStatusInfo(task.PERIOD_STATUS);
            templateActivos += `
            <tr taskid="${task.PERIOD_ID}">
                <td>${task.DESCRIPTION}</td>
                <td>${task.START_DATE}</td>
                <td>${task.END_DATE}</td>
                <td>
                    <button class="task-status ${statusInfo.class}" data-id="${task.PERIOD_ID}" data-status="${task.PERIOD_STATUS}">
                        <span class="texto">${statusInfo.text}</span>
                        <span class="icon">${statusInfo.icon}</span>
                    </button>
                </td>
                <td>
                <button class="task-action task-edit" data-id="${task.PERIOD_ID}">
                <span class="texto">Editar</span>
                <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                </button>
                </td>
                <td>
                    <button class="task-action task-delete" data-id="${task.PERIOD_ID}">
                        <span class="texto">Borrar</span>
                        <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                    </button>
                </td>
            </tr>`;
        });

        (data.inactivos || []).forEach(task => {
            const statusInfo = getStatusInfo(task.PERIOD_STATUS);
            templateInactivos += `
        <tr taskid="${task.PERIOD_ID}">
            <td>${task.DESCRIPTION}</td>
            <td>${task.START_DATE}</td>
            <td>${task.END_DATE}</td>
            <td>
                <span class="${statusInfo.class}">
                    <span class="texto">${statusInfo.text}</span>
                </span>
            </td>
            <td colspan="2">
                <button class="task-action task-restore" data-id="${task.PERIOD_ID}">
                    <span class="texto">Restaurar</span>
                    <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                </button>
            </td>
        </tr>`;
        });

        $('#datos-activos').html(templateActivos);
        $('#datos-inactivos').html(templateInactivos);
    }

    // Función para obtener información del estado (sin cambios)
    function getStatusInfo(statusCode) {
        const statusMap = {
            1: {
                text: 'PENDIENTE',
                class: 'status-pending',
                icon: '<i class="fa-solid fa-clock" style="color: #ffffff;"></i>'
            },
            2: {
                text: 'EN CURSO',
                class: 'status-active',
                icon: '<i class="fa-solid fa-play" style="color: #ffffff;"></i>'
            },
            3: {
                text: 'CULMINADO',
                class: 'status-completed',
                icon: '<i class="fa-solid fa-check" style="color: #ffffff;"></i>'
            }
        };

        return statusMap[statusCode] || {
            text: 'DESCONOCIDO',
            class: 'status-unknown',
            icon: '<i class="fa-solid fa-question" style="color: #ffffff;"></i>'
        };
    }

    // Manejador para borrar período
    $(document).on('click', '.task-delete', function () {
        const PERIOD_ID = $(this).data('id');
        const $row = $(this).closest('tr');
        const statusText = $row.find('.task-status .texto').text().trim();

        const statusMap = {
            'PENDIENTE': 1,
            'EN CURSO': 2,
            'CULMINADO': 3
        };
        const currentStatus = statusMap[statusText];

        if (currentStatus === 2) {
            mostrarMensajeError('No se puede eliminar un período EN CURSO.');
            return;
        }
        if (currentStatus === 3) {
            mostrarMensajeError('No se puede eliminar un período CULMINADO.');
            return;
        }
        if (currentStatus !== 1) {
            mostrarMensajeError('Solo se pueden eliminar períodos en estado PENDIENTE.');
            return;
        }

        // Siempre cerrar el dialog si está abierto antes de cualquier Swal.fire
        if (window.dialog && window.dialog.open) {
            window.dialog.close();
        }

        Swal.fire({
            title: '¿Estás seguro de que deseas eliminar este registro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            // Aquí NO reabrimos el dialog si se cancela, porque esta acción no proviene del dialog
            if (result.isConfirmed) {
                $.ajax({
                    url: '../controllers/periodo/UserDelete.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { PERIOD_ID },
                    success: function (response) {
                        fetchTask();
                        if (response && response.success) {
                            mostrarMensajeExito(response.message || 'Período eliminado correctamente');
                        } else if (response && response.message) {
                            mostrarMensajeError(response.message);
                        } else {
                            mostrarMensajeExito('Período eliminado correctamente');
                        }
                    },
                    error: function (xhr) {
                        fetchTask();
                        mostrarMensajeError(`Error al eliminar: ${xhr.statusText}`);
                    }
                });
            }
        });
    });

    // Manejador para editar período
    $(document).on('click', '.task-edit', function () {
        const PERIOD_ID = $(this).data('id');
        const $row = $(this).closest('tr');
        const statusText = $row.find('.task-status .texto').text().trim();

        const statusMap = {
            'PENDIENTE': 1,
            'EN CURSO': 2,
            'CULMINADO': 3
        };
        const currentStatus = statusMap[statusText];

        if (currentStatus === 3) {
            mostrarMensajeError('No se puede editar un período CULMINADO.');
            return;
        }

        edit = true; // Establecemos el modo edición en true

        $.ajax({
            url: '../controllers/periodo/UserEditSearch.php',
            type: 'POST',
            dataType: 'json',
            data: { PERIOD_ID },
            success: function (response) {
                setupEditForm(response, currentStatus);
            },
            error: function (xhr) {
                // Aquí el error es al cargar los datos de edición, por lo que el dialog aún no se abrió.
                mostrarMensajeError(`Error al cargar datos: ${xhr.statusText}`);
            }
        });
    });

    // Función para configurar el formulario de edición
    function setupEditForm(response, currentStatus) {
        try {
            const task = response[0];
            const [year, turno] = task.DESCRIPTION.split('-');

            $('#lapso-academico').val(year);
            $('#turno').val(turno); 
            $('#periodo_inicio').val(task.START_DATE);
            $('#periodo_fin').val(task.END_DATE);
            $('#PERIOD_ID').val(task.PERIOD_ID);

            currentEditStatus = task.STATUS;
            currentEditPeriodStatus = task.PERIOD_STATUS;

            setupFieldsByStatus(task.PERIOD_STATUS);

            window.dialog.showModal(); // Muestra el dialog
            // Trigger change for validation and min date setup
            $('#periodo_inicio').trigger('change');

            if (currentStatus === 2) {
                $('#lapso-academico').prop('disabled', true);
                $('#turno').prop('disabled', true);
                $('#periodo_inicio').prop('disabled', true);
                $('#periodo_fin').prop('disabled', false);
            } else if (currentStatus === 1) {
                $('#lapso-academico').prop('disabled', false);
                $('#turno').prop('disabled', false);
                $('#periodo_inicio').prop('disabled', false);
                $('#periodo_fin').prop('disabled', false);
            }

        } catch (err) {
            console.error('Error al editar:', err, response);
            mostrarMensajeError('Error al cargar datos para edición');
        }
    }

    // Función para configurar campos según el estado (sin cambios)
    function setupFieldsByStatus(status) {
        const startDateGroup = $('.formulario__grupo:has(#periodo_inicio)');
        const endDateGroup = $('.formulario__grupo__input-group:has(#periodo_fin)');
        const submitButton = $('.formulario__btn');

        $('#periodo_inicio, #periodo_fin').prop('disabled', false);
        startDateGroup.add(endDateGroup).removeClass('campo-deshabilitado');
        submitButton.prop('disabled', false);

        if (status === 2) {
            $('#periodo_inicio').prop('disabled', true);
            startDateGroup.addClass('campo-deshabilitado');
        } else if (status === 3) {
            $('#periodo_inicio, #periodo_fin').prop('disabled', true);
            startDateGroup.add(endDateGroup).addClass('campo-deshabilitado');
            submitButton.prop('disabled', true);
        }
    }

    // Manejador para cambiar estado (Activar/Culminar)
    $(document).on('click', '.task-status', function () {
        const button = $(this);
        const PERIOD_ID = button.closest('tr').attr('taskid');
        const currentStatusText = button.find('.texto').text().trim();

        const statusMap = {
            'PENDIENTE': 1,
            'EN CURSO': 2,
            'CULMINADO': 3
        };

        const currentStatus = statusMap[currentStatusText];

        if (!currentStatus) {
            mostrarMensajeError('Estado desconocido.');
            return;
        }

        let newStatus, confirmMessage, iconType;
        if (currentStatus === 1) {
            newStatus = 2;

            const yaEnCurso = $('.task-status .texto').filter(function () {
                return $(this).text().trim() === 'EN CURSO';
            }).length > 0;

            if (yaEnCurso) {
                // Mensaje de error para el caso "ya hay uno activo"
                mostrarMensajeError('Ya existe un período EN CURSO. Debe culminarlo antes de activar otro.');
                return; // Sale de la función, no llega al Swal.fire de confirmación
            }

            confirmMessage = '¿Activar este período?';
            iconType = 'question';
        }
        else if (currentStatus === 2) {
            confirmMessage = '¿Marcar este período como CULMINADO?';
            newStatus = 3;
            iconType = 'question';
        }
        else {
            mostrarMensajeError('Los períodos culminados no pueden modificarse.');
            return;
        }

        // Siempre cerrar el dialog si está abierto antes de cualquier Swal.fire
        if (window.dialog && window.dialog.open) {
            window.dialog.close();
        }

        if (confirmMessage) {
            Swal.fire({
                title: confirmMessage,
                icon: iconType,
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                // Aquí NO reabrimos el dialog si se cancela la confirmación de la tabla
                if (result.isConfirmed) {
                    const originalContent = button.html();
                    button.html('<i class="fa-solid fa-spinner fa-spin"></i> Procesando...');

                    $.ajax({
                        url: '../controllers/periodo/Periodo.php?accion=cambiarEstado',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: PERIOD_ID,
                            newStatus: newStatus
                        },
                        success: function (response) {
                            if (response && response.success) {
                                mostrarMensajeExito(response.message || 'Estado actualizado correctamente', fetchTask);
                            } else if (response && response.message) {
                                mostrarMensajeError(response.message);
                            } else {
                                mostrarMensajeError('Error al cambiar el estado.');
                            }
                        },
                        error: function (xhr) {
                            let errorMsg = 'Error en el servidor';
                            try {
                                const errorResponse = JSON.parse(xhr.responseText);
                                errorMsg = errorResponse.message || errorMsg;
                            } catch (e) {
                                errorMsg = xhr.statusText || errorMsg;
                            }
                            mostrarMensajeError(errorMsg);
                        },
                        complete: function () {
                            button.html(originalContent);
                        }
                    });
                }
            });
        }
    });

    // Funciones para mostrar mensajes con SweetAlert2
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
            // Este callback se ejecuta DESPUÉS de que el usuario cierra la alerta de error.
            // La lógica de reabrir el dialog ahora se maneja en los puntos específicos
            // donde se llama a `mostrarMensajeError` (ej. en el `submit` del formulario).
            if (typeof callback === 'function') {
                callback();
            }
        });
    }

    // Pestañas para activos/inactivos (sin cambios)
    window.cambiarTabPeriodo = function (tipo, event) {
        const isActivos = tipo === 'activos';

        $('#datos-activos').toggle(isActivos);
        $('#datos-inactivos').toggle(!isActivos);

        $('.tab-button').removeClass('active');
        $(event.currentTarget).addClass('active');

        if (!isActivos) {
            fetchTask();
        }
    }

    // Manejador para restaurar período inactivo
    $(document).on('click', '.task-restore', function () {
        const PERIOD_ID = $(this).data('id');
        // Siempre cerrar el dialog si está abierto antes de cualquier Swal.fire
        if (window.dialog && window.dialog.open) {
            window.dialog.close();
        }

        Swal.fire({
            title: '¿Está seguro de restaurar este período?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            // Aquí NO reabrimos el dialog si se cancela, porque esta acción no proviene del dialog
            if (result.isConfirmed) {
                $.ajax({
                    url: '../controllers/periodo/Periodo.php?accion=restaurar',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: PERIOD_ID },
                    success: function (response) {
                        fetchTask();
                        if (response && response.success) {
                            mostrarMensajeExito(response.message || 'Período restaurado correctamente');
                        } else if (response && response.message) {
                            mostrarMensajeError(response.message);
                        } else {
                            mostrarMensajeExito('Período restaurado correctamente');
                        }
                    },
                    error: function (xhr) {
                        fetchTask();
                        mostrarMensajeError(`Error al restaurar: ${xhr.statusText}`);
                    }
                });
            }
        });
    });

    // Modificamos el listener de cierre del dialog
    const dialog = window.dialog;
    if (dialog) {
        dialog.addEventListener('close', function () {
            // Limpiar el formulario solo si NO estamos en modo edición
            if (!edit) {
                resetFormFields();
            }
            // Si estamos en modo edición y se cierra sin enviar (ej. con Esc),
            // no se hace nada, los datos quedan cargados.
        });
    }

    // Manejador para el botón "Crear nuevo período"
    $('.primary').on('click', function () {
        resetFormFields();
        edit = false; // Aseguramos que el modo edición esté desactivado
        if (window.dialog) window.dialog.showModal();
    });

    $('#periodo_inicio').trigger('change');

    // Manejador de activación (Este es el que causa el problema reportado)
    $(document).on('click', '.task-activate', function () {
        const PERIOD_ID = $(this).data('id');
        // Siempre cerrar el dialog si está abierto antes de cualquier Swal.fire
        if (window.dialog && window.dialog.open) {
            window.dialog.close();
        }

        Swal.fire({
            title: '¿Activar este período?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            // Aquí NO reabrimos el dialog si se cancela la activación.
            if (result.isConfirmed) {
                $.ajax({
                    url: '../controllers/periodo/Periodo.php?accion=cambiarEstado',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: PERIOD_ID, newStatus: 2 }, // 2 = EN CURSO
                    success: function (response) {
                        if (response.success) {
                            mostrarMensajeExito('Período activado correctamente');
                            fetchTask();
                        } else if (response.message) {
                            // Este es el SweetAlert de "Ya existe un período EN CURSO."
                            // No queremos reabrir el dialog del formulario aquí.
                            mostrarMensajeError(response.message);
                        } else {
                            mostrarMensajeError('No se pudo activar el período.');
                        }
                    },
                    error: function (xhr) {
                        mostrarMensajeError(`Error en el servidor: ${xhr.statusText}`);
                    }
                });
            }
        });
    });

    // Renombramos la función para que quede claro que solo limpia los campos
    function resetFormFields() {
        $("#formulario").trigger("reset");
        $('#PERIOD_ID').val('').prop('readonly', false);
        currentEditStatus = 1;
        currentEditPeriodStatus = 1;
        // Habilitar todos los campos y quitar estilos deshabilitados por defecto
        $('#lapso-academico, #turno, #periodo_inicio, #periodo_fin').prop('disabled', false);
        $('.formulario__grupo').removeClass('campo-deshabilitado');
        $('.formulario__btn').prop('disabled', false);

        // Asegúrate de que el select #turno tenga un valor por defecto si es un nuevo formulario
        if ($('#turno').is('select')) {
            $('#turno option:first').prop('selected', true);
        }
    }
});