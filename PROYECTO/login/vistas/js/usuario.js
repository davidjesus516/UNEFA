let currentTab = 'activos', // Pestaña actual ('activos' o 'inactivos')
    modoEdicion = false, // Indica si el formulario está en modo edición
    idEditando = null, // Guarda el ID del usuario que se está editando
    dialog; // Variable para el modal

$(document).ready(() => {
    dialog = document.getElementById('dialog'); // Asignar el elemento del DOM
    listarUsuarios();

    // Manejador para cerrar el modal al hacer clic en el botón de cerrar
    $("#btnCerrarModal").on("click", () => dialog.close());
    // Manejador para cuando se cierra el diálogo
    dialog.addEventListener('close', limpiarFormulario);

    // Manejador para el envío del formulario de usuario
    $("#formulario").on("submit", function (e) {
        e.preventDefault();
        // Obtener valores del formulario
        const usuario = $("#usuario").val().trim(),
            nombre = $("#nombre").val().trim(),
            rol = $("#rol").val(),
            clave = $("#clave").val();

        // Validación básica de la cédula (usuario)
        if (!/^\d{7,9}$/.test(usuario)) {
            alertaSimple('Error', 'Cédula inválida (debe contener entre 7 y 9 dígitos).', 'error');
            return;
        }

        // 1. Cerrar el dialog antes de mostrar Swal
        const wasDialogOpen = dialog.open;
        if (wasDialogOpen) dialog.close();
        
        alertaConfirmacion({
            title: '¿Confirmar acción?',
            text: modoEdicion ? '¿Deseas actualizar este usuario?' : '¿Deseas crear un nuevo usuario?',
            onConfirm: () => {
                // Preparar datos para enviar
                const data = { usuario, nombre, rol, clave };
                let url = modoEdicion ? "../controllers/usuario/Usuario.php?op=editar" : "../controllers/usuario/Usuario.php?op=crear";
                if (modoEdicion) data.user_id = idEditando;

                // Enviar datos al servidor usando AJAX POST
                $.post(url, data, function (resp) {
                    if (resp.status) {
                        alertaSimple('Éxito', resp.message || (modoEdicion ? "Usuario editado exitosamente" : "Usuario creado exitosamente"), 'success');
                        listarUsuarios();
                        // El dialog ya está cerrado y se limpiará con el evento 'close'
                    } else {
                        alertaSimple('Error', resp.error || "Ocurrió un error al procesar la solicitud.", 'error').then(() => {
                            if (wasDialogOpen) dialog.showModal(); // Reabrir en caso de error
                        });
                    }
                }, 'json').fail(() => {
                    alertaSimple('Error', 'No se pudo comunicar con el servidor.', 'error').then(() => {
                        if (wasDialogOpen) dialog.showModal(); // Reabrir en caso de error de red
                    });
                });
            },
            onCancel: () => {
                if (wasDialogOpen) dialog.showModal(); // Reabrir si se cancela
            }
        });
    });
});

// Función para abrir el modal en modo nuevo registro
function abrirModalNuevo() {
    modoEdicion = false;
    $("#titulo-modal").text("Registrar Usuario");
    limpiarFormulario();
    dialog.showModal();
}

// Función para abrir el modal en modo edición
function abrirModalEdicion(id, usuario, nombre, rol) {
    modoEdicion = true;
    idEditando = id;
    $("#titulo-modal").text("Editar Usuario");
    // Llenar campos con datos del usuario a editar
    $("#usuario").val(usuario).prop('disabled', true);
    $("#nombre").val(nombre);
    $("#rol").val(rol);
    $("#clave").val('');
    dialog.showModal();
}

// Función para limpiar el formulario y resetear el estado de edición
function limpiarFormulario() {
    $("#formulario")[0].reset();
    $("#usuario").prop('disabled', false);
    modoEdicion = false;
    idEditando = null;
}

// Función para cambiar entre pestañas (activos/inactivos)
function cambiarTabEstudiante(tab, e) {
    currentTab = tab;
    $(".tab-button").removeClass("active");
    $(e.target).addClass("active");
    listarUsuarios();
}

// Función para listar y mostrar usuarios (activos o inactivos)
function listarUsuarios() {
    $.getJSON(`../controllers/usuario/Usuario.php?op=listar&estado=${currentTab}`, data => {
        let rows = '';
        data.forEach(u => {
            let acciones = '';
            if (currentTab === 'activos') {
                acciones = `
                <div style="display: flex; gap: 10px;">
                    <button class="task-edit" onclick="abrirModalEdicion(${u.USER_ID}, '${u.USER}', '${u.NAME}', '${u.ID_ROLES}')">
                        <span class="texto">Editar</span>
                        <span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span>
                    </button>
                    <button class="task-delete" onclick="eliminarUsuario(${u.USER_ID})">
                        <span class="texto">Borrar</span>
                        <span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span>
                    </button>
                </div>
                `;
            } else {
                acciones = `
                    <button class="task-restore" onclick="restaurarUsuario(${u.USER_ID})">
                        <span class="texto">Restaurar</span>
                        <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                    </button>
                `;
            }

            rows += `
                <tr>
                    <td>${u.USER}</td>
                    <td>${u.NAME}</td>
                    <td>${u.ROLE_NAME}</td>
                    <td>${acciones}</td>
                </tr>
            `;
        });
        $("#datos").html(rows);
    });
}


// Función para eliminar (inactivar) un usuario
function eliminarUsuario(id) {
    alertaConfirmacion({
        title: '¿Eliminar usuario?',
        text: "Esta acción moverá el usuario a la lista de inactivos.",
        icon: 'warning',
        onConfirm: () => {
            $.post("../controllers/usuario/Usuario.php?op=eliminar", { user_id: id }, (resp) => {
                if (resp.status) {
                    alertaSimple('Eliminado', 'El usuario ha sido desactivado.', 'success');
                    listarUsuarios();
                } else {
                    alertaSimple('Error', resp.error || 'No se pudo eliminar el usuario.', 'error');
                }
            }, 'json');
        }
    });
}

// Función para restaurar (activar) un usuario inactivo
function restaurarUsuario(id) {
    alertaConfirmacion({
        title: '¿Restaurar usuario?',
        onConfirm: () => {
            $.post("../controllers/usuario/Usuario.php?op=restaurar", { user_id: id }, () => {
                alertaSimple('Restaurado', 'El usuario ha sido restaurado.', 'success');
                listarUsuarios();
            }, 'json');
        }
    });
}
