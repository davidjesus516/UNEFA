$(document).ready(function () {//aqui inicializamos javascript
    console.log("jquery is working");// para saber que jquery este funcionando
    let errores = false; // Variable para comprobar si hay errores
    $('#password-input1').keyup(function () {
        const passwordinput1 = $('#password-input1').val();
        if (/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/.test(passwordinput1)) {
            $('#grupo__password1').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__password1 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__password1 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
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
    $('#question1').change(function () {
        const question1 = $('#question1').val();
        const question2 = $('#question2').val();
        const question3 = $('#question3').val();
        if (question1 === question2 || question1 === question3 || question2 === question3) {
            $("#grupo__question1").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__question1 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__question1 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__question1 p").text("Las preguntas no deben ser iguales");
            errores = true;
        }else{
            $('#grupo__question1').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question1 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question1 .formulario__input-error`).removeClass('formulario__input-error-activo');
            
            $('#grupo__question2').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question2 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question2 .formulario__input-error`).removeClass('formulario__input-error-activo');
            
            $('#grupo__question3').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question3 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question3 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        }
    });
    $('#question2').change(function () {
        const question1 = $('#question1').val();
        const question2 = $('#question2').val();
        const question3 = $('#question3').val();
        if (question1 === question2 || question1 === question3 || question2 === question3) {
            $("#grupo__question2").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__question2 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__question2 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__question2 p").text("Las preguntas no deben ser iguales");
            errores = true;
        }else{
            $('#grupo__question1').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question1 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question1 .formulario__input-error`).removeClass('formulario__input-error-activo');
            
            $('#grupo__question2').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question2 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question2 .formulario__input-error`).removeClass('formulario__input-error-activo');
            
            $('#grupo__question3').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question3 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question3 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        }
    });
    $('#question3').change(function () {
        const question1 = $('#question1').val();
        const question2 = $('#question2').val();
        const question3 = $('#question3').val();
        if (question1 === question2 || question1 === question3 || question2 === question3) {
            $("#grupo__question3").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__question3 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__question3 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__question3 p").text("Las preguntas no deben ser iguales");
            errores = true;
        }else{
            $('#grupo__question1').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question1 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question1 .formulario__input-error`).removeClass('formulario__input-error-activo');
            
            $('#grupo__question2').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question2 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question2 .formulario__input-error`).removeClass('formulario__input-error-activo');
            
            $('#grupo__question3').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__question3 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__question3 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        }
    });
    $('#answer1').keyup(function () {
        const answer1 = $('#answer1').val();
        const answer2 = $('#answer2').val();
        const answer3 = $('#answer3').val();
        if (/^[a-z-A-Z0-9]*$/.test(answer1)) {
            $('#grupo__answer1').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__answer1 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__answer1 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        }if (answer1.length < 3) {
            $("#grupo__answer1").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer1 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer1 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer1 p").text("La respuesta debe tener al menos 3 caracteres");
            errores = true;
        }if (answer1 === answer2 || answer1 === answer3 ) {
            $("#grupo__answer1").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer1 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer1 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer1 p").text("Las respuestas no deben ser iguales");
            errores = true;
        }if (!(/^[a-z-A-Z0-9]*$/.test(answer1))) {
            $("#grupo__answer1").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer1 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer1 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer1 p").text("La respuesta solo debe tener numeros o letras");
            errores = true;
        }
    });
    $('#answer2').keyup(function () {
        const answer1 = $('#answer1').val();
        const answer2 = $('#answer2').val();
        const answer3 = $('#answer3').val();
        if (/^[a-z-A-Z0-9]*$/.test(answer2)) {
            $('#grupo__answer2').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__answer2 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__answer2 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        }if (answer2.length < 3) {
            $("#grupo__answer2").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer2 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer2 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer2 p").text("La respuesta debe tener al menos 3 caracteres");
            errores = true;
        }if (answer1 === answer2 || answer2 === answer3) {
            $("#grupo__answer2").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer2 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer2 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer2 p").text("Las respuestas no deben ser iguales");
            errores = true;
        }if (!(/^[a-z-A-Z0-9]*$/.test(answer2))) {
            $("#grupo__answer2").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer2 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer2 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer2 p").text("La respuesta solo debe tener numeros o letras");
            errores = true;
        }
    });
    $('#answer3').keyup(function () {
        const answer1 = $('#answer1').val();
        const answer2 = $('#answer2').val();
        const answer3 = $('#answer3').val();
        if (/^[a-z-A-Z0-9]*$/.test(answer3)) {
            $('#grupo__answer3').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__answer3 i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__answer3 .formulario__input-error`).removeClass('formulario__input-error-activo');
            errores = false
        }if (answer3.length < 3) {
            $("#grupo__answer3").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer3 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer3 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer3 p").text("La respuesta debe tener al menos 3 caracteres");
            errores = true;
        }if (answer1 === answer3 || answer2 === answer3) {
            $("#grupo__answer3").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer3 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer3 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer3 p").text("Las respuestas no deben ser iguales");
            errores = true;
        }if (!(/^[a-z-A-Z0-9]*$/.test(answer3))) {
            $("#grupo__answer3").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $("#grupo__answer3 i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__answer3 .formulario__input-error`).addClass("formulario__input-error-activo");
            $("#grupo__answer3 p").text("La respuesta solo debe tener numeros o letras");
            errores = true;
        }
    });
    $('#task-form').submit(function (e) {
        const id = $("#id").val();
        const passwordinput1 = $('#password-input1').val();
        const question1 = $('#question1').val();
        const answer1 = $('#answer1').val();
        const question2 = $('#question2').val();
        const answer2 = $('#answer2').val();
        const question3 = $('#question3').val();
        const answer3 = $('#answer3').val();
        if (errores) { // Se comprueba si hay errores
            return false; // Cancela el envío del formulario
        }
        const postData = {
            id: id,
            password: passwordinput1,
            question1: question1,
            answer1: answer1,
            question2: question2,
            answer2: answer2,
            question3: question3,
            answer3: answer3
        };
        // Agregamos la alerta de confirmación
        if (confirm('¿Quieres proceder con el registro?')) {
            let url = "controllers/login/basic_user_config.php";
            $.post(url, postData, function (response) {
                console.log(response);
                if (parseInt(response) === 1) {
                    alert('Registro exitoso');
                    location.replace('logout.php');
                } else {
                    alert('Error en el registro');
                }
            })
        } else {
            // Si el usuario hace clic en "Cancelar", no se envía la solicitud de registro
            return false;
        }
        
        e.preventDefault();

    });





})
