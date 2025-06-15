<?php
require 'header.php';
?>

<span class="text">Tipos Práctica Profesional</span>
<div class="page-content">
    <div class="message"></div>
    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario para nuevo tipo de práctica">
            Nuevo +
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Tipo Práctica</h2>
            <form action="" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">
                <!-- Nombre de Práctica -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="nombre" class="formulario__label">Nombre Práctica <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nombre" id="nombre" placeholder="Ingrese el nombre de la práctica" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre debe contener entre 5 y 100 caracteres</p>
                </div>
                <!-- Prioridad -->
                <div class="formulario__grupo" id="grupo__prioridad">
                    <label for="prioridad" class="formulario__label">Prioridad <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" name="prioridad" id="prioridad" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Seleccione una prioridad válida</p>
                </div>
                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
                </div>
                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>
            <button onclick="window.dialog.close();" class="x" aria-label="Cerrar formulario">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos', event)">Prácticas Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos', event)">Prácticas Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de prácticas">
            <thead>
                <tr class="w3-light-grey">
                    <th scope="col" class="sortable">Nombre</th>
                    <th scope="col" class="sortable">Prioridad</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display:none;"></tbody>
        </table>
    </div>
    <a href="carrera.php" class="btn-link-responsables" style="margin: 1rem 0; display: inline-block;">
        Volver a Carrera
    </a>
</div>
<style>
    /* Estilo para las acciones de los botones */
    .acciones-practica {
        display: flex;
        gap: 0.5rem;
        /* Espaciado entre los botones */
        justify-content: center;
        /* Centrar los botones horizontalmente */
    }

    .task-edit,
    .task-delete,
    .task-restore {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.7rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        /* transition: background 0.2s; */
    }

    .task-edit:hover {
        background: rgb(45, 42, 133);
    }

    .task-delete:hover {
        background: rgb(121, 11, 50);
    }

    .task-restore:hover {
        background: rgb(72, 173, 72);
    }

    .icon i {
        margin-left: 0.2rem;
    }
</style>

