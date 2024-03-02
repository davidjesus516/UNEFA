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

               alert(response);
               		})
	})

})