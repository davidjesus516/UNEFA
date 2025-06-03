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

// Configuración
const INACTIVITY_LIMIT = 5 * 60 * 1000; // 5 minutos

let inactivityTimer;

// Resetear temporizador en eventos de actividad
function resetInactivityTimer() {
	clearTimeout(inactivityTimer);
	inactivityTimer = setTimeout(logoutUser, INACTIVITY_LIMIT);
}

// Detectar inactividad
['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
	document.addEventListener(event, resetInactivityTimer);
});

// Cerrar sesión cuando la pestaña se cierra o cambia de visibilidad
window.addEventListener('beforeunload', () => {
	navigator.sendBeacon('logout.php');
});

document.addEventListener('visibilitychange', () => {
	if (document.visibilityState === 'hidden') {
		navigator.sendBeacon('logout.php');
	}
});

// Ejecutar logout
function logoutUser() {
	fetch('logout.php', { method: 'POST' })
		.then(() => {
			window.location.href = 'index.php'; // o login.html si existe
		});
}

// Inicialización
resetInactivityTimer();
