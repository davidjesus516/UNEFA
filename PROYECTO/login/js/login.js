$(document).ready(function () {
	console.log("jquery funciona");
	$("#task-form").submit(function (e) {

		const username = $("#username-input").val();
		const password = $("#password-input").val();
		$.post("controllers/login/login.php", { username, password }, function (response) {
			// seccion de codigo que muestra el mensaje de respuesta del servidor
			data = JSON.parse(response);
            if (data.status == 0) {
                $(".modal").html(data.message);
                dialog.showModal();
                $('.x').on('click', function () {
                    dialog.close();
                });
            } else if (data.status == 1) {
				$(".modal").html(data.message);
                dialog.showModal();
                $('.x').on('click', function () {
					location.assign(data.redirect);
                    dialog.close();
                });
			}
		})
		e.preventDefault();//previene el comportamiento por defecto
	})

})