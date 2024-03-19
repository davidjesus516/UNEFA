$(document).ready(function(){
	console.log("jquery funciona");	
	$("#task-form").submit(function(e){

	const username = $("#username-input").val();
	const password = $("#password-input").val();

		const postdata = {
			username: username,
			password: password
		}
		$.post("controllers/login/login.php",{username,password},function(response){
			// seccion de codigo que muestra el mensaje obtenido del backend
            $(".modal").html(response);
			dialog.showModal();
			$('.x').on('click', function() {
				dialog.close();
				location.reload();
			});
            })
			e.preventDefault();//previene el comportamiento por defecto
	})
	$('.x').on('click', function() {
		dialog.close();
	});
	
})