<script src="js/jquery-3.7.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const expresiones = {
            nombre: /^[a-zA-ZÀ-ÿ\s]{5,100}$/, // 5-100 letras y espacios
        };

        function isCorrect(id) {
            const grupo = document.getElementById(id);
            if (!grupo) return;
            grupo.classList.add("formulario__grupo-correcto");
            grupo.classList.remove("formulario__grupo-incorrecto");
            const icon = grupo.querySelector('i');
            if (icon) {
                icon.classList.add("fa-check-circle");
                icon.classList.remove("fa-times-circle");
            }
            const errorMsg = grupo.querySelector('.formulario__input-error');
            if (errorMsg) errorMsg.classList.remove("formulario__input-error-activo");
        }

        function isIncorrect(id, message) {
            const grupo = document.getElementById(id);
            if (!grupo) return;
            grupo.classList.add("formulario__grupo-incorrecto");
            grupo.classList.remove("formulario__grupo-correcto");
            const icon = grupo.querySelector('i');
            if (icon) {
                icon.classList.add("fa-times-circle");
                icon.classList.remove("fa-check-circle");
            }
            const errorMsg = grupo.querySelector('.formulario__input-error');
            if (errorMsg) {
                errorMsg.classList.add("formulario__input-error-activo");
                if (message) errorMsg.textContent = message;
            }
        }

        function validateInput(input, regex, id, message) {
            if (regex.test(input.value)) {
                isCorrect(id);
                return true;
            } else {
                isIncorrect(id, message || 'El campo no es válido');
                return false;
            }
        }

        async function validateForm() {
            let errores = false;
            // Validar nombre
            if (!validateInput(document.getElementById('nombre'), expresiones.nombre, 'grupo__nombre', 'El nombre debe contener entre 5 y 100 caracteres alfanuméricos')) {
                errores = true;
            }
            // Validar prioridad
            const prioridad = document.getElementById('prioridad').value;
            if (!['0', '1', '2'].includes(prioridad)) {
                isIncorrect('grupo__prioridad', 'Seleccione una prioridad válida');
                errores = true;
            } else {
                isCorrect('grupo__prioridad');
            }
            return !errores;
        }

        function listarPracticas(tipo) {
            const endpoint = tipo === 'activos' ? 'listar_activos' : 'listar_inactivos';
            const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';
            fetch(`../controllers/tipo_practica/TipoPractica.php?accion=${endpoint}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(tablaId).innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(practica => {
                            let acciones = '';
                            if (tipo === 'activos') {
                                acciones = `
                                    <button class="task-edit" onclick="editarPractica(${practica.ID || practica.id})" title="Editar">
                                        <span class="texto">Editar</span>
                                        <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                    </button>
                                    <button class="task-delete" onclick="eliminarPractica(${practica.ID || practica.id})" title="Eliminar">
                                        <span class="texto">Borrar</span>
                                        <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                    </button>
                                `;
                            } else {
                                acciones = `
                                    <button class="task-restore" onclick="activarPractica(${practica.ID || practica.id})" title="Restaurar">
                                        <span class="texto">Restaurar</span>
                                        <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                    </button>
                                `;
                            }
                            document.getElementById(tablaId).innerHTML += `
                                <tr>
                                    <td>${practica.NAME || practica.name}</td>
                                    <td>${practica.PRIORITY || practica.priority}</td>
                                    <td colspan="2">
                                        <div class="acciones-practica">
                                            ${acciones}
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        document.getElementById(tablaId).innerHTML = '<tr><td colspan="3">No hay registros disponibles.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error al listar prácticas:', error);
                });
        }

        // Inicializar ambas listas
        listarPracticas('activos');
        listarPracticas('inactivos');

        // Manejar el envío del formulario
        document.getElementById('formulario').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = formData.get("id_form");
            formData.append("id", id);
            // Validar el formulario
            if (!(await validateForm())) {
                alert('Por favor, corrige los errores antes de enviar el formulario.');
                return;
            }
            fetch(`../controllers/tipo_practica/TipoPractica.php?accion=${id ? 'actualizar' : 'insertar'}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then((data) => {
                    if (data.success) {
                        alert(data.message || 'Operación exitosa');
                        document.getElementById('dialog').close();
                        this.reset();
                        listarPracticas('activos');
                        listarPracticas('inactivos');
                    } else {
                        alert('Error: ' + (data.error || 'No se pudo completar la operación'));
                    }
                });
        });

        window.editarPractica = function(id) {
            console.log('ID recibido para editar:', id);
            fetch(`../controllers/tipo_practica/TipoPractica.php?accion=buscar_para_editar&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const practica = data[0];
                        document.getElementById("id_form").value = practica.ID;
                        document.getElementById('nombre').value = practica.NAME;
                        document.getElementById('prioridad').value = practica.PRIORITY;
                        document.getElementById('dialog').showModal();
                    } else {
                        alert('No se encontró la práctica.');
                    }
                })
                .catch(error => {
                    console.error('Error al buscar la práctica:', error);
                });
        };

        window.eliminarPractica = function(id) {
            if (confirm('¿Está seguro de desactivar esta práctica?')) {
                const formData = new FormData();
                formData.append('id', id);
                fetch('../controllers/tipo_practica/TipoPractica.php?accion=eliminar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Práctica desactivada correctamente.');
                            listarPracticas('activos');
                            listarPracticas('inactivos');
                        } else {
                            alert('Error al desactivar la práctica.');
                        }
                    })
                    .catch(error => {
                        console.error('Error al desactivar la práctica:', error);
                    });
            }
        };

        window.activarPractica = function(id) {
            if (confirm('¿Está seguro de reactivar esta práctica?')) {
                const formData = new FormData();
                formData.append('id', id);
                fetch('../controllers/tipo_practica/TipoPractica.php?accion=restaurar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || (data.success ? 'Práctica reactivada' : 'Error al reactivar'));
                        if (data.success) {
                            listarPracticas('activos');
                            listarPracticas('inactivos');
                        }
                    });
            }
        };

        window.cambiarTab = function(tab, event) {
            // Cambiar botones activos
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            if (event) event.target.classList.add('active');
            // Mostrar/ocultar tablas
            if (tab === 'activos') {
                document.getElementById('datos-activos').style.display = '';
                document.getElementById('datos-inactivos').style.display = 'none';
            } else {
                document.getElementById('datos-activos').style.display = 'none';
                document.getElementById('datos-inactivos').style.display = '';
            }
        };
    });
</script>

<?php
require 'footer.php';
?>