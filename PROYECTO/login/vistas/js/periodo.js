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
            T_INTERNSHIPS_CODE: '',       // Ajusta si necesitas otro valor
            START_DATE: START_DATE,
            END_DATE: END_DATE,
            PERIOD_STATUS: 'PENDIENTE',              // Puedes cambiar por un input si deseas hacerlo editable
            STATUS: 'ACTIVO'
        };

        if (edit) {
            postData.PERIOD_ID = $('#PERIOD_ID').val();
        }

        if (errores) {
            alert("Debe llenar correctamente el formulario");
            return false;
        }
        edit = false; // Reiniciar la variable edit después de guardar

        let url = edit === false ? '../controllers/periodo/UserAdd.php' : '../controllers/periodo/UserEdit.php';
        $.post(url, postData, function (response) {
            console.log(response);
        
            data = JSON.parse(response);
            $(".message").html(data.message);
            let message = $("#message").get(0);
            message.showModal();
            $(".x").on("click", function () {
                message.close();
            });
            fetchTask();
            $("#formulario").trigger("reset");
            dialog.close();
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
                    <td><button class="task-status ${task.PERIOD_STATUS == 1 ? 'status-activo' : 'status-inactivo'}""><spam class="texto">${task.STATUS == 1 ? 'En Curso' : 'Pendiente'}</spam><span class="icon"><i class="fa-solid fa-repeat" style="color: #ffffff;"></i></span></button></td>
                    <td>
                        <button class="task-delete" data-id="<?= $row['PERIOD_ID'] ?>">
                            <span class="texto">Borrar</span>
                            <span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span>
                        </button>
                    </td>
                    <td>
                        <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
                    </td>
                </tr>`;
                });
                $('#datos').html(template);
            }
        });
    }

    // BORRAR EL PERIODO
    $(document).on('click', '.task-delete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let PERIOD_ID = $(element).attr('taskid');
        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            $.post('../controllers/periodo/UserDelete.php', { PERIOD_ID }, function (response) {
                fetchTask();
            });
        } else {
            // Si el usuario hace clic en "Cancelar", no se elimina el usuario
            return false;
        }
    });
});

// EDITAR EL PERIODO
$(document).on('click', '.task-edit', function () {
    const row = $(this).closest('tr');
    const PERIOD_ID = row.attr('taskid');

    $.post('../controllers/periodo/UserEditSearch.php', { PERIOD_ID }, function (response) {
        try {
            console.log(response)
            const data = JSON.parse(response);

            if (!data || !data.length) {
                alert('No se encontraron datos para editar');
                return;
            }

            const task = data[0];
            const [year, turno] = task.ACADEMIC_LAPSE.split('-');

            // Asegura que las opciones ya estén renderizadas
            document.addEventListener('DOMContentLoaded', () => {
                $(document).on('click', '.task-edit', function () {
                    const row = $(this).closest('tr');
                    const id = row.attr('taskid');

                    $.post('../controllers/periodo/UserEditSearch.php', { PERIOD_ID }, function (response) {
                        try {
                            const data = JSON.parse(response);
                            const task = data[0];
                            const [year, turno] = task.ACADEMIC_LAPSE.split('-');
                            // Esperar que el lapso esté poblado
                            setTimeout(() => {
                                if ($("#lapso-academico option[value=" + Number(year) + "]").length === 0) {
                                    $('#lapso-academico').append(
                                        $('<option>', {
                                            value: year,
                                            text: year
                                        })
                                    );
                                }
                                $('#lapso-academico').val(year);
                                $('#turno').val(turno);
                            }, 100); // Delay pequeño para asegurarse que está poblado
                            
                            $('#periodo_inicio').val(task.START_DATE);
                            $('#periodo_fin').val(task.END_DATE);
                            $('#PERIOD_ID').val(task.PERIOD_ID);
                            
                            window.dialog.showModal();
                            edit = true;
                        } catch (err) {
                            alert('Error al cargar datos');
                            console.error(err);
                        }
                    });
                });
            });
            
            $('#turno').val(turno);
            $('#periodo_inicio').val(task.START_DATE);
            $('#periodo_fin').val(task.END_DATE);
            $('#PERIOD_ID').val(task.PERIOD_ID);
            
            //  Mostrar el modal después de llenar los datos
            window.dialog.showModal();

            edit = true;
        } catch (err) {
            console.error('Error al parsear JSON:', err, response);
            alert('Error al procesar los datos');
        }
    });
});