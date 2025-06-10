<?php
require 'header.php';
?>

<span class="text">Carrera</span>
<div class="page-content">
    <div class="message"></div>
    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario para nueva carrera">
            Nuevo +
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Carrera</h2>
            <form action="" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">
                <!-- Código de Carrera -->
                <div class="formulario__grupo" id="grupo__codigo">
                    <label for="codigo" class="formulario__label">Código <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="codigo" id="codigo" placeholder="Ingrese el código de la carrera">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El código debe contener entre 3 y 10 caracteres alfanuméricos</p>
                </div>
                <!-- Nombre de Carrera -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="nombre" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nombre" id="nombre" placeholder="Ingrese el nombre de la carrera" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El nombre debe contener entre 5 y 100 caracteres</p>
                </div>
                <!-- Nota Mínima -->
                <div class="formulario__grupo" id="grupo__nota">
                    <label for="nota" class="formulario__label">Nota Mínima<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="number" class="formulario__input" name="nota" id="nota" placeholder="Nota mínima aprobatoria" min="0" max="20" step="0.01" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">La nota debe estar entre 0 y 20</p>
                </div>
                <!-- Tipos de Pasantías (Checkboxes) -->
                <div class="formulario__grupo" id="grupo__tipos_pasantias">
                    <label class="formulario__label">Tipos de Pasantías</label>
                    <div class="formulario__grupo-checkbox" id="checkbox_container">
                        <!-- Se llenará dinámicamente con JS -->
                    </div>
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
        <button class="tab-button active" onclick="cambiarTab('activos', event)">Carreras Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos', event)">Carreras Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de carreras">
            <thead>
                <tr class="w3-light-grey">
                    <th scope="col" class="sortable">Código</th>
                    <th scope="col" class="sortable">Carrera</th>
                    <th scope="col" class="sortable">Nota Mínima</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display:none;"></tbody>
        </table>
    </div>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        message = document.querySelector('.message');
        const expresiones = {
            codigo: /^[0-9]{3,10}$/, // 3-10 solo números
            nombre: /^[a-zA-ZÀ-ÿ\s]{5,100}$/, // 5-100 letras y espacios
            nota: /^(?:[0-9]|1[0-9]|20)(?:\.\d{1,2})?$/ // 0-20, decimales opcionales
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
            if (await nombreExiste() || await codigoExiste()) {
                return false; // Evitar validación si el nombre o código ya existen
            }
            // Validar código
            if (!validateInput(document.getElementById('codigo'), expresiones.codigo, 'grupo__codigo', 'El código debe contener entre 3 y 10 caracteres numéricos')) {
                errores = true;
            }
            // Validar nombre
            if (!validateInput(document.getElementById('nombre'), expresiones.nombre, 'grupo__nombre', 'El nombre debe contener entre 5 y 100 caracteres alfanuméricos')) {
                errores = true;
            }
            // Validar nota
            if (!validateInput(document.getElementById('nota'), expresiones.nota, 'grupo__nota', 'La nota debe estar entre 0 y 20')) {
                errores = true;
            }
            // Validar tipos de pasantías
            const tipos = document.querySelectorAll('input[name="tipos_pasantias"]:checked');
            if (tipos.length === 0) {
                isIncorrect('grupo__tipos_pasantias', 'Seleccione al menos un tipo de pasantía');
                errores = true;
            } else {
                isCorrect('grupo__tipos_pasantias');
            }
            return !errores;
        }

        async function codigoExiste() {
            const codigo = document.getElementById('codigo').value;
            const id = document.getElementById('id_form').value;
            if (id) {
                // Si hay un ID, no validar el código si es el mismo
                const response = await fetch(`../controllers/carrera/Carrera.php?accion=codigo_existe&id=${id}&codigo=${codigo}`);
                if (!response.ok) {
                    console.error('Error al verificar el código:', response.statusText);
                    return false; // Manejar error de red
                }
                const data = await response.json();
                if (!data.existe) {
                    isCorrect('grupo__codigo');
                    return false;
                }
            }

            if (codigo.length < 3) return false; // No validar si el código es muy corto
            const response = await fetch(`../controllers/carrera/Carrera.php?accion=codigo_existe&codigo=${codigo}`);
            if (!response.ok) {
                console.error('Error al verificar el código:', response.statusText);
                return false; // Manejar error de red
            }
            const data = await response.json();
            if (data.existe) {
                isIncorrect('grupo__codigo', 'El código ya está registrado');
                return true;
            } else {
                isCorrect('grupo__codigo');
                return false;
            }
        }

        async function nombreExiste() {
            const nombre = document.getElementById('nombre').value;
            const id = document.getElementById('id_form').value;
            if (id) {
                // Si hay un ID, no validar el nombre si es el mismo
                const response = await fetch(`../controllers/carrera/Carrera.php?accion=nombre_existe&id=${id}&nombre=${nombre}`);
                if (!response.ok) {
                    console.error('Error al verificar el nombre:', response.statusText);
                    return false; // Manejar error de red
                }
                const data = await response.json();
                if (!data.existe) {
                    isCorrect('grupo__nombre');
                    return false;
                }
            }
            if (nombre.length < 5) return false; // No validar si el nombre es muy corto
            const response = await fetch(`../controllers/carrera/Carrera.php?accion=nombre_existe&nombre=${nombre}`);
            const data = await response.json();
            if (data.existe) {
                isIncorrect('grupo__nombre', 'El nombre ya está registrado');
                return true;
            } else {
                isCorrect('grupo__nombre');
                return false;
            }
        }

        // Validación en tiempo real
        document.getElementById('codigo').addEventListener('input', async function() {
            if (await codigoExiste()) return; // Evitar validación si el código no es válido
            // Validar código y llamar a la función para verificar si existe
            validateInput(this, expresiones.codigo, 'grupo__codigo');
        });
        document.getElementById('nombre').addEventListener('input', async function() {
            if (await nombreExiste()) return; // Evitar validación si el nombre no es válido
            validateInput(this, expresiones.nombre, 'grupo__nombre');
        });
        document.getElementById('nota').addEventListener('input', function() {
            validateInput(this, expresiones.nota, 'grupo__nota');
        });
        document.getElementById('checkbox_container').addEventListener('change', function() {
            const tipos = document.querySelectorAll('input[name="tipos_pasantias"]:checked');
            if (tipos.length === 0) {
                isIncorrect('grupo__tipos_pasantias', 'Seleccione al menos un tipo de pasantía');
            } else {
                isCorrect('grupo__tipos_pasantias');
            }
        });

        // Cargar tipos de pasantías al abrir el modal
        document.querySelector('.primary').addEventListener('click', function() {
            cargarTiposPasantias();
            document.getElementById('dialog').showModal();
            document.getElementById('formulario').reset();
            document.getElementById('id_form').value = ''; // Resetear ID del formulario
        });

        function cargarTiposPasantias() {
            fetch('../controllers/carrera/Carrera.php?accion=listar_tipos_pasantias')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('checkbox_container');
                    container.innerHTML = '';
                    data.forEach(tipo => {
                        container.innerHTML += `
                        <div class="formulario__checkbox">
                            <input type="checkbox" id="tipo_${tipo.INTERNSHIP_TYPE_ID}" 
                                    name="tipos_pasantias" value="${tipo.INTERNSHIP_TYPE_ID}" priority='${tipo.PRIORITY}'">
                            <label for="tipo_${tipo.INTERNSHIP_TYPE_ID}">${tipo.NAME}</label>
                        </div>
                    `;
                    });
                    // Re-attach event listeners after checkboxes are rendered
                    container.querySelectorAll("input[name='tipos_pasantias']").forEach(function(checkbox) {
                        checkbox.addEventListener("change", function() {
                            const priority = this.getAttribute("priority");
                            if (priority === "0" && this.checked) {
                                // Si el de prioridad 0 se selecciona, deselecciona los demás
                                container.querySelectorAll("input[type=checkbox]").forEach(cb => {
                                    if (cb !== this) cb.checked = false;
                                });
                            } else if (container.querySelector("input[type=checkbox][priority='0']:checked")) {
                                // Si el de prioridad 0 está seleccionado, deselecciona este
                                container.querySelector("input[type=checkbox][priority='0']").checked = false;
                                alert("No puedes seleccionar más de un tipo de pasantía cuando haz seleccionado un tipo de pasantía que es unico");
                            }
                        });
                    });
                });
        }

        function listarCarreras(tipo) {
            const endpoint = tipo === 'activos' ? 'listar_activos' : 'listar_inactivos';
            const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';
            fetch(`../controllers/carrera/Carrera.php?accion=${endpoint}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(tablaId).innerHTML = '';
                    data.forEach(carrera => {
                        let acciones = '';
                        if (tipo === 'activos') {
                            acciones = `
                                <button class="task-edit" onclick="editarCarrera(${carrera.CAREER_ID})" title="Editar">
                                    <span class="texto">Editar</span>
                                    <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                </button>
                                <button class="task-delete" onclick="eliminarCarrera(${carrera.CAREER_ID})" title="Eliminar">
                                    <span class="texto">Borrar</span>
                                    <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                </button>
                            `;
                        } else {
                            acciones = `
                                <button class="task-restore" onclick="activarCarrera(${carrera.CAREER_ID})" title="Restaurar">
                                    <span class="texto">Restaurar</span>
                                    <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                </button>
                            `;
                        }
                        document.getElementById(tablaId).innerHTML += `
                            <tr>
                                <td>${carrera.CAREER_CODE}</td>
                                <td>${carrera.CAREER_NAME}</td>
                                <td>${carrera.MINIMUM_GRADE}</td>
                                <td colspan="2">
                                    <div class="acciones-carrera">
                                        ${acciones}
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                });
        }

        // Inicializar ambas listas
        listarCarreras('activos');
        listarCarreras('inactivos');

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
            const tiposPasantias = Array.from(document.querySelectorAll('input[name="tipos_pasantias"]:checked'))
                .map(checkbox => checkbox.value);
            formData.append('tipos_pasantias', JSON.stringify(tiposPasantias));
            fetch(`../controllers/carrera/Carrera.php?accion=${id ? 'actualizar' : 'insertar'}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message || 'Operación exitosa');
                        document.getElementById('dialog').close();
                        this.reset();
                        listarCarreras('activos');
                        listarCarreras('inactivos');
                    } else {
                        alert('Error: ' + (data.error || 'No se pudo completar la operación'));
                    }
                });
        });

        window.editarCarrera = function(id) {
            fetch(`../controllers/carrera/Carrera.php?accion=buscar_para_editar&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const carrera = data[0];
                        document.getElementById("id_form").value = carrera.CAREER_ID;
                        document.getElementById('codigo').value = carrera.CAREER_CODE;
                        document.getElementById('nombre').value = carrera.CAREER_NAME;
                        document.getElementById('nota').value = carrera.MINIMUM_GRADE;
                        // Marcar los checkboxes de tipos de pasantías
                        cargarTiposPasantias();
                        setTimeout(() => {
                            carrera.CAREER_INTERNSHIP_TYPES.forEach(tipo => {
                                const checkbox = document.getElementById(`tipo_${tipo.INTERNSHIP_TYPE_ID}`);
                                if (checkbox) checkbox.checked = true;
                            });
                        }, 200);
                        document.getElementById('dialog').showModal();
                    }
                });
        };

        window.eliminarCarrera = function(id) {
            if (confirm('¿Está seguro de desactivar esta carrera?')) {
                const formData = new FormData();
                formData.append('id', id);
                fetch('../controllers/carrera/Carrera.php?accion=eliminar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || (data.success ? 'Carrera desactivada' : 'Error al desactivar'));
                        if (data.success) {
                            listarCarreras('activos');
                            listarCarreras('inactivos');
                        }
                    });
            }
        };

        window.activarCarrera = function(id) {
            if (confirm('¿Está seguro de reactivar esta carrera?')) {
                const formData = new FormData();
                formData.append('id', id);
                fetch('../controllers/carrera/Carrera.php?accion=restaurar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || (data.success ? 'Carrera reactivada' : 'Error al reactivar'));
                        if (data.success) {
                            listarCarreras('activos');
                            listarCarreras('inactivos');
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