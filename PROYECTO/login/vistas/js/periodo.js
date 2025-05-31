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
                let task = JSON.parse(response);
                let template = '';
                task.forEach(task => {
                    template += `<tr taskid="${task.PERIOD_ID}">
                        <td>${task.ACADEMIC_LAPSE}</td>
                        <td>${task.START_DATE}</td>
                        <td>${task.END_DATE}</td>
                        <td>${task.STATUS}</td>
                        <td>
                            <button class="task-delete"><span class="texto">Borrar</span></button>
                        </td>
                        <td>
                            <button class="task-edit" onclick="window.dialog.showModal();"><span class="texto">Editar</span></button>
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
