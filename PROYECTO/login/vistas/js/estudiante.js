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
    $('#formulario input').keyup(function (e) {//reviso del formulario task el evento keyup
        let input = $(this);
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
                validateInput(input, expresiones.correo, 'grupo__correo');
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


    $('#formulario').submit(function (e) {//reviso del formulario task el evento submit
        // Agregamos la alerta de confirmación
        if (!confirm('¿Quieres proceder con el registro?')) {
            e.preventDefault(); // Cancela el envío del formulario si el usuario hace clic en "Cancelar"
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
        const CONTACT_PHONE = $('#telefono').val();
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

        // Validación de todos los campos del formulario
        $('#formulario input, #formulario select').each(function () {
            let input = $(this);
            let id = input.attr('id');
            switch (id) {
                case 'primer_nombre':
                case 'segundo_nombre':
                case 'primer_apellido':
                case 'segundo_apellido':
                    if (!validateInput(input, expresiones.solo_letras, `grupo__${id}`, 'El campo solo debe contener letras y espacios')) {
                        errores = true;
                    }
                    break;
                case 'cedula':
                    if (input.val() === '') {
                        isIncorrect('grupo__cedula', 'Debe ingresar un número de cédula');
                        errores = true;
                    } else if (!validateInput(input, expresiones.cedula, 'grupo__cedula', 'El número de cédula debe ser un número de máximo 8 dígitos')) {
                        errores = true;
                    } else {
                        CIisUnique(); // Puedes dejarlo si es necesario, pero recuerda que es asíncrono
                    }
                    break;
                case 'telefono':
                    if (!validateInput(input, expresiones.telefono, 'grupo__telefono')) {
                        errores = true;
                    }
                    break;
                case 'correo':
                    if (!validateInput(input, expresiones.correo, 'grupo__correo')) {
                        errores = true;
                    }
                    break;
                case 'nacionalidad':
                    if (input.val() === '') {
                        isIncorrect('grupo__nacionalidad', 'Debe seleccionar una nacionalidad');
                        errores = true;
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
                        errores = true;
                    } else {
                        isCorrect(`grupo__${id}`);
                    }
                    break;
                case 'birthdate':
                    if (input.val() === '') {
                        isIncorrect('grupo__birthdate', 'Debe seleccionar una fecha de nacimiento');
                        errores = true;
                    } else {
                        isCorrect('grupo__birthdate');
                    }
                    break;
                default:
                    isCorrect(`grupo__${id}`);
                    break;
            }
        });


        if (errores) { // Se comprueba si hay errores
            e.preventDefault(); // Cancela el envío del formulario si hay errores
            alert("debe llenar correctamente el formulario");
            return false;
        }

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
            let url = '../controllers/estudiante/UserAdd.php';
            $.post(url, postData, function (response) {
                data = JSON.parse(response);
                $(".message").html(data.message);
                let message = $("#message").get(0);
                message.showModal();
                $(".x").on("click", function () {
                    message.close();
                });
                fetchTask();
                $('#formulario').trigger('reset');
            }).fail(function () {
                alert("Error en el servidor. Por favor, intenta nuevamente."); // Mostrar mensaje de error en caso de falla en la conexión con el servidor
            });
        } else {
            let url = '../controllers/estudiante/UserEdit.php';
            $.post(url, postData, function (response) {
                data = JSON.parse(response);
                $(".message").html(data.message);
                let message = $("#message").get(0);
                message.showModal();
                $(".x").on("click", function () {
                    message.close();
                });
                fetchTask();
                $('#formulario').trigger('reset');
                $('#cedula').attr('readonly', false);
                $('#nacionalidad').attr('disabled', false);
                edit = false;
            })
        }
        e.preventDefault(); // Se agrega para prevenir el comportamiento predeterminado del formulario     
    })

    function fetchTask() {//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/estudiante/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response) {// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task => {//hago un array que me recorra el json y me lo imprima en el tbody

                    template += `<tr taskid="${task.STUDENTS_ID}">
                        <td>${task.STUDENTS_CI}</td>
                        <td>${task.NAME}</td>
                        <td>${task.SURNAME}</td>
                        <td>${task.GENDER}</td>
                        <td>${task.CONTACT_PHONE}</td>
                        <td>${task.EMAIL}</td>
                        <td>${task.CAREER_NAME}</td>
                        <td>
                            <button class="task-delete "><spam class="texto">Borrar</spam><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path></svg></span></button>
                        </td>
                        <td>
                            <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><spam class="icon"><svg viewBox="0 0 512 512">
                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg></spam></button>
                        </td>
                    </tr>
                    `
                })
                $('#datos').html(template);//los imprimo en el html
            }
        })
    }
    $(document).on('click', '.task-delete', function () {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');

        // Agregamos la alerta de confirmación
        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            $.post('../controllers/estudiante/UserDelete.php', { id }, function (response) {
                fetchTask();
            });
        } else {
            // Si el usuario hace clic en "Cancelar", no se elimina el usuario
            return false;
        }
    });

    $(document).on('click', '.task-edit', function () {//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/estudiante/UserEditSearch.php', { id }, function (response) {//mando los datos al controlador
            const task = JSON.parse(response); // accede al primer objeto en el array
            const CI = task.STUDENTS_CI.split('-');
            $('#id').val(task.STUDENTS_ID).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#cedula').val(CI[1]).prop('readonly', true);
            $('#nacionalidad').val(CI[0]).prop('disabled', true);
            $('#primer_nombre').val(task.NAME);
            $('#segundo_nombre').val(task.SECOND_NAME);
            $('#primer_apellido').val(task.SURNAME);
            $('#segundo_apellido').val(task.SECOND_SURNAME);
            $('#genero').val(task.GENDER);
            $('#birthdate').val(task.BIRTHDATE);
            $('#telefono').val(task.CONTACT_PHONE);
            $('#correo').val(task.EMAIL);
            $('#estado_civil').val(task.MARITAL_STATUS);
            $('#semestre').val(task.SEMESTER);
            $('#seccion').val(task.SECTION);
            $('#regimen').val(task.REGIME);
            $('#tipo_estudiante').val(task.STUDENT_TYPE);
            $('#rango_militar').val(task.MILITARY_RANK);
            $('#trabaja').val(task.EMPLOYMENT);
            $('#carrera').val(task.CAREER_ID);
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });
    })
    $(document).on("click", ".primary", function () {
        $("#formulario").trigger("reset");
        edit = false;
        $('#cedula').prop('readonly', false);
        $('#nacionalidad').attr('disabled', false);
    });
})
