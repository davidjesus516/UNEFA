$(document).ready(function () {
    let edit = false;
    console.log("jquery is working");
    console.log(edit);
    fetchTask();
    let errores = false;
    
    // Referencia al diálogo del formulario
    const dialog = document.getElementById('dialog');
    
    // Manejador para cuando se cierra el diálogo
    dialog.addEventListener('close', function() {
        // Habilitar todos los campos y mostrar el botón de guardar
        $('#formulario input, #formulario select').prop('disabled', false);
        $('.formulario__btn').show(); // Asumiendo que el botón de guardar tiene esta clase

        // Restaurar título por defecto y limpiar formulario si no se está editando
        $('#titulo-modal').text('Registrar Estudiante'); // Asumiendo que el título tiene este ID
        if (!edit) {
            $('#formulario').trigger('reset');
        }
    });

    $.ajax({
        url: '../controllers/carrera/UserList.php',
        type: 'GET',
        success: function (response) {
            let task = JSON.parse(response);
            let template = '<option id = "carrera-option" value="" disabled selected>Seleccione una opción</option>';
            task.forEach(task => {
                template += `<option id = "carrera-option" value="${task.CAREER_ID}" >${task.CAREER_NAME}</option>`
            })
            $('#carrera').html(template);
        } 
    });

    $.ajax({
        url: '../controllers/estudiante/StudentFormCombos.php',
        type: 'GET',
        success: function (response) {
            let task = JSON.parse(response);
            $('#genero').html(task.gender);
            $('#estado_civil').html(task.maritalStatus);
            $('#regimen').html(task.regime);
            $('#tipo_estudiante').html(task.studentType);
            $('#rango_militar').html(task.militaryRank);
            $('#trabaja').html(task.workingStatus);
        }
    });

    const expresiones = {
        usuario: /^[a-zA-Z0-9\_\-]{4,16}$/,
        solo_letras: /^[a-zA-ZÀ-ÿ\s]+$/,
        correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_.+-]*$/,
        cedula: /^\d{1,8}$/,
        telefono: /^\d{7}$/
    };

    function isCorrect(id) {
        $(`#${id}`).addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
        $(`#${id} i`).addClass("fa-check-circle").removeClass("fa-times-circle");
        $(`#${id} .formulario__input-error`).removeClass("formulario__input-error-activo");
    }

    function isIncorrect(id, message) {
        $(`#${id}`).addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
        $(`#${id} i`).addClass("fa-times-circle").removeClass("fa-check-circle");
        $(`#${id} .formulario__input-error`).addClass('formulario__input-error-activo');
        $(`#${id} p`).text(message);
    }

    function validateInput(input, regex, id, message) {
        if (regex.test(input.val())) {
            isCorrect(id);
            return true;
        } else {
            isIncorrect(id, message || 'El campo no es válido');
            return false;
        }
    }

    function validateForm(input) {
        let id = input.attr('id');
        switch (id) {
            case 'primer_nombre':
            case 'primer_apellido':
                validateInput(input, expresiones.solo_letras, `grupo__${id}`, 'El campo solo debe contener letras y espacios');
                break;
            case 'cedula':
                if (input.val() === '') {
                    isIncorrect('grupo__cedula', 'Debe ingresar un número de cédula');
                    return false;
                } else if (validateInput(input, expresiones.cedula, 'grupo__cedula', 'El número de cédula debe ser un número de máximo 8 dígitos')) {
                    CIisUnique();
                } else {
                    return false;
                }
                break;
            case 'segundo_nombre':
            case 'segundo_apellido':
                if (input.val() !== '') {
                    validateInput(input, expresiones.solo_letras, `grupo__${id}`, 'El campo solo debe contener letras y espacios');
                } else {
                    isCorrect(`grupo__${id}`);
                }
                break;
            case 'telefono':
                validateInput(input, expresiones.telefono, 'grupo__telefono');
                break;
            case 'correo':
                if (validateInput(input, expresiones.correo, 'grupo__correo')) {
                    emailIsUnique(function(){});
                }
                break;
            case 'nacionalidad':
                if (input.val() === '') {
                    isIncorrect('grupo__nacionalidad', 'Debe seleccionar una nacionalidad');
                } else {
                    isCorrect('grupo__nacionalidad');
                }
                break;
            case 'genero':
            case 'estado_civil':
            case 'semestre':
            case 'seccion':
            case 'regimen':
            case 'rango_militar':
            case 'trabaja':
            case 'carrera':
                if (input.val() === '') {
                    isIncorrect(`grupo__${id}`, `Debe seleccionar una opción para ${input.attr('name')}`);
                } else {
                    isCorrect(`grupo__${id}`);
                }
                break;
            case 'birthdate':
                if (input.val() === '') {
                    isIncorrect('grupo__birthdate', 'Debe seleccionar una fecha de nacimiento');
                } else {
                    isCorrect('grupo__birthdate');
                }
                break;
            default:
                isCorrect(`grupo__${id}`);
                break;
        }
        if ($('.formulario__grupo-incorrecto').length > 0) {
            errores = true;
        } else {
            errores = false;
        }
    }

    $('#tipo_estudiante').change(function () {
        let tipoEstudiante = $(this).val();
        if (tipoEstudiante === 'CIV') {
            $('#rango_militar').val(' ');
            $('#rango_militar').attr('disabled', true);
        } else {
            $('#rango_militar').attr('disabled', false);
        }
    });

    $('#formulario input').keyup(function (e) {
        let input = $(this);
        validateForm(input);
    });

    function CIisUnique() {
        let search = $('#nacionalidad').val() + '-' + $('#cedula').val();
        $.ajax({
            url: '../controllers/estudiante/UserSearch.php',
            type: 'POST',
            data: { search },
            success: function (response) {
                let data = JSON.parse(response);
                if ((Object.keys(data).length === 0 || (edit === true && data.STUDENTS_CI === $('#nacionalidad').val() + '-' + $('#cedula').val()))) {
                    isCorrect('grupo__cedula');
                    return true;
                } else {
                    isIncorrect('grupo__cedula', 'Este número de cédula ya está registrado');
                    return false;
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    };

    // Función mejorada para mostrar mensajes con SweetAlert2
    function mostrarMensajeModal(mensaje, tipo = 'info') {
        // Cerrar el diálogo solo si está abierto
        if (dialog.open) {
            dialog.close();
        }
        
        return Swal.fire({
            title: tipo === 'error' ? 'Error' : tipo === 'success' ? 'Éxito' : 'Información',
            text: mensaje,
            icon: tipo,
            confirmButtonText: 'Aceptar'
        });
    }

    // Enviar formulario (crear o editar) - Versión corregida
    $('#formulario').submit(function (e) {
        e.preventDefault();

        // Cerrar el diálogo antes de mostrar la confirmación
        if (dialog.open) {
            dialog.close();
        }

        Swal.fire({
            title: '¿Confirmar acción?',
            text: edit ? '¿Deseas actualizar este registro?' : '¿Deseas crear un nuevo registro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) {
                // Volver a abrir el diálogo si se cancela
                dialog.showModal();
                return false;
            }

            // Validación de todos los campos del formulario
            $('#formulario input, #formulario select').each(function () {
                let input = $(this);
                validateForm(input);
            });

            // Validar correo único antes de enviar
            emailIsUnique(function (isUnique) {
                if (errores || !isUnique) {
                    mostrarMensajeModal("Debe llenar correctamente el formulario y el correo no debe estar repetido", 'error')
                        .then(() => dialog.showModal());
                    return false;
                }

                const STUDENTS_ID = $('#id').val();
                const STUDENTS_CI = $('#nacionalidad').val() + '-' + $('#cedula').val();
                const NAME = $('#primer_nombre').val();
                const SECOND_NAME = $('#segundo_nombre').val();
                const SURNAME = $('#primer_apellido').val();
                const SECOND_SURNAME = $('#segundo_apellido').val();
                const GENDER = $('#genero').val();
                const BIRTHDATE = $('#birthdate').val();
                const CONTACT_PHONE = $('#operadora').val() + '-' + $('#telefono').val();
                const EMAIL = $('#correo').val();
                const ADDRESS = '';
                const MARITAL_STATUS = $('#estado_civil').val();
                const SEMESTER = $('#semestre').val();
                const SECTION = $('#seccion').val();
                const REGIME = $('#regimen').val();
                const STUDENT_TYPE = $('#tipo_estudiante').val();
                const MILITARY_RANK = $('#rango_militar').val();
                const EMPLOYMENT = $('#trabaja').val();
                const CAREER_ID = $('#carrera').val();

                const postData = {
                    STUDENTS_ID: STUDENTS_ID,
                    STUDENTS_CI: STUDENTS_CI,
                    NAME: NAME,
                    SECOND_NAME: SECOND_NAME,
                    SURNAME: SURNAME,
                    SECOND_SURNAME: SECOND_SURNAME,
                    GENDER: GENDER,
                    BIRTHDATE: BIRTHDATE,
                    CONTACT_PHONE: CONTACT_PHONE,
                    EMAIL: EMAIL,
                    ADDRESS: ADDRESS,
                    MARITAL_STATUS: MARITAL_STATUS,
                    SEMESTER: SEMESTER,
                    SECTION: SECTION,
                    REGIME: REGIME,
                    STUDENT_TYPE: STUDENT_TYPE,
                    MILITARY_RANK: MILITARY_RANK,
                    EMPLOYMENT: EMPLOYMENT,
                    CAREER_ID: CAREER_ID
                };

                if (edit === false) {
                    let url = '../controllers/estudiante/Estudiante.php?accion=insertar';
                    $.post(url, postData, function (response) {
                        let data = JSON.parse(response);
                        mostrarMensajeModal(data.message, 'success')
                            .then(() => {
                                fetchTask();
                                dialog.close(); // Solo cerramos el modal sin limpiar el formulario
                            });
                    }).fail(function () {
                        mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.", 'error')
                            .then(() => dialog.showModal());
                    });
                } else {
                    let url = '../controllers/estudiante/Estudiante.php?accion=actualizar';
                    $.post(url, postData, function (response) {
                        let data = JSON.parse(response);
                        mostrarMensajeModal(data.message, 'success')
                            .then(() => {
                                fetchTask();
                                $('#cedula').attr('readonly', false);
                                $('#nacionalidad').attr('disabled', false);
                                edit = false;
                                dialog.close(); // Solo cerramos el modal sin limpiar el formulario
                            });
                    }).fail(function () {
                        mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.", 'error')
                            .then(() => dialog.showModal());
                    });
                }
            });
        });
    });

    // Mostrar solo activos al cargar la página
    $('#datos-activos').show();
    $('#datos-inactivos').hide();
    $('.tab-button').removeClass('active');
    $('.tab-button').first().addClass('active');

    fetchTask();

    function renderStudents(data) {
        let templateActivos = '';
        let templateInactivos = '';

        (data.activos || []).forEach(task => {
            templateActivos += `<tr taskid="${task.STUDENTS_ID}">
                <td>${task.STUDENTS_CI}</td>
                <td>${task.NAME}</td>
                <td>${task.SURNAME}</td>
                <td>${task.GENDER}</td>
                <td>${task.CONTACT_PHONE}</td>
                <td>${task.EMAIL}</td>
                <td>${task.CAREER_NAME}</td>
                <td>
                    <button class="task-edit" data-id="${task.STUDENTS_ID}"><span class="texto">Editar</span><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
                </td>
                <td>
                    <button class="task-delete" data-id="${task.STUDENTS_ID}"><span class="texto">Borrar</span><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button>
                </td>
                <td>
                    <button class="task-view" data-id="${task.STUDENTS_ID}"><span class="texto">Ver</span><span class="icon"><i class="fa-solid fa-search"></i></span></button>
                </td>
            </tr>`;
        });

        (data.inactivos || []).forEach(task => {
            templateInactivos += `<tr taskid="${task.STUDENTS_ID}">
                <td>${task.STUDENTS_CI}</td>
                <td>${task.NAME}</td>
                <td>${task.SURNAME}</td>
                <td>${task.GENDER}</td>
                <td>${task.CONTACT_PHONE}</td>
                <td>${task.EMAIL}</td>
                <td>${task.CAREER_NAME}</td>
                <td>
                    <button class="task-restore" data-id="${task.STUDENTS_ID}"><span class="texto">Restaurar</span><span class="icon"><i class="fa-solid fa-rotate-left"></i></span></button>
                </td>
                <td></td>
                <td>
                    <button class="task-view" data-id="${task.STUDENTS_ID}"><span class="texto">Ver</span><span class="icon"><i class="fa-solid fa-search"></i></span></button>
                </td>
            </tr>`;
        });

        $('#datos-activos').html(templateActivos);
        $('#datos-inactivos').html(templateInactivos);
    }

    function fetchTask() {
        $.ajax({
            url: '../controllers/estudiante/UserList.php',
            type: 'GET',
            success: function (response) {
                let all = JSON.parse(response);
                let activos = all.filter(x => x.STATUS == 1 || x.STATUS === "1");
                let inactivos = all.filter(x => x.STATUS == 0 || x.STATUS === "0");
                renderStudents({ activos, inactivos });
            }
        });
    }

    window.cambiarTabEstudiante = function (tipo, event) {
        const isActivos = tipo === 'activos';
        $('#datos-activos').toggle(isActivos);
        $('#datos-inactivos').toggle(!isActivos);
        $('.tab-button').removeClass('active');
        $(event.currentTarget).addClass('active');
    }

    // Manejador para restaurar estudiante inactivo con SweetAlert2 - Versión corregida
    $(document).on('click', '.task-restore', function () {
        const id = $(this).data('id');
        
        // Cerrar el diálogo si está abierto
        if (dialog.open) {
            dialog.close();
        }

        Swal.fire({
            title: '¿Restaurar estudiante?',
            text: "¿Estás seguro de que deseas restaurar este estudiante?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controllers/estudiante/Estudiante.php?accion=restaurar', { id }, function (response) {
                    let data = JSON.parse(response);
                    mostrarMensajeModal(data.success ? "Estudiante restaurado correctamente." : "No se pudo restaurar el estudiante.", data.success ? 'success' : 'error');
                    fetchTask();
                }).fail(function () {
                    mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.", 'error');
                });
            }
        });
    });

    // Manejador para eliminar (inactivar) estudiante con SweetAlert2 - Versión corregida
    $(document).on('click', '.task-delete', function () {
        const id = $(this).data('id');
        
        // Cerrar el diálogo si está abierto
        if (dialog.open) {
            dialog.close();
        }

        Swal.fire({
            title: '¿Eliminar estudiante?',
            text: "¿Estás seguro de que deseas eliminar este estudiante?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controllers/estudiante/Estudiante.php?accion=eliminar', { id }, function (response) {
                    let data = JSON.parse(response);
                    mostrarMensajeModal(data.success ? "Estudiante eliminado correctamente." : "No se pudo eliminar el estudiante.", data.success ? 'success' : 'error');
                    fetchTask();
                }).fail(function () {
                    mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.", 'error');
                });
            }
        });
    });

    $(document).on('click', '.task-edit', function () {
        const id = $(this).data('id');
        edit = true;
        
        $.ajax({
            url: '../controllers/estudiante/Estudiante.php?accion=buscar&id=' + id,
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                $('#id').val(data.STUDENTS_ID);
                let ciParts = data.STUDENTS_CI.split('-');
                $('#nacionalidad').val(ciParts[0]);
                $('#cedula').val(ciParts[1]);
                $('#primer_nombre').val(data.NAME);
                $('#segundo_nombre').val(data.SECOND_NAME);
                $('#primer_apellido').val(data.SURNAME);
                $('#segundo_apellido').val(data.SECOND_SURNAME);
                $('#genero').val(data.GENDER);
                $('#birthdate').val(data.BIRTHDATE);
                let telParts = data.CONTACT_PHONE.split('-');
                $('#operadora').val(telParts[0]);
                $('#telefono').val(telParts[1]);
                $('#correo').val(data.EMAIL);
                $('#estado_civil').val(data.MARITAL_STATUS);
                $('#semestre').val(data.SEMESTER);
                $('#seccion').val(data.SECTION);
                $('#regimen').val(data.REGIME);
                $('#tipo_estudiante').val(data.STUDENT_TYPE);
                $('#rango_militar').val(data.MILITARY_RANK);
                $('#trabaja').val(data.EMPLOYMENT);
                $('#carrera').val(data.CAREER_ID);

                $('#cedula').attr('readonly', true);
                $('#nacionalidad').attr('disabled', true);

                dialog.showModal();
            }
        });
    });

    // Manejador para ver estudiante (modo consulta)
    $(document).on('click', '.task-view', function () {
        const id = $(this).data('id');
        edit = false; // No estamos en modo edición
        
        $.ajax({
            url: '../controllers/estudiante/Estudiante.php?accion=buscar&id=' + id,
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                $('#id').val(data.STUDENTS_ID);
                let ciParts = data.STUDENTS_CI.split('-');
                $('#nacionalidad').val(ciParts[0]);
                $('#cedula').val(ciParts[1]);
                $('#primer_nombre').val(data.NAME);
                $('#segundo_nombre').val(data.SECOND_NAME);
                $('#primer_apellido').val(data.SURNAME);
                $('#segundo_apellido').val(data.SECOND_SURNAME);
                $('#genero').val(data.GENDER);
                $('#birthdate').val(data.BIRTHDATE);
                let telParts = data.CONTACT_PHONE.split('-');
                $('#operadora').val(telParts[0]);
                $('#telefono').val(telParts[1]);
                $('#correo').val(data.EMAIL);
                $('#estado_civil').val(data.MARITAL_STATUS);
                $('#semestre').val(data.SEMESTER);
                $('#seccion').val(data.SECTION);
                $('#regimen').val(data.REGIME);
                $('#tipo_estudiante').val(data.STUDENT_TYPE);
                $('#rango_militar').val(data.MILITARY_RANK);
                $('#trabaja').val(data.EMPLOYMENT);
                $('#carrera').val(data.CAREER_ID);

                // Cambiar a modo consulta
                $('#titulo-modal').text('Consultar Estudiante'); // Asumiendo que el título tiene este ID
                $('#formulario input, #formulario select').prop('disabled', true);
                $('.formulario__btn').hide(); // Ocultar botón de guardar

                dialog.showModal();
            },
            error: function() {
                mostrarMensajeModal("Error al cargar los datos del estudiante.", 'error');
            }
        });
    });

    function emailIsUnique(callback) {
        let email = $('#correo').val();
        let id = $('#id').val();
        $.ajax({
            url: '../controllers/estudiante/EmailSearch.php',
            type: 'POST',
            data: { email, id, edit },
            success: function (response) {
                let data = JSON.parse(response);
                if (Object.keys(data).length === 0 || (edit === true && data.EMAIL === email && data.STUDENTS_ID == id)) {
                    isCorrect('grupo__correo');
                    callback(true);
                } else {
                    isIncorrect('grupo__correo', 'Este correo ya está registrado');
                    callback(false);
                }
            },
            error: function (error) {
                console.log(error);
                callback(false);
            }
        });
    }
});