<?php require 'header.php'; ?>

<span class="text">Tutores</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario de nuevo tutor">
            Nuevo <span>+</span>
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Tutor</h2>
            <form action="#" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">

                <!-- Grupo: Cédula -->
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="cedula" class="formulario__label">Cédula <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-cedula">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="nacionalidad" name="nacionalidad" required>
                                <!-- <option value="" disabled selected>Nac.</option> -->
                                <option value="V">V-</option>
                                <option value="E">E-</option>
                                <option value="P">P-</option>
                            </select>
                        </div>
                        <input type="text"
                            class="formulario__input formulario__cedula-input"
                            name="cedula"
                            id="cedula"
                            placeholder="Ej: 12345678"
                            maxlength="9"
                            required>
                    </div>

                    <p class="formulario__input-error">Formato válido: X-12345678</p>
                </div>

                <!-- Nombres -->
                <?php
                $campos = [
                    ['primer_nombre', 'Primer Nombre', true],
                    ['segundo_nombre', 'Segundo Nombre', false],
                    ['primer_apellido', 'Primer Apellido', true],
                    ['segundo_apellido', 'Segundo Apellido', false]
                ];
                foreach ($campos as [$id, $label, $requerido]) : ?>
                    <div class="formulario__grupo" id="grupo__<?= $id ?>">
                        <label for="<?= $id ?>" class="formulario__label"><?= $label ?><?= $requerido ? ' <span class="obligatorio">*</span>' : '' ?></label>
                        <div class="formulario__grupo-input">
                            <input type="text" class="formulario__input" name="<?= $id ?>" id="<?= $id ?>" placeholder="Ingrese <?= strtolower($label) ?>" <?= $requerido ? 'required' : '' ?>>
                            <i class="formulario__validacion-estado fas fa-times-circle"></i>
                        </div>
                        <?php if ($id === 'primer_nombre') : ?>
                            <p class="formulario__input-error">Este campo solo debe contener letras</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <!-- Sexo -->
                <div class="formulario__grupo" id="grupo__sexo">
                    <label for="sexo" class="formulario__label">Sexo <span class="obligatorio">*</span></label>
                    <select id="sexo" name="sexo" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="MASCULINO">MASCULINO</option>
                        <option value="FEMENINO">FEMENINO</option>
                    </select>
                </div>

                <!-- Contacto -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="operadora" required>
                                <option value="0412">0412</option>
                                <option value="0414">0414</option>
                                <option value="0416">0416</option>
                                <option value="0422">0422</option>
                                <option value="0424">0424</option>
                                <option value="0426">0426</option>
                                <option value="0255">0255</option>
                            </select>
                        </div>

                        <input type="tel" class="formulario__input formulario__telefono-input" name="telefono" id="telefono" placeholder="(555) 000-000" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato requerido: (XXX) XXX-XXXX</p>
                </div>

                <!-- Correo -->
                <div class="formulario__grupo" id="grupo__correo">
                    <label for="e_mail" class="formulario__label">Correo Electrónico <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="email" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electrónico" required>
                    </div>
                </div>

                <!-- Selects dinámicos -->
                <?php
                $selects = [
                    ['condicion', 'Condición'],
                    ['dedicacion', 'Dedicación'],
                    ['categoria', 'Categoría'],
                    ['profesion', 'Profesión']
                ];
                foreach ($selects as [$id, $label]) : ?>
                    <div class="formulario__grupo">
                        <label for="<?= $id ?>" class="formulario__label"><?= $label ?> <span class="obligatorio">*</span></label>
                        <select id="<?= $id ?>" name="<?= $id ?>" class="selector formulario__input" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                        </select>
                    </div>
                <?php endforeach; ?>

                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>
            <button onclick="window.dialog.close();" class="x" aria-label="Cerrar formulario de tutor">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos')">Tutores Activos</button>
        <button class="tab-button" onclick="cambiarTab('inactivos')">Tutores Inactivos</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de tutores">
            <thead>
                <tr class="w3-light-grey">
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Sexo</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Profesión</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display:none"></tbody>
        </table>
    </div>
</div>

<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const formulario = document.getElementById("formulario");
    const dialog = document.getElementById("dialog");
    const userId = 1; // Reemplaza por ID real del usuario si aplica

    // --- Selects dinámicos ---
    const selectMap = {
        profesion: 20,
        condicion: 9,
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
    formulario.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(formulario);
        const id = formData.get("id_form");

        const operadora = document.getElementById("operadora").value;
        const telefono = document.getElementById("telefono").value;
        formData.set("telefono", operadora + '-' + telefono); // Combina prefijo y número con guion

        formData.append("accion", id ? "actualizar" : "insertar");
        formData.append("user_id", userId);
        formData.append("id", id);

        fetch("../controllers/tutor/Tutor.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert("Guardado exitosamente");
                formulario.reset();
                dialog.close();
                listarTutores();
            } else if (res.error === 'La cédula ya existe') {
                alert("Error: La cédula ya existe en el sistema.");
            } else {
                alert("Error al guardar");
            }
        });
    });

    // --- Editar tutor ---
    window.editarTutor = function(id) {
        fetch(`../controllers/tutor/Tutor.php?accion=buscar&id=${id}`)
            .then(res => res.json())
            .then(data => {
                cedula = data.TUTOR_CI.split('-') ?? '';
                document.getElementById("id_form").value = data.TUTOR_ID ?? '';
                document.getElementById("nacionalidad").value = cedula[0] ?? 'V';
                document.getElementById("cedula").value = cedula[1] ?? '';
                document.getElementById("primer_nombre").value = data.NAME ?? '';
                document.getElementById("segundo_nombre").value = data.SECOND_NAME ?? '';
                document.getElementById("primer_apellido").value = data.SURNAME ?? '';
                document.getElementById("segundo_apellido").value = data.SECOND_SURNAME ?? '';
                document.getElementById("sexo").value = data.GENDER ?? '';
                document.getElementById("telefono").value = data.CONTACT_PHONE ?? '';
                document.getElementById("e_mail").value = data.EMAIL ?? '';
                document.getElementById("profesion").value = data.PROFESSION ?? '';
                document.getElementById("condicion").value = data.CONDITION ?? '';
                document.getElementById("dedicacion").value = data.DEDICATION ?? '';
                document.getElementById("categoria").value = data.CATEGORY ?? '';
                dialog.showModal();
            });
    }

    // --- Eliminar tutor ---
    window.eliminarTutor = function(id) {
        if (confirm("¿Está seguro de eliminar este tutor?")) {
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
                    alert("Eliminado correctamente");
                    listarTutores();
                } else {
                    alert("Error al eliminar");
                }
            });
        }
    }

    // --- Restaurar tutor ---
    window.restaurarTutor = function(id) {
        console.log("Intentando restaurar tutor con id:", id);
        if (confirm("¿Está seguro de restaurar este tutor?")) {
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
                console.log("Respuesta de restaurar:", res);
                if (res.success) {
                    alert("Restaurado correctamente");
                    listarTutores();
                } else {
                    alert("Error al restaurar");
                }
            })
            .catch(err => {
                console.error("Error en fetch:", err);
                alert("Error de red o de formato en la respuesta");
            });
        }
    }

    // --- Limpiar formulario al abrir modal de nuevo tutor ---
    document.querySelector('.primary').addEventListener('click', function() {
        formulario.reset();
        document.getElementById("id_form").value = '';
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
</script>

<?php require 'footer.php'; ?>