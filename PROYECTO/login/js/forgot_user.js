// forgot_user.js
function form_security_question(question1, question2, user_id, question1_id, question2_id) {
    $.ajax({
        url: "forms/user/security_questions.php",
        type: "GET",
        success: function (response) {
            $("body").html(response);
            $("#question1 h2").text(question1);
            $("#question2 h2").text(question2);
            $('#user_id').val(user_id);
            $('#question1_id').val(question1_id);
            $('#question2_id').val(question2_id);
        },
    });
}

function form_new_password(user_id) {
    $.ajax({
        url: "forms/user/new_password.php",
        type: "GET",
        success: function (response) {
            $("body").html(response);
            $('#user_id').val(user_id);
        },
    });
}

function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

$(document).ready(function () {
    let n1 = 0;
    let n2 = 0;
    console.log("jquery funciona");

    // --- Funciones de validación de contraseña (duplicadas de new_password.js pero necesarias aquí) ---
    let erroresPassword = false; // Variable específica para errores de contraseña

    function validarPasswordFormat(password) {
        // Al menos 8 caracteres, una mayúscula, una minúscula, un número.
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
    }

    function actualizarEstadoInputPassword(selector, esValido, mensajeError) {
        const grupo = $(selector);
        if (esValido) {
            grupo.addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            grupo.find('i').addClass("fa-check-circle").removeClass("fa-times-circle");
            grupo.find('.formulario__input-error').removeClass('formulario__input-error-activo');
        } else {
            grupo.addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            grupo.find('i').addClass("fa-times-circle").removeClass("fa-check-circle");
            grupo.find('.formulario__input-error').addClass('formulario__input-error-activo').text(mensajeError);
        }
    }

    function validarCamposPassword() {
        const pass1 = $('#password-input1').val();
        const pass2 = $('#password-input2').val();
        let esPass1Valido = validarPasswordFormat(pass1);
        let esPass2Valido = (pass1 === pass2);

        actualizarEstadoInputPassword('#grupo__password1', esPass1Valido, "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.");
        
        if (pass2.length > 0) {
            actualizarEstadoInputPassword('#grupo__password2', esPass2Valido, "Las contraseñas no coinciden.");
        } else {
            // Limpiar el estado si el campo 2 está vacío
             $('#grupo__password2').removeClass("formulario__grupo-incorrecto formulario__grupo-correcto");
             $('#grupo__password2 i').removeClass("fa-check-circle fa-times-circle");
             $('#grupo__password2 .formulario__input-error').removeClass('formulario__input-error-activo');
        }

        erroresPassword = !esPass1Valido || !esPass2Valido;
    }
    // --- Fin de funciones de validación de contraseña ---


    // Se utiliza delegación de eventos para que los formularios cargados con AJAX funcionen.
    // El manejador se asocia al 'body' y escucha eventos de los elementos hijos que coincidan con el selector.

    $('body').on('submit', '#UserSearchForm', function (e) {
        e.preventDefault();
        const user = $('#username-input').val();
        $.post('controllers/login/user_security_question_search.php', { user: user }, function (response) {
            const data = (typeof response === 'string') ? JSON.parse(response) : response; // Asegurarse de que es un objeto

            $(".modal").html(data.message.text);
            const dialog = document.getElementById('dialog'); // Obtener referencia al diálogo después de inyectar

            if (dialog) {
                dialog.showModal();
                $('.x').one('click', function () { // Usar .one() para evitar múltiples listeners
                    dialog.close();
                    if (data.message.status == 1) {
                        const user_id = data[0].USER_ID;
                        while (n1 === n2) {
                            n1 = getRndInteger(0, Object.keys(data).length - 1);
                            n2 = getRndInteger(0, Object.keys(data).length - 1);
                        }
                        form_security_question(data[n1].DESCRIPTION, data[n2].DESCRIPTION, user_id, data[n1].PRESET_QUESTION_ID, data[n2].PRESET_QUESTION_ID);
                    }
                });
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX para UserSearchForm: ", textStatus, errorThrown);
            $(".modal").html(`<dialog id="dialog">
                <h2>Error de Comunicación</h2>
                <p>No se pudo completar la solicitud. Por favor, intente de nuevo más tarde.</p>
                <button aria-label="close" class="x">❌</button>
                </dialog>`);
            const dialog = document.getElementById('dialog');
            if (dialog) {
                dialog.showModal();
                $('.x').one('click', () => dialog.close());
            }
        });
    });

    $('body').on('submit', '#SecurityQuestionForm', function (e) {
        e.preventDefault();
        const postData = {
            user_id: $('#user_id').val(),
            question1_id: $('#question1_id').val(),
            question2_id: $('#question2_id').val(),
            answer1: $('#answer1-input').val(),
            answer2: $('#answer2-input').val()
        };

        $.post('controllers/login/security_question_validate.php', postData, function (response) {
            // security_question_validate.php devuelve 1 o 0 directamente, no JSON
            if (parseInt(response) === 1) {
                $(".modal").html(`
                    <dialog id="dialog">
                        <h2>Respuestas Correctas</h2>
                        <button aria-label="close" class="x">❌</button>
                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                    </dialog>`);
                const dialog = document.getElementById('dialog');
                if (dialog) {
                    dialog.showModal();
                    $('.x').one('click', function () {
                        dialog.close();
                        form_new_password(postData.user_id);
                    });
                }
            } else {
                $(".modal").html(`<dialog id="dialog">
                    <h2>Respuestas incorrectas</h2>
                    <button aria-label="close" class="x">❌</button>
                    <div class="error-banmark">
                        <div class="ban-icon">
                            <span class="icon-line line-long-invert"></span>
                            <span class="icon-line line-long"></span>
                            <div class="icon-circle"></div>
                            <div class="icon-fix"></div>
                        </div>
                    </div>
                </dialog>`);
                const dialog = document.getElementById('dialog');
                if (dialog) {
                    dialog.showModal();
                    $('.x').one('click', () => dialog.close());
                }
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX para SecurityQuestionForm: ", textStatus, errorThrown);
            $(".modal").html(`<dialog id="dialog">
                <h2>Error de Comunicación</h2>
                <p>No se pudo completar la solicitud. Por favor, intente de nuevo más tarde.</p>
                <button aria-label="close" class="x">❌</button>
                </dialog>`);
            const dialog = document.getElementById('dialog');
            if (dialog) {
                dialog.showModal();
                $('.x').one('click', () => dialog.close());
            }
        });
    });

    // Usar delegación de eventos para los campos de contraseña
    $('body').on('keyup', '#password-input1, #password-input2', validarCamposPassword);

    $('body').on('submit', '#NewPasswordForm', function (e) {
        e.preventDefault();
        validarCamposPassword(); // Re-validar antes de enviar

        // Asegurarse de que ambos campos de contraseña no estén vacíos y no haya errores de validación
        if (erroresPassword || $('#password-input1').val().length === 0 || $('#password-input2').val().length === 0) {
            // Si hay errores, mostrar un mensaje general si no hay uno específico ya visible
            if (!$("#grupo__password1 .formulario__input-error").hasClass("formulario__input-error-activo") &&
                !$("#grupo__password2 .formulario__input-error").hasClass("formulario__input-error-activo")) {
                $(".modal").html(`<dialog id="dialog">
                    <h2>Error de Validación</h2>
                    <p>Por favor, complete y corrija los campos de contraseña.</p>
                    <button aria-label="close" class="x">❌</button>
                    </dialog>`);
                const dialog = document.getElementById('dialog');
                if (dialog) {
                    dialog.showModal();
                    $('.x').one('click', () => dialog.close());
                }
            }
            return false; // Cancela el envío del formulario
        }

        const postData = {
            user_id: $('#user_id').val(),
            password: $('#password-input1').val()
        };

        $.post('controllers/login/new_password.php', postData, function (response) {
            const responseData = (typeof response === 'string') ? JSON.parse(response) : response;

            $(".modal").html(responseData.message);
            const dialog = document.getElementById('dialog');

            if (dialog) {
                dialog.showModal();
                $('.x').one('click', function () {
                    dialog.close();
                    if (responseData.status == 1 && responseData.redirect) {
                        location.assign(responseData.redirect);
                    }
                });
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX para NewPasswordForm: ", textStatus, errorThrown);
            $(".modal").html(`<dialog id="dialog">
                <h2>Error de Comunicación</h2>
                <p>No se pudo completar la solicitud. Por favor, intente de nuevo más tarde.</p>
                <button aria-label="close" class="x">❌</button>
                </dialog>`);
            const dialog = document.getElementById('dialog');
            if (dialog) {
                dialog.showModal();
                $('.x').one('click', () => dialog.close());
            }
        });
    });
});
