<?php
require 'header.php';
?>
<style>
    .custom-select-container {
        position: relative;
        font-family: Arial, sans-serif;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: white;
        cursor: pointer;
        min-height: 38px;
        /* Ajustar según la altura de tus inputs */
        display: flex;
        align-items: center;
    }

    .custom-select-options,
    .custom-select-container:hover {
        border-end-end-radius: 0;
    }

    .custom-select-selected {
        padding: 8px 10px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 100%;
        color: #555;
        /* Color de placeholder */
        padding-right: 30px;
        /* Espacio para el icono de flecha */
    }

    .custom-select-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 4px 4px;
        background-color: white;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        scale: 1.006;

    }

    .custom-select-options .option-item {
        padding: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .custom-select-options .option-item:hover {
        background-color: #f0f0f0;
    }

    .custom-select-options .option-item input[type="checkbox"] {
        margin-right: 8px;
    }

    .custom-select-arrow {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        /* Para que el icono no interfiera con el click */
        color: #888;
    }
</style>

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
                <!-- Abreviatura -->
                <div class="formulario__grupo" id="grupo__abreviatura">
                    <label for="abreviatura" class="formulario__label">Abreviatura <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="abreviatura" id="abreviatura" placeholder="Ej: TSU-E, ING-S" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">La abreviatura es requerida (max 15 caracteres)</p>
                </div>
                <!-- Tipos de Pasantías (Checkboxes) -->
                <div class="formulario__grupo" id="grupo__tipos_pasantias">
                    <label class="formulario__label"><a href="tipo_practica.php">Tipos Práctica Profesional</a></label>
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
                    <th scope="col" class="sortable">Abreviatura</th>
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
            nota: /^(?:[0-9]|1[0-9]|20)(?:\.\d{1,2})?$/, // 0-20, decimales opcionales
            abreviatura: /^[a-zA-Z0-9-]{2,15}$/ // 2-15 caracteres alfanuméricos y guiones
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
            // Validar abreviatura
            if (!validateInput(document.getElementById('abreviatura'), expresiones.abreviatura, 'grupo__abreviatura', 'La abreviatura debe tener entre 2 y 15 caracteres alfanuméricos y guiones.')) {
                errores = true;
            }
            // Validar tipos de pasantías
            const tipos = document.querySelectorAll('input[name="tipos_pasantias"]:checked');
            if (tipos.length === 0) {
                isIncorrect('grupo__tipos_pasantias', 'Seleccione al menos un tipo de práctica');
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
        document.getElementById('abreviatura').addEventListener('input', function() {
            validateInput(this, expresiones.abreviatura, 'grupo__abreviatura');
        });

        function validateTiposPasantias() {
            const tipos = document.querySelectorAll('#checkbox_container input[name="tipos_pasantias"]:checked');
            if (tipos.length === 0) {
                isIncorrect('grupo__tipos_pasantias', 'Seleccione al menos un tipo de práctica');
                return false;
            } else {
                isCorrect('grupo__tipos_pasantias');
                return true;
            }
        }

        // Cargar tipos de pasantías al abrir el modal
        document.querySelector('.primary').addEventListener('click', function() {
            cargarTiposPasantias();
            document.getElementById('dialog').showModal();
            document.getElementById('formulario').reset();
            // Asegurarse de que el display del custom select se resetee
            const selectedDisplay = document.querySelector('#checkbox_container .custom-select-selected');
            if (selectedDisplay) {
                selectedDisplay.textContent = 'Seleccione Tipos de Práctica...';
            }
            document.getElementById('id_form').value = ''; // Resetear ID del formulario
        });

        function updateSelectedDisplay(displayElement, optionsContainer) {
            const selectedOptions = [];
            optionsContainer.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const label = checkbox.closest('.option-item').querySelector('label');
                if (label) selectedOptions.push(label.textContent);
            });

            if (selectedOptions.length > 0) {
                displayElement.textContent = selectedOptions.join(', ');
            } else {
                displayElement.textContent = 'Seleccione Tipos de Práctica...';
            }
        }

        function cargarTiposPasantias() {
            fetch('../controllers/carrera/Carrera.php?accion=listar_tipos_pasantias')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('checkbox_container');
                    container.innerHTML = ''; // Limpiar contenido previo

                    const selectContainer = document.createElement('div');
                    selectContainer.className = 'custom-select-container';

                    const selectedDisplay = document.createElement('div');
                    selectedDisplay.className = 'custom-select-selected';
                    selectedDisplay.textContent = 'Seleccione Tipos de Práctica...';
                    selectContainer.appendChild(selectedDisplay);

                    const arrowIcon = document.createElement('i');
                    arrowIcon.className = 'fas fa-chevron-down custom-select-arrow';
                    selectContainer.appendChild(arrowIcon);


                    const optionsContainer = document.createElement('div');
                    optionsContainer.className = 'custom-select-options';
                    optionsContainer.style.display = 'none'; // Oculto inicialmente

                    data.forEach(tipo => {
                        const optionDiv = document.createElement('div');
                        optionDiv.className = 'option-item';

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = `tipo_${tipo.INTERNSHIP_TYPE_ID}`;
                        checkbox.name = 'tipos_pasantias';
                        checkbox.value = tipo.INTERNSHIP_TYPE_ID;
                        checkbox.setAttribute('priority', tipo.PRIORITY);

                        const label = document.createElement('label');
                        label.htmlFor = `tipo_${tipo.INTERNSHIP_TYPE_ID}`;
                        label.textContent = tipo.NAME;

                        optionDiv.appendChild(checkbox);
                        optionDiv.appendChild(label);
                        optionsContainer.appendChild(optionDiv);

                        checkbox.addEventListener('change', function() {
                            const priority = this.getAttribute("priority");
                            const priorityZeroCheckbox = optionsContainer.querySelector("input[type=checkbox][priority='0']");

                            if (this.checked) {
                                if (priority === "0") {
                                    optionsContainer.querySelectorAll("input[type=checkbox]").forEach(cb => {
                                        if (cb !== this) cb.checked = false;
                                    });
                                } else {
                                    if (priorityZeroCheckbox && priorityZeroCheckbox.checked) {
                                        priorityZeroCheckbox.checked = false;
                                    }
                                }
                            }
                            updateSelectedDisplay(selectedDisplay, optionsContainer);
                            validateTiposPasantias();
                        });
                    });

                    selectContainer.appendChild(optionsContainer);
                    container.appendChild(selectContainer);

                    selectedDisplay.addEventListener('click', (event) => {
                        event.stopPropagation(); // Evitar que el click se propague al document
                        optionsContainer.style.display = optionsContainer.style.display === 'none' ? 'block' : 'none';
                    });

                    // Cerrar el dropdown si se hace clic fuera
                    document.addEventListener('click', function(event) {
                        if (!selectContainer.contains(event.target) && optionsContainer.style.display === 'block') {
                            optionsContainer.style.display = 'none';
                        }
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
                                <td>${carrera.CAREER_ABBREVIATION || ''}</td>
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
            const tiposPasantias = Array.from(document.querySelectorAll('#checkbox_container input[name="tipos_pasantias"]:checked'))
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
                        document.getElementById('abreviatura').value = carrera.CAREER_ABBREVIATION || '';
                        // Marcar los checkboxes de tipos de pasantías
                        cargarTiposPasantias(); // Esto reconstruirá el select

                        setTimeout(() => { // Esperar a que cargarTiposPasantias complete y renderice
                            const optionsContainer = document.querySelector('#checkbox_container .custom-select-options');
                            const selectedDisplay = document.querySelector('#checkbox_container .custom-select-selected');

                            if (optionsContainer && selectedDisplay) {
                                // Desmarcar todos primero
                                optionsContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                                // Marcar los correspondientes
                                carrera.CAREER_INTERNSHIP_TYPES.forEach(tipo => {
                                    const checkbox = optionsContainer.querySelector(`#tipo_${tipo.INTERNSHIP_TYPE_ID}`);
                                    if (checkbox) checkbox.checked = true;
                                });
                                updateSelectedDisplay(selectedDisplay, optionsContainer);
                            }
                            validateTiposPasantias(); // Validar después de establecer
                        }, 300); // Un pequeño delay para asegurar la renderización
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