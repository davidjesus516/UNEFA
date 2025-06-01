$(document).ready(function () {
    let edit = false;
    let errores = false;
    console.log("jQuery está funcionando");
    fetchTask();

    $('#periodo_inicio').change(function () {
        const fechaInicio = $('#periodo_inicio').val();
        const numweeks = 16;
        const fechaInicioDate = new Date(fechaInicio);
        const minDate = new Date(fechaInicioDate.getTime() + numweeks * 7 * 24 * 60 * 60 * 1000);
        $('#periodo_fin').val(minDate.toISOString().split('T')[0]);
        $('#periodo_fin').attr('min', minDate.toISOString().split('T')[0]);
    });

    $('#formulario').submit(function (e) {
        e.preventDefault();

        if (!confirm('¿Quieres proceder con el registro?')) return false;

        const ACADEMIC_LAPSE = `${$('#lapso-academico').val()}-${$('#turno').val()}`;
        const START_DATE = $('#periodo_inicio').val();
        const END_DATE = $('#periodo_fin').val();

        const postData = {
            ACADEMIC_LAPSE: ACADEMIC_LAPSE,
            T_INTERNSHIPS_CODE: 'PASANTIA',       // Ajusta si necesitas otro valor
            START_DATE: START_DATE,
            END_DATE: END_DATE,
            PERIOD_STATUS: 'ACTIVO',              // Puedes cambiar por un input si deseas hacerlo editable
            STATUS: 'ACTIVO'
        };

        if (edit) {
            postData.PERIOD_ID = $('#PERIOD_ID').val();
        }

        if (errores) {
            alert("Debe llenar correctamente el formulario");
            return false;
        }

        let url = edit === false ? '../controllers/periodo/UserAdd.php' : '../controllers/periodo/UserEdit.php';
        $.post(url, postData, function (response) {
            console.log(response);
            if (response == 1) {
                alert('Registro añadido exitosamente');
            } else if (response == 0) {
                alert('Ya este periodo existe. Verifique los registros.');
            } else {
                alert('Error: ' + response);
            }
            fetchTask();
            $('#formulario').trigger('reset');
            $('#PERIOD_ID').prop('readonly', false);
            edit = false;
        }).fail(function () {
            alert("Error en el servidor. Por favor, intenta nuevamente.");
        });
    });


    function fetchTask() {
        $.ajax({
            url: '../controllers/periodo/UserList.php',
            type: 'GET',
            success: function (response) {
                let tasks = JSON.parse(response);
                let template = '';
                tasks.forEach(task => {
                    template += `<tr taskid="${task.PERIOD_ID}">
                    <td>${task.ACADEMIC_LAPSE}</td>
                    <td>${task.START_DATE}</td>
                    <td>${task.END_DATE}</td>
                    <td>${task.STATUS == 1 ? 'Activo' : 'Inactivo'}</td>
                    <td>
                        <button class="task-delete "><spam class="texto">Borrar</spam><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path></svg></span></button>
                    </td>
                    <td>
                        <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><spam class="icon"><svg viewBox="0 0 512 512">
                        <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg></spam></button>
                    </td>
                </tr>`;
                });
                $('#datos').html(template);
            }
        });
    }


    $(document).on('click', '.task-delete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');

        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            $.post('../controllers/periodo/UserDelete.php', { PERIOD_ID: id }, function (response) {
                fetchTask();
            });
        }
    });

    $(document).on('click', '.task-edit', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');

        $.post('../controllers/periodo/UserEditSearch.php', { id }, function (response) {
            const task = JSON.parse(response)[0];

            const [anio, turno] = task.ACADEMIC_LAPSE.split('-');
            $('#lapso-academico').val(anio);
            $('#turno').val(turno);
            $('#periodo_inicio').val(task.START_DATE);
            $('#periodo_fin').val(task.END_DATE);

            // Solo si usas PERIOD_ID internamente para edición
            if (!$('#PERIOD_ID').length) {
                $('<input>').attr({
                    type: 'hidden',
                    id: 'PERIOD_ID',
                    value: task.PERIOD_ID
                }).appendTo('#formulario');
            } else {
                $('#PERIOD_ID').val(task.PERIOD_ID);
            }

            edit = true;
        });
    });
});
