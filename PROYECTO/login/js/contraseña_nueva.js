$(document).ready(function () {//aqui inicializamos javascript
    console.log("jquery is working");// para saber que jquery este funcionando
    let errores = false; // Variable para comprobar si hay errores
    $('#task-form').submit(function (e) {
        const id = $("#id").val();
        const passwordinput1 = $('#password-input1').val();
        const passwordinput2 = $('#password-input2').val();


        if (passwordinput1 !== passwordinput2) { // Validating "nombre" field
            alert("las contraseñas no coinciden");
            errores = true; // Se marca que hay errores
        }

        if ((passwordinput1 == null || passwordinput1.length == 0 || /^\s+$/.test(passwordinput1)) || (passwordinput2 == null || passwordinput2.length == 0 || /^\s+$/.test(passwordinput2))) {

            alert("debe colocar un valor valido en el campo contrseña");
            errores = true; // Se marca que hay errores;}
        }

        if (errores) { // Se comprueba si hay errores
            return false; // Cancela el envío del formulario
        }
        const postData = {
            id: id,
            password: passwordinput1
        };
        // Agregamos la alerta de confirmación
        if (confirm('¿Quieres proceder con el registro?')) {
            let url = "controllers/login/contraseña_nueva.php";
            $.post(url, postData, function (response) {
                alert(response);
                location = "index.php";
            })
        } else {
            // Si el usuario hace clic en "Cancelar", no se envía la solicitud de registro
            return false;
        }


    });





})
