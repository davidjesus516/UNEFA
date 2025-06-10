$(document).ready(() => {
    let edit = false;
    let errores = false;
    let currentEditStatus = 1;
    let currentEditPeriodStatus = 1;

    console.log("jQuery está funcionando");

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

        // Actualiza el valor y el mínimo permitido en el campo de fin
        $('#periodo_fin').attr('min', formattedMinDate);

        // Si la fecha de fin actual es menor a la mínima, actualízala
        const fechaFinActual = $('#periodo_fin').val();
        if (!fechaFinActual || fechaFinActual < formattedMinDate) {
            $('#periodo_fin').val(formattedMinDate);
        }
    });

    // Manejador de cambio del lapso académico
    $('#lapso-academico').change(function () {
        const lapsoYear = $(this).val();
        if (!lapsoYear) return;

        // Limitar el campo de fecha de inicio solo a ese año
        const minDate = `${lapsoYear}-01-01`;
        const maxDate = `${lapsoYear}-12-31`;
        $('#periodo_inicio').attr('min', minDate).attr('max', maxDate);

        // Si la fecha de inicio actual no está en ese año, la ajusta al 1 de enero
        const currentStart = $('#periodo_inicio').val();
        if (!currentStart || currentStart.substring(0, 4) !== lapsoYear) {
            $('#periodo_inicio').val(minDate).trigger('change');
        }
    });

    // Manejador de envío del formulario
    $('#formulario').submit(function (e) {
        e.preventDefault();

        if (!confirm('¿Quieres proceder con el registro?')) return false;

        const lapsoYear = $('#lapso-academico').val();
        const startDate = $('#periodo_inicio').val();
        const endDate = $('#periodo_fin').val();

        const postData = {
            DESCRIPTION: `${lapsoYear}-${$('#turno').val()}`,
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

        if (errores) {
            mostrarMensajeError("Debe llenar correctamente el formulario");
            return false;
        }

        // Validación: año del lapso académico debe coincidir con año de fecha de inicio
        if (lapsoYear && startDate) {
            const startYear = new Date(startDate).getFullYear().toString();
            if (lapsoYear !== startYear) {
                mostrarMensajeError("El año de la fecha de inicio debe coincidir con el año del lapso académico seleccionado.");
                return false;
            }
        }

        // Validar que la fecha de cierre sea al menos 16 semanas después de la fecha de inicio
        if (startDate && endDate) {
            const diffDays = (new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24);
            if (diffDays < 112) {
                mostrarMensajeError("La fecha de cierre debe ser al menos 16 semanas después de la fecha de inicio.");
                return false;
            }
        }

        const url = '../controllers/periodo/Periodo.php?accion=' + (edit ? 'actualizar' : 'insertar');
        $.ajax({
            url,
            type: 'POST',
            dataType: 'json',
            data: postData,
            success: response => handleFormResponse(response),
            error: xhr => mostrarMensajeError(`Error en el servidor: ${xhr.statusText}`)
        });
    });

    // Función para manejar la respuesta del formulario
    const handleFormResponse = response => {
        if (response.success) {
            mostrarMensajeExito('Operación exitosa');
            fetchTask();
            if (dialog) dialog.close();
        } else if (response.message) {
            mostrarMensajeError(response.message);
        } else {
            mostrarMensajeError('Error desconocido al procesar la solicitud');
        }
    }

    // Función para obtener y mostrar los períodos
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

    // Nueva función para renderizar períodos en activos/inactivos
    function renderTasks(data) {
        let templateActivos = '';
        let templateInactivos = '';

        // Renderiza activos
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
                    <button class="task-action task-delete" data-id="${task.PERIOD_ID}">
                        <span class="texto">Borrar</span>
                        <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                    </button>
                </td>
                <td>
                    <button class="task-action task-edit" data-id="${task.PERIOD_ID}">
                        <span class="texto">Editar</span>
                        <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                    </button>
                </td>
            </tr>`;
        });

        // Renderiza inactivos SOLO con botón restaurar y estado como texto
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

    // Función para obtener información del estado
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

        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
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

        $.ajax({
            url: '../controllers/periodo/UserEditSearch.php',
            type: 'POST',
            dataType: 'json',
            data: { PERIOD_ID },
            success: function (response) {
                setupEditForm(response, currentStatus);
            },
            error: function (xhr) {
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

            // GUARDAR LOS ESTADOS ACTUALES PARA USARLOS AL ENVIAR
            currentEditStatus = task.STATUS;
            currentEditPeriodStatus = task.PERIOD_STATUS;

            // Configurar campos según el estado
            setupFieldsByStatus(task.PERIOD_STATUS);

            // Validación extra para EN CURSO: solo permitir editar fecha de cierre
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

            window.dialog.showModal();
            edit = true;
        } catch (err) {
            console.error('Error al editar:', err, response);
            mostrarMensajeError('Error al cargar datos para edición');
        }
    }

    // Función para configurar campos según el estado
    function setupFieldsByStatus(status) {
        const startDateGroup = $('.formulario__grupo:has(#periodo_inicio)');
        const endDateGroup = $('.formulario__grupo:has(#periodo_fin)');
        const submitButton = $('.formulario__btn');

        // Resetear todos los campos primero
        $('#periodo_inicio, #periodo_fin').prop('disabled', false);
        startDateGroup.add(endDateGroup).removeClass('campo-deshabilitado');
        submitButton.prop('disabled', false);

        // Aplicar restricciones según el estado
        if (status === 2) { // EN CURSO
            $('#periodo_inicio').prop('disabled', true);
            startDateGroup.addClass('campo-deshabilitado');
        } else if (status === 3) { // CULMINADO
            $('#periodo_inicio, #periodo_fin').prop('disabled', true);
            startDateGroup.add(endDateGroup).addClass('campo-deshabilitado');
            submitButton.prop('disabled', true);
        }
    }

    // Manejador para cambiar estado
    $(document).on('click', '.task-status', function () {
        const button = $(this);
        const PERIOD_ID = button.closest('tr').attr('taskid');
        const currentStatusText = button.find('.texto').text().trim();

        // Mapeo de estados
        const statusMap = {
            'PENDIENTE': 1,
            'EN CURSO': 2,
            'CULMINADO': 3
        };

        const currentStatus = statusMap[currentStatusText];

        if (!currentStatus) {
            mostrarMensajeError('Estado desconocido');
            return;
        }

        // Determinar nuevo estado
        let newStatus, confirmMessage;
        if (currentStatus === 1) {
            newStatus = 2;

            // Validación: ¿ya hay un período EN CURSO?
            const yaEnCurso = $('.task-status .texto').filter(function () {
                return $(this).text().trim() === 'EN CURSO';
            }).length > 0;

            if (yaEnCurso) {
                mostrarMensajeError('Ya existe un período EN CURSO. Debe culminarlo antes de activar otro.');
                return;
            }

            confirmMessage = '¿Activar este período?';
        }
        else if (currentStatus === 2) {
            confirmMessage = '¿Marcar este período como CULMINADO?';
            newStatus = 3;
        }
        else {
            mostrarMensajeError('Los períodos culminados no pueden modificarse');
            return;
        }

        if (confirmMessage && !confirm(confirmMessage)) return;

        // Mostrar indicador de carga
        const originalContent = button.html();
        button.html('<i class="fa-solid fa-spinner fa-spin"></i> Procesando...');

        // Enviar solicitud al servidor
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
                    mostrarMensajeError('Error al cambiar el estado');
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
    });    
    
    // Funciones para mostrar mensajes
    function mostrarMensajeExito(mensaje, callback) {
        showDialog(mensaje, 'success', callback);
    }

    function mostrarMensajeError(mensaje, callback) {
        showDialog(mensaje, 'error', callback);
    }

    function showDialog(mensaje, type, callback) {
        // Asegúrate de que exista el contenedor .message
        if ($('.message').length === 0) {
            $('body').append('<div class="message"></div>');
        }

        // Elimina cualquier diálogo anterior
        $('#message').remove();

        const icon = type === 'success' ?
            '<div class="success-checkmark"><div class="check-icon"><span class="icon-line line-tip"></span><span class="icon-line line-long"></span><div class="icon-circle"></div><div class="icon-fix"></div></div></div>' :
            '<div class="error-banmark"><div class="ban-icon"><span class="icon-line line-long-invert"></span><span class="icon-line line-long"></span><div class="icon-circle"></div><div class="icon-fix"></div></div></div>';

        $(".message").html(`
            <dialog id="message">
                <h2>${mensaje}</h2>
                ${icon}
                <button aria-label="close" class="x">❌</button>
            </dialog>
        `);

        const dialog = $("#message").get(0);
        if (dialog) dialog.showModal();

        $(".x").off('click').on("click", function () {
            if (dialog) dialog.close();
        });

        // Elimina el diálogo del DOM al cerrarse y ejecuta callback si existe
        if (dialog) {
            dialog.addEventListener('close', function () {
                $('#message').remove();
                if (typeof callback === 'function') callback();
            }, { once: true });
        }
    }

    // Pestañas para activos/inactivos
    window.cambiarTabPeriodo = function (tipo, event) {
        const isActivos = tipo === 'activos';

        $('#datos-activos').toggle(isActivos);
        $('#datos-inactivos').toggle(!isActivos);

        $('.tab-button').removeClass('active');
        $(event.currentTarget).addClass('active');

        // Si se muestran los inactivos, forzar la carga de datos
        if (!isActivos) {
            fetchTask();
        }
    }

    // Manejador para restaurar período inactivo
    $(document).on('click', '.task-restore', function () {
        const PERIOD_ID = $(this).data('id');
        if (confirm('¿Está seguro de restaurar este período?')) {
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

    // Asegúrate de que window.dialog apunte al elemento dialog
    window.dialog = document.getElementById('dialog');

    // Limpiar el formulario siempre que se cierre el modal
    const dialog = window.dialog;
    if (dialog) {
        dialog.addEventListener('close', function () {
            resetForm();
        });
    }

    // Si tienes un botón para crear nuevo período, límpialo antes de abrir el modal
    $('.primary').on('click', function () {
        resetForm();
        if (window.dialog) window.dialog.showModal();
    });

    $('#periodo_inicio').trigger('change');

    $(document).on('click', '.task-activate', function () {
        const PERIOD_ID = $(this).data('id');
        // Ya NO uses confirm ni alert aquí
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
                    mostrarMensajeError(response.message);
                } else {
                    mostrarMensajeError('No se pudo activar el período.');
                }
            },
            error: function (xhr) {
                mostrarMensajeError(`Error en el servidor: ${xhr.statusText}`);
            }
        });
    });

    // Función para limpiar y restaurar el formulario del modal
    function resetForm() {
        $("#formulario").trigger("reset");
        $('#PERIOD_ID').val('').prop('readonly', false);
        edit = false;
        currentEditStatus = 1;
        currentEditPeriodStatus = 1;
        // Habilitar todos los campos
        $('#lapso-academico, #turno, #periodo_inicio, #periodo_fin').prop('disabled', false);
        $('.formulario__grupo').removeClass('campo-deshabilitado');
        $('.formulario__btn').prop('disabled', false);
    }
});