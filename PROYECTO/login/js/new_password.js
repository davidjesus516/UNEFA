$(document).ready(function () {
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
            responseData = JSON.parse(response);
            if (responseData.status == 0) {
                $(".modal").html(responseData.message);
                dialog.showModal();
                $('.x').on('click', function () {
                    dialog.close();
                });
            } else if (responseData.status == 1) {
				$(".modal").html(responseData.message);
                dialog.showModal();
                $('.x').on('click', function () {
					location.assign(responseData.redirect);
                    dialog.close();
                });
			}
		})
		e.preventDefault();//previene el comportamiento por defecto
	})
});