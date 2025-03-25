function form_security_question(question1, question2, user_id, question1_id, question2_id) {
    $.ajax({
        //realizo una peticion ajax
        url: "forms/user/security_questions.php", //al url que trae la lista
        type: "GET", //le pido una peticion GET
        success: function (response) {
            // si tengo una respuesta ejecuta la funcion
            $("body").html(response); //los imprimo en el html
            $("#question1 h2").text(question1);
            $("#question2 h2").text(question2);;
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
    let user_id;
    let question1_id;
    let question2_id;
    console.log("jquery funciona");
    $('#UserSearchForm').submit(function (e) {
        e.preventDefault();
        var user = $('#username-input').val();
        $.post('controllers/login/user_security_question_search.php', { user: user }, function (response) {
            data = JSON.parse(response);
            if (data.message.status == 0) {
                $(".modal").html(data.message.text);
                dialog.showModal();
                $('.x').on('click', function () {
                    dialog.close();
                });
            } else {
                user_id = data[0].USER_ID;
                while (n1 === n2) {
                    n1 = getRndInteger(0, Object.keys(data).length - 1)
                    n2 = getRndInteger(0, Object.keys(data).length - 1)
                }
                $(".modal").html(data.message.text);
                dialog.showModal();
                $('.x').on('click', function () {
                    dialog.close();
                    form_security_question(data[n1].DESCRIPTION, data[n2].DESCRIPTION, user_id, data[n1].PRESET_QUESTION_ID, data[n2].PRESET_QUESTION_ID);
                });
            }
        });

    });

    $('#SecurityQuestionForm').submit(function (e) {
        e.preventDefault();
        let answer1 = $('#answer1-input').val();
        let answer2 = $('#answer2-input').val();
        user_id = $('#user_id').val();
        question1_id = $('#question1_id').val();
        question2_id = $('#question2_id').val();
        data = {
            user_id: user_id,
            question1_id: question1_id,
            question2_id: question2_id,
            answer1: answer1,
            answer2: answer2
        }
        $.post('controllers/login/security_question_validate.php', data, function (response) {
            data = response;
            if (data == 1) {
                $(".modal").html(`
                    <dialog id="dialog">
                <h2>Respuestas Correctos</h2>
                <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
                <div class="success-checkmark">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
                </div>
                </dialog>`);
                dialog.showModal();
                $('.x').on('click', function () {
                    dialog.close();
                    form_new_password(user_id);
                });
            }
            else {
                $(".modal").html(`<dialog id="dialog">
                <h2>Respuestas incorrectas</h2>
                <div class="error-banmark">
                <div class="ban-icon">
                    <span class="icon-line line-long-invert"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
                </div>
                <button aria-label="close" class="x">❌</button>
                </dialog>`);
                dialog.showModal();
                $('.x').on('click', function () {
                    dialog.close();
                });
            }

        });
    });
    let errores = false;
    $('#password-input1').keyup(function () {
        const passwordinput1 = $('#password-input1').val();
        const passwordinput2 = $('#password-input2').val();
        if (/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/.test(passwordinput1)) {
            $('#grupo__password1').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__password1 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__password1 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        } else if (passwordinput1 !== passwordinput2) {
            $("#grupo__password2").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__password2 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__password2 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__password2 p").text("Las contraseñas no coinciden");
            errores = true;
        }
        else {
            $("#grupo__password1").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__password1 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__password1 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__password1 p").text("La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número");
            errores = true;
        }
    });
    $('#password-input2').keyup(function () {
        const passwordinput1 = $('#password-input1').val();
        const passwordinput2 = $('#password-input2').val();
        if (/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/.test(passwordinput2)) {
            $('#grupo__password2').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__password2 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__password2 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        } if (passwordinput1 !== passwordinput2) {
            $("#grupo__password2").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__password2 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__password2 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__password2 p").text("Las contraseñas no coinciden");
            errores = true;
        }
    });
    $('#NewPasswordForm').submit(function (e) {
        e.preventDefault();
        if (errores) { // Se comprueba si hay errores
            return false; // Cancela el envío del formulario
        }
        user_id = $('#user_id').val();
        password = $('#password-input1').val();
        data = {
            user_id: user_id,
            password: password
        }
        $.post('controllers/login/new_password.php', data, function (response){
            if (parseInt(response) === 1) {
                alert('Registro exitoso');
                location.replace('logout.php');
            } else {
                alert('Error en el registro');
            }
        });
    });
});