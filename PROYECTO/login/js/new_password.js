$(document).ready(function () {
    let errores = false;

    function validarPassword(password) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/.test(password);
    }

    function actualizarEstadoInput(selector, esValido, mensajeError) {
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

    function validarCampos() {
        const pass1 = $('#password-input1').val();
        const pass2 = $('#password-input2').val();
        let esPass1Valido = validarPassword(pass1);
        let esPass2Valido = (pass1 === pass2);

        actualizarEstadoInput('#grupo__password1', esPass1Valido, "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.");
        
        if (pass2.length > 0) {
            actualizarEstadoInput('#grupo__password2', esPass2Valido, "Las contraseñas no coinciden.");
        } else {
            // Limpiar el estado si el campo 2 está vacío
             $('#grupo__password2').removeClass("formulario__grupo-incorrecto formulario__grupo-correcto");
        }

        errores = !esPass1Valido || !esPass2Valido;
    }

    $('#password-input1, #password-input2').on('keyup', validarCampos);

    $('#NewPasswordForm').submit(function (e) {
        e.preventDefault();
        validarCampos(); // Re-validar antes de enviar

        if (errores) {
            return false;
        }

        const user_id = $('#user_id').val();
        const password = $('#password-input1').val();
        const data = {
            user_id: user_id,
            password: password
        };

        $.post('controllers/login/new_password.php', data, function (response) {
            // Asegurarse de que la respuesta es un objeto
            const responseData = (typeof response === 'string') ? JSON.parse(response) : response;

            // Inyectar el HTML del modal en el div .modal
            $(".modal").html(responseData.message);
            
            // Obtener el elemento del diálogo por su ID después de haberlo inyectado
            const dialog = document.getElementById('dialog');

            if (dialog) {
                dialog.showModal();
                // Usamos .one() para que el evento solo se ejecute una vez por clic.
                // Esto evita problemas si el usuario cierra y abre el modal varias veces.
                $('.x').one('click', function () {
                    dialog.close();
                    if (responseData.status == 1 && responseData.redirect) {
                        location.assign(responseData.redirect);
                    }
                });
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // Manejo de errores si la petición AJAX falla (ej. error 500 del servidor)
            console.error("Error en la petición AJAX: ", textStatus, errorThrown);
            $(".modal").html("<p>Ocurrió un error inesperado. Por favor, intente de nuevo más tarde.</p>");
        });
    });
});
