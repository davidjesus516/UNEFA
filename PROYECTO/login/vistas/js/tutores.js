// No longer needed as it will be handled by cargarSelect
// Función para cargar profesiones
// cargarProfesion = () => { ... }

document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formulario");
    const dialog = document.getElementById("dialog");
    const userId = 1; // Reemplaza por ID real del usuario si aplica

    // Botón de cerrar modal que limpia el formulario
    document.querySelector('.x').addEventListener('click', function () {
        dialog.close();
        formulario.reset();
        document.getElementById("id_form").value = '';
    });

    // --- Selects dinámicos ---
    const selectMap = {
        condicion: 9,
        profesion: 20, // Add profesion to the map with its LIST_ID
        dedicacion: 10,
        categoria: 11
    };

    for (const [id, listId] of Object.entries(selectMap)) {
        cargarSelect(id, listId);
    }

    function cargarSelect(id, listId) {
        const select = document.getElementById(id);
        if (!select) return;
        fetch(`../controllers/value_list/ListManager.php?accion=getValoresPorLista&list_id=${listId}`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data)) {
                    console.error(`Error al obtener valores para select "${id}"`);
                    return;
                }
                select.innerHTML = `<option value="" disabled selected>Seleccione una opción</option>`;
                data.forEach(item => {
                    select.innerHTML += `<option value="${item.ABBREVIATION}">${item.NAME}</option>`;
                });
            });
    }

    // --- Tabs activos/inactivos ---
    function cambiarTab(tipo) {
        if (tipo === 'activos') {
            document.getElementById('datos-activos').style.display = '';
            document.getElementById('datos-inactivos').style.display = 'none';
            document.querySelectorAll('.tab-button')[0].classList.add('active');
            document.querySelectorAll('.tab-button')[1].classList.remove('active');
        } else {
            document.getElementById('datos-activos').style.display = 'none';
            document.getElementById('datos-inactivos').style.display = '';
            document.querySelectorAll('.tab-button')[0].classList.remove('active');
            document.querySelectorAll('.tab-button')[1].classList.add('active');
        }
    }
    window.cambiarTab = cambiarTab;

    // --- Listar tutores ---
    function listarTutores() {
        fetch("../controllers/tutor/Tutor.php?accion=listar")
            .then(response => response.json())
            .then((data) => {
                renderTutores(data);
            });
    }

    function renderTutores(data) {
        const activos = data.activos || [];
        const inactivos = data.inactivos || [];
        let htmlActivos = '';
        let htmlInactivos = '';

        activos.forEach(tutor => {
            htmlActivos += `
            <tr>
                <td>${tutor.TUTOR_CI ?? ''}</td>
                <td>${tutor.NAME ?? ''} ${tutor.SECOND_NAME ?? ''}</td>
                <td>${tutor.SURNAME ?? ''} ${tutor.SECOND_SURNAME ?? ''}</td>
                <td>${tutor.GENDER ?? ''}</td>
                <td>${tutor.CONTACT_PHONE ?? ''}</td>
                <td>${tutor.EMAIL ?? ''}</td>
                <td>${tutor.PROFESSION ?? ''}</td>
                <td>
                    <button class="task-action task-edit" data-id="${tutor.TUTOR_ID}">
                        <span class="texto">Editar</span>
                        <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                    </button>
                </td>
                <td>
                    <button class="task-action task-delete" data-id="${tutor.TUTOR_ID}">
                        <span class="texto">Borrar</span>
                        <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                    </button>
                </td>
            </tr>
        `;
        });

        inactivos.forEach(tutor => {
            htmlInactivos += `
            <tr>
                <td>${tutor.TUTOR_CI ?? ''}</td>
                <td>${tutor.NAME ?? ''} ${tutor.SECOND_NAME ?? ''}</td>
                <td>${tutor.SURNAME ?? ''} ${tutor.SECOND_SURNAME ?? ''}</td>
                <td>${tutor.GENDER ?? ''}</td>
                <td>${tutor.CONTACT_PHONE ?? ''}</td>
                <td>${tutor.EMAIL ?? ''}</td>
                <td>${tutor.PROFESSION ?? ''}</td>
                <td colspan="2">
                    <button class="task-action task-restore" data-id="${tutor.TUTOR_ID}">
                        <span class="texto">Restaurar</span>
                        <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                    </button>
                </td>
            </tr>
        `;
        });

        document.getElementById('datos-activos').innerHTML = htmlActivos;
        document.getElementById('datos-inactivos').innerHTML = htmlInactivos;
    }

    // --- Registrar o actualizar ---
    formulario.addEventListener("submit", function (e) {
        e.preventDefault();

        // Cerrar el diálogo antes de mostrar la confirmación
        if (dialog.open) {
            dialog.close();
        }

        const formData = new FormData(formulario);
        const id = formData.get("id_form");
        const accion = id ? "actualizar" : "insertar";
        const titulo = id ? "¿Deseas actualizar este tutor?" : "¿Deseas registrar un nuevo tutor?";

        const operadora = document.getElementById("operadora").value;
        const telefono = document.getElementById("telefono").value;
        formData.set("telefono", operadora + '-' + telefono);

        formData.append("accion", accion);
        formData.append("user_id", userId);
        formData.append("id", id);

        Swal.fire({
            title: 'Confirmar acción',
            text: titulo,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) {
                // Volver a abrir el diálogo si se cancela
                dialog.showModal();
                return false;
            }

            fetch("../controllers/tutor/Tutor.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Operación realizada correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            listarTutores();
                        });
                    } else if (res.error === 'La cédula ya existe') {
                        Swal.fire({
                            title: 'Error',
                            text: 'La cédula ya existe en el sistema',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            dialog.showModal();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al realizar la operación',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            dialog.showModal();
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error en la conexión con el servidor',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
        });
    });

    // --- Editar tutor ---
    window.editarTutor = function (id) {
        fetch(`../controllers/tutor/Tutor.php?accion=buscar&id=${id}`)
            .then(res => res.json())
            .then(data => {
                cedula = data.TUTOR_CI.split('-') ?? '';
                tlf = data.CONTACT_PHONE.split('-') ?? '';
                document.getElementById("id_form").value = data.TUTOR_ID ?? '';
                document.getElementById("nacionalidad").value = cedula[0] ?? 'V';
                document.getElementById("cedula").value = cedula[1] ?? '';
                document.getElementById("primer_nombre").value = data.NAME ?? '';
                document.getElementById("segundo_nombre").value = data.SECOND_NAME ?? '';
                document.getElementById("primer_apellido").value = data.SURNAME ?? '';
                document.getElementById("segundo_apellido").value = data.SECOND_SURNAME ?? '';
                document.getElementById("sexo").value = data.GENDER ?? '';
                document.getElementById("operadora").value = tlf[0] ?? '0412';
                document.getElementById("telefono").value = tlf[1] ?? '';
                document.getElementById("e_mail").value = data.EMAIL ?? '';
                document.getElementById("profesion").value = data.PROFESSION ?? ''; // This will now correctly set the abbreviation
                document.getElementById("condicion").value = data.CONDITION ?? '';
                document.getElementById("dedicacion").value = data.DEDICATION ?? '';
                document.getElementById("categoria").value = data.CATEGORY ?? '';
                dialog.showModal();
            });
    }

    // --- Eliminar tutor ---
    window.eliminarTutor = function (id) {
        Swal.fire({
            title: '¿Eliminar tutor?',
            text: "¿Estás seguro de que deseas eliminar este tutor?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = new FormData();
                form.append("accion", "eliminar");
                form.append("id", id);
                form.append("user_id", userId);

                fetch("../controllers/tutor/Tutor.php", {
                    method: "POST",
                    body: form
                })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            Swal.fire({
                                title: 'Eliminado',
                                text: 'El tutor fue eliminado correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                listarTutores();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'No se pudo eliminar el tutor',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    });
            }
        });
    }

    // --- Restaurar tutor ---
    window.restaurarTutor = function (id) {
        Swal.fire({
            title: '¿Restaurar tutor?',
            text: "¿Estás seguro de que deseas restaurar este tutor?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = new FormData();
                form.append("accion", "restaurar");
                form.append("id", id);
                form.append("user_id", userId);

                fetch("../controllers/tutor/Tutor.php", {
                    method: "POST",
                    body: form
                })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            Swal.fire({
                                title: 'Restaurado',
                                text: 'El tutor fue restaurado correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                listarTutores();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'No se pudo restaurar el tutor',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error de conexión con el servidor',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
            }
        });
    }

    // Limpiar formulario al abrir modal de nuevo tutor
    document.querySelector('.primary').addEventListener('click', function () {
        dialog.showModal();
    });

    // Inicialmente mostrar activos y cargar tutores
    cambiarTab('activos');
    listarTutores();

    // Editar tutor
    $(document).on('click', '.task-edit', function () {
        const id = $(this).data('id');
        window.editarTutor(id);
    });

    // Eliminar tutor
    $(document).on('click', '.task-delete', function () {
        const id = $(this).data('id');
        window.eliminarTutor(id);
    });

    // Restaurar tutor
    $(document).on('click', '.task-restore', function () {
        const id = $(this).data('id');
        window.restaurarTutor(id);
    });
});