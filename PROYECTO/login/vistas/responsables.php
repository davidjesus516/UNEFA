<?php require 'header.php'; ?>
<span class="text">Responsables Institucionales</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();">
            Nuevo <span>+</span>
        </button>

        <dialog id="dialog">
            <h2>Registrar Responsable</h2>
            <form id="formulario" class="formulario">
                <input type="hidden" id="id_form" name="id_form">

                <!-- SELECT DE INSTITUCIONES -->
                <div class="formulario__grupo">
                    <label for="institucion_id">Institución <span class="obligatorio">*</span></label>
                    <select name="institucion_id" id="institucion_id" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una institución</option>
                    </select>
                </div>

                <div class="formulario__grupo">
                    <label for="cedula">Cédula <span class="obligatorio">*</span></label>
                    <input type="text" name="cedula" id="cedula" class="formulario__input" required>
                </div>

                <div class="formulario__grupo">
                    <label for="nombre">Primer Nombre <span class="obligatorio">*</span></label>
                    <input type="text" name="nombre" id="nombre" class="formulario__input" required>
                </div>

                <div class="formulario__grupo">
                    <label for="segundo_nombre">Segundo Nombre</label>
                    <input type="text" name="segundo_nombre" id="segundo_nombre" class="formulario__input">
                </div>

                <div class="formulario__grupo">
                    <label for="apellido">Primer Apellido <span class="obligatorio">*</span></label>
                    <input type="text" name="apellido" id="apellido" class="formulario__input" required>
                </div>

                <div class="formulario__grupo">
                    <label for="segundo_apellido">Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido" class="formulario__input">
                </div>

                <div class="formulario__grupo">
                    <label for="telefono">Teléfono <span class="obligatorio">*</span></label>
                    <input type="text" name="telefono" id="telefono" class="formulario__input" required>
                </div>

                <div class="formulario__grupo">
                    <label for="correo">Correo Electrónico <span class="obligatorio">*</span></label>
                    <input type="email" name="correo" id="correo" class="formulario__input" required>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                </div>
            </form>

            <button onclick="window.dialog.close();" class="x">❌</button>
        </dialog>
    </div>

    <div class="table-container">
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr class="w3-light-grey">
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="datos"></tbody>
        </table>
    </div>
</div>

<!-- JS -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formulario = document.getElementById("formulario");
        const tablaBody = document.getElementById("datos");
        const dialog = document.getElementById("dialog");

        // Cargar opciones del select de instituciones (versión mejorada)
        fetch("../controllers/Institucion/Institucion.php?accion=instituciones_select")
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error al cargar instituciones');
                }
                return res.json();
            })
            .then(data => {
                const select = document.getElementById("institucion_id");
                // Limpiar select primero
                select.innerHTML = '<option value="" disabled selected>Seleccione una institución</option>';

                // Llenar con opciones
                data.forEach(inst => {
                    const option = document.createElement("option");
                    option.value = inst.id;
                    option.textContent = inst.nombre;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Error:", error);
                alert("No se pudieron cargar las instituciones. Por favor recarga la página.");
            });

        listarResponsables();

        function listarResponsables() {
            fetch("../controllers/institution_manager/InstitutionManager.php?accion=listar")
                .then(response => response.json())
                .then(data => {
                    tablaBody.innerHTML = "";
                    data.forEach(p => {
                        tablaBody.innerHTML += `
                        <tr>
                            <td>${p.MANAGER_CI}</td>
                            <td>${p.NAME} ${p.SECOND_NAME ?? ''}</td>
                            <td>${p.SURNAME} ${p.SECOND_SURNAME ?? ''}</td>
                            <td>${p.CONTACT_PHONE}</td>
                            <td>${p.EMAIL}</td>
                            <td>
                                <button onclick="editar(${p.MANAGER_ID})">✏️</button>
                                <button onclick="eliminar(${p.MANAGER_ID})">🗑️</button>
                            </td>
                        </tr>
                    `;
                    });
                });
        }

        formulario.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(formulario);
            const id = formData.get("id_form");
            formData.append("accion", id ? "actualizar" : "insertar");
            formData.append("id", id);

            fetch("../controllers/institution_manager/InstitutionManager.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        alert("Guardado exitosamente");
                        formulario.reset();
                        dialog.close();
                        listarResponsables();
                    } else {
                        alert("Error al guardar");
                    }
                });
        });

        window.editar = function(id) {
            fetch(`../controllers/institution_manager/InstitutionManager.php?accion=buscar&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("id_form").value = data.MANAGER_ID;
                    document.getElementById("cedula").value = data.MANAGER_CI;
                    document.getElementById("nombre").value = data.NAME;
                    document.getElementById("segundo_nombre").value = data.SECOND_NAME || '';
                    document.getElementById("apellido").value = data.SURNAME;
                    document.getElementById("segundo_apellido").value = data.SECOND_SURNAME || '';
                    document.getElementById("telefono").value = data.CONTACT_PHONE;
                    document.getElementById("correo").value = data.EMAIL;

                    // Precargar institución si existe el campo
                    if (data.INSTITUTION_ID && document.getElementById("institucion_id")) {
                        document.getElementById("institucion_id").value = data.INSTITUTION_ID;
                    }

                    dialog.showModal();
                });
        }

        window.eliminar = function(id) {
            if (confirm("¿Está seguro de eliminar este responsable?")) {
                const form = new FormData();
                form.append("accion", "eliminar");
                form.append("id", id);

                fetch("../controllers/institution_manager/InstitutionManager.php", {
                        method: "POST",
                        body: form
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            alert("Eliminado correctamente");
                            listarResponsables();
                        } else {
                            alert("Error al eliminar");
                        }
                    });
            }
        }
    });
</script>

<?php require 'footer.php'; ?>