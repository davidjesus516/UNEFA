$(document).ready(function () {//aqui inicializamos javascript
    let edit = false;// esta variable de lectura la inicializo para que el form de enviar pueda volverse en un editar si es True
    console.log("jquery is working");// para saber que jquery este funcionando
    console.log(edit);
    fetchTask();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    let errores = false;
    $.ajax({//realizo una peticion ajax
        url: '../controllers/carrera/UserList.php',//al url que trae la lista
        type: 'GET',//le pido una peticion GET
        success: function (response) {// si tengo una respuesta ejecuta la funcion
            let task = JSON.parse(response);// convierto el json en string
            let template = '<option id = "carrera-option" value="" disabled selected>Seleccione una opción</option>';//creo la plantilla donde imprimire los datos
            task.forEach(task => {//hago un array que me recorra el json y me lo imprima en el tbody
                template += `<option id = "carrera-option" value="${task.CAREER_ID}" >${task.CAREER_NAME}</option>
                `
            })
            $('#carrera').html(template);//los imprimo en el html
        }
    })
    $.ajax({//realizo una peticion ajax
        url: '../controllers/estudiante/StudentFormCombos.php',//al url que trae la lista
        type: 'GET',//le pido una peticion GET
        success: function (response) {// si tengo una respuesta ejecuta la funcion
            let task = JSON.parse(response);// convierto el json en string
            $('#genero').html(task.gender);
            $('#estado_civil').html(task.maritalStatus);
            $('#regimen').html(task.regime);
            $('#tipo_estudiante').html(task.studentType);
            $('#rango_militar').html(task.militaryRank);
            $('#trabaja').html(task.workingStatus);
        }
    })
    const expresiones = {
        usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
        solo_letras: /^[a-zA-ZÀ-ÿ\s]+$/, // Letras y espacios, pueden llevar acentos.
        correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_.+-]*$/, // formato correo ejemplo@mail.com
        cedula: /^\d{1,8}$/, // cedula debe ser un numero de maximo 9 digitos
        telefono: /^\d{7}$/ // telefono debe ser un numero de 11 digitos 
    }
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
            return true; // Si la validación es correcta, se retorna true
        } else {
            isIncorrect(id, message || 'El campo no es válido');
            return false; // Si la validación falla, se retorna false
        }
    }
    function validateForm(input) {
        
        let id = input.attr('id');
        switch (id) {
            case 'primer_nombre':
            case 'segundo_nombre':
            case 'primer_apellido':
            case 'segundo_apellido':
                validateInput(input, expresiones.solo_letras, `grupo__${id}`, 'El campo solo debe contener letras y espacios');
                break;
            case 'cedula':
                if (input.val() === '') {
                    isIncorrect('grupo__cedula', 'Debe ingresar un número de cédula');
                    return false; // Si el campo está vacío, se retorna false
                } else if (validateInput(input, expresiones.cedula, 'grupo__cedula', 'El número de cédula debe ser un número de máximo 8 dígitos')) {
                    CIisUnique(); // Llama a la función para verificar si el número de cédula es único
                } else {
                    return false; // Si la validación falla, se retorna false
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
            case 'tipo_estudiante':
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
                isCorrect(`grupo__${id}`); // Para otros campos, simplemente se marca como correcto
                break;
        }
        // Verifica si hay algún error en el formulario
        if ($('.formulario__grupo-incorrecto').length > 0) {
            errores = true; // Si hay algún grupo incorrecto, se establece la variable errores en true
        } else {
            errores = false; // Si no hay grupos incorrectos, se establece la variable errores en false
        }
    }
    $('#formulario input').keyup(function (e) {//reviso del formulario task el evento keyup
        let input = $(this);
        validateForm(input); // Llama a la función de validación para cada input
    });
    function CIisUnique() {
        let search = $('#nacionalidad').val() + '-' + $('#cedula').val();
        $.ajax({
            url: '../controllers/estudiante/UserSearch.php',
            type: 'POST',
            data: { search },
            success: function (response) {
                let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
                if ((Object.keys(data).length === 0 || (edit === true && data.STUDENTS_CI === $('#nacionalidad').val() + '-' + $('#cedula').val()))) { // Verificamos si el objeto está vacío
                    isCorrect('grupo__cedula');
                    return true; // El número de cédula es único
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


    // Función para mostrar el modal de mensaje
    function mostrarMensajeModal(mensaje) {
        $("#message .contenido").html(mensaje);
        let message = $("#message").get(0);
        message.showModal();
        $(".x").off("click").on("click", function () {
            message.close();
        });
    }

    // Enviar formulario (crear o editar)
    $('#formulario').submit(function (e) {
        e.preventDefault(); // Siempre prevenir el envío por defecto

        if (!confirm('¿Quieres proceder con el registro?')) {
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
                mostrarMensajeModal("Debe llenar correctamente el formulario y el correo no debe estar repetido");
                return false;
            }

            // Si todo está bien, continúa con el envío AJAX
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
                    mostrarMensajeModal(data.message);
                    fetchTask();
                    $('#formulario').trigger('reset');
                }).fail(function () {
                    mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.");
                });
            } else {
                let url = '../controllers/estudiante/Estudiante.php?accion=actualizar';
                $.post(url, postData, function (response) {
                    let data = JSON.parse(response);
                    mostrarMensajeModal(data.message);
                    fetchTask();
                    $('#formulario').trigger('reset');
                    $('#cedula').attr('readonly', false);
                    $('#nacionalidad').attr('disabled', false);
                    edit = false;
                }).fail(function () {
                    mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.");
                });
            }
        });
    })

    // Mostrar solo activos al cargar la página
    $('#datos-activos').show();
    $('#datos-inactivos').hide();
    $('.tab-button').removeClass('active');
    $('.tab-button').first().addClass('active');

    fetchTask();

    // Nueva función para renderizar estudiantes en activos/inactivos
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
                    <button class="task-delete"><span class="texto">Borrar</span><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button>
                </td>
                <td>
                    <button class="task-edit" onclick="window.dialog.showModal();"><span class="texto">Editar</span><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
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
                <td colspan="2">
                    <button class="task-restore"><span class="texto">Restaurar</span><span class="icon"><i class="fa-solid fa-rotate-left"></i></span></button>
                </td>
            </tr>`;
        });

        $('#datos-activos').html(templateActivos);
        $('#datos-inactivos').html(templateInactivos);
    }

    // Modifica fetchTask para separar activos/inactivos
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

    // Lógica de pestañas
    window.cambiarTabEstudiante = function (tipo, event) {
        const isActivos = tipo === 'activos';
        $('#datos-activos').toggle(isActivos);
        $('#datos-inactivos').toggle(!isActivos);
        $('.tab-button').removeClass('active');
        $(event.currentTarget).addClass('active');
        // No es necesario volver a llamar a fetchTask aquí, ya que los datos ya están cargados
    }

    // Manejador para restaurar estudiante inactivo
    $(document).on('click', '.task-restore', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');
        if (confirm('¿Está seguro de restaurar este estudiante?')) {
            $.post('../controllers/estudiante/Estudiante.php?accion=restaurar', { id }, function (response) {
                let data = JSON.parse(response);
                mostrarMensajeModal(data.success ? "Estudiante restaurado correctamente." : "No se pudo restaurar el estudiante.");
                fetchTask();
            }).fail(function () {
                mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.");
            });
        }
    });

    // Manejador para eliminar (inactivar) estudiante
    $(document).on('click', '.task-delete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');
        if (confirm('¿Está seguro de eliminar este estudiante?')) {
            $.post('../controllers/estudiante/Estudiante.php?accion=eliminar', { id }, function (response) {
                let data = JSON.parse(response);
                mostrarMensajeModal(data.success ? "Estudiante eliminado correctamente." : "No se pudo eliminar el estudiante.");
                fetchTask();
            }).fail(function () {
                mostrarMensajeModal("Error en el servidor. Por favor, intenta nuevamente.");
            });
        }
    });

    $(document).on('click', '.task-edit', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');
        edit = true;
        // Traer datos del estudiante
        $.ajax({
            url: '../controllers/estudiante/Estudiante.php?accion=buscar&id=' + id,
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                // Llena los campos del formulario
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

                // Bloquea cédula y nacionalidad para evitar cambios
                $('#cedula').attr('readonly', true);
                $('#nacionalidad').attr('disabled', true);

                // Muestra el modal
                window.dialog.showModal();
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
})
