<?php require 'header.php'; ?>
<span class="text" style="margin-left: 1rem;">Responsables Institucionales</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialogResponsable.showModal();">
            Nuevo <span>+</span>
        </button>

        <dialog id="dialog-responsable">
            <h2>Registrar Responsable</h2>
            <form id="formulario" class="formulario">
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
                            name="MANAGER_CI"
                            id="MANAGER_CI"
                            placeholder="Ej: 12345678"
                            maxlength="9"
                            required>
                    </div>

                    <p class="formulario__input-error">Formato válido: X-12345678</p>
                </div>

                <!-- SELECT DE INSTITUCIONES -->
                <div class="formulario__grupo">
                    <label for="institucion_id">Institución <span class="obligatorio">*</span></label>
                    <select name="INSTITUTION_ID" id="INSTITUTION_ID" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una institución</option>
                    </select>
                </div>

                <div class="formulario__grupo">
                    <label for="nombre">Primer Nombre <span class="obligatorio">*</span></label>
                    <input type="text" name="NAME" id="NAME" class="formulario__input" required>
                </div>

                <div class="formulario__grupo">
                    <label for="segundo_nombre">Segundo Nombre</label>
                    <input type="text" name="SECOND_NAME" id="SECOND_NAME" class="formulario__input">
                </div>

                <div class="formulario__grupo">
                    <label for="apellido">Primer Apellido <span class="obligatorio">*</span></label>
                    <input type="text" name="SURNAME" id="SURNAME" class="formulario__input" required>
                </div>

                <div class="formulario__grupo">
                    <label for="segundo_apellido">Segundo Apellido</label>
                    <input type="text" name="SECOND_SURNAME" id="SECOND_SURNAME" class="formulario__input">
                </div>
                <!-- Contacto -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="prefijo_telefono" required>
                                <option value="0412">0412</option>
                                <option value="0414">0414</option>
                                <option value="0416">0416</option>
                                <option value="0422">0422</option>
                                <option value="0424">0424</option>
                                <option value="0426">0426</option>
                                <option value="0255">0255</option>
                            </select>
                        </div>

                        <input type="tel" class="formulario__input formulario__telefono-input" name="CONTACT_PHONE" id="CONTACT_PHONE" placeholder="Ej: 1234567" maxlength="7" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato requerido: XXX-XXXXXXX</p>
                </div>

                <div class="formulario__grupo">
                    <label for="EMAIL">Correo Electrónico <span class="obligatorio">*</span></label>
                    <input type="email" name="EMAIL" id="EMAIL" class="formulario__input" required>
                    <span id="error-correo" style="color:red;display:none;">Este correo ya está registrado</span>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                </div>
            </form>

            <button onclick="window.dialogResponsable.close();" class="x">❌</button>
        </dialog>
    </div>

    <!-- Tabs para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTabResponsables('activos')">Responsables Activos</button>
        <button class="tab-button" onclick="cambiarTabResponsables('inactivos')">Responsables Inactivos</button>
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
                    <th>Institución</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-responsables-activos"></tbody>
            <tbody id="datos-responsables-inactivos" style="display: none;"></tbody>
        </table>
    </div>
<a href="Institucion.php" class="btn-link-responsables" style="margin: 1rem 0; display: inline-block;">
    Volver a Instituciones
</a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formulario");
    const dialog = document.getElementById("dialog-responsable");
    window.dialogResponsable = document.getElementById("dialog-responsable");

    // Cargar opciones del select de instituciones
    fetch("../controllers/Institucion/Institucion.php?accion=instituciones_select")
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById("INSTITUTION_ID");
            data.forEach(inst => {
                const option = document.createElement("option");
                option.value = inst.id;
                option.textContent = inst.nombre;
                select.appendChild(option);
            });
        });

    // Cargar responsables activos e inactivos al iniciar
    listarResponsables('activos');
    listarResponsables('inactivos');

    function listarResponsables(tipo) {
        const endpoint = tipo === 'activos' ? 'listar_activas' : 'listar_inactivas';
        const tablaId = tipo === 'activos' ? 'datos-responsables-activos' : 'datos-responsables-inactivos';

        fetch(`../controllers/institution_manager/InstitutionManager.php?accion=${endpoint}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById(tablaId).innerHTML = "";
                data.forEach(p => {
                    document.getElementById(tablaId).innerHTML += `
                        <tr>
                            <td>${p.MANAGER_CI}</td>
                            <td>${p.NAME} ${p.SECOND_NAME ?? ''}</td>
                            <td>${p.SURNAME} ${p.SECOND_SURNAME ?? ''}</td>
                            <td>${p.CONTACT_PHONE}</td>
                            <td>${p.EMAIL}</td>
                            <td>${p.INSTITUTION_NAME ?? ''}</td>
                            <td>
                                ${
                                    tipo === 'activos'
                                    ? `<div style="display: flex; gap: 0.5rem;">
                                            <button class="task-action task-edit" onclick="editarResponsable(${p.MANAGER_ID})" title="Editar">
                                                <span class="texto">Editar</span>
                                                <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                            </button>
                                            <button class="task-action task-delete" onclick="eliminarResponsable(${p.MANAGER_ID})" title="Desactivar">
                                                <span class="texto">Borrar</span>
                                                <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                            </button>
                                       </div>`
                                    : `<button class="task-action task-restore" onclick="restaurarResponsable(${p.MANAGER_ID})" title="Restaurar">
                                            <span class="texto">Restaurar</span>
                                            <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                       </button>`
                                }
                            </td>
                        </tr>
                    `;
                });
            });
    }

    // Cambiar pestaña de responsables
    window.cambiarTabResponsables = function(tab) {
        document.querySelectorAll('.tabs .tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        if (tab === 'activos') {
            document.getElementById('datos-responsables-activos').style.display = '';
            document.getElementById('datos-responsables-inactivos').style.display = 'none';
        } else {
            document.getElementById('datos-responsables-activos').style.display = 'none';
            document.getElementById('datos-responsables-inactivos').style.display = '';
        }
    }

    const cedulaInput = document.getElementById("MANAGER_CI");
    const correoInput = document.getElementById("EMAIL");
    const errorCedula = document.getElementById("error-cedula");
    const errorCorreo = document.getElementById("error-correo");

    // Validar cédula al salir del campo
    cedulaInput.addEventListener("blur", function () {
        const cedula = cedulaInput.value.trim();
        const id = document.getElementById("id_form").value;
        if (cedula) {
            fetch(`../controllers/institution_manager/InstitutionManager.php?accion=validar_cedula&cedula=${encodeURIComponent(cedula)}&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.existe) {
                        errorCedula.style.display = "inline";
                    } else {
                        errorCedula.style.display = "none";
                    }
                });
        }
    });

    // Validar correo al salir del campo
    correoInput.addEventListener("blur", function () {
        const correo = correoInput.value.trim();
        const id = document.getElementById("id_form").value;
        if (correo) {
            fetch(`../controllers/institution_manager/InstitutionManager.php?accion=validar_correo&correo=${encodeURIComponent(correo)}&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.existe) {
                        errorCorreo.style.display = "inline";
                    } else {
                        errorCorreo.style.display = "none";
                    }
                });
        }
    });

    // Validar antes de enviar el formulario
    formulario.addEventListener("submit", function (e) {
        if (errorCedula.style.display === "inline" || errorCorreo.style.display === "inline") {
            alert("No se puede registrar: la cédula o el correo ya existen.");
            e.preventDefault();
        }
    });

    // Registrar o actualizar responsable
    formulario.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(formulario);
        const id = formData.get("id_form");

        // Concatenar prefijo y número de teléfono
        const prefijoTelefono = document.getElementById("prefijo_telefono").value;
        const numeroTelefono = document.getElementById("CONTACT_PHONE").value;
        formData.set("CONTACT_PHONE", `${prefijoTelefono}-${numeroTelefono}`);

        formData.append("accion", id ? "actualizar" : "insertar");
        formData.append("id", id);

        fetch("../controllers/institution_manager/InstitutionManager.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert(id ? "Responsable editado exitosamente" : "Responsable guardado exitosamente");
                formulario.reset();
                dialog.close();
                listarResponsables('activos');
                listarResponsables('inactivos');
            } else {
                alert(res.message || res.error || "Error al guardar o editar responsable");
            }
        })
        .catch(err => {
            alert("Error en la comunicación con el servidor: " + err);
        });
    });

    // Editar responsable
    window.editarResponsable = function (id) {
        fetch(`../controllers/institution_manager/InstitutionManager.php?accion=buscar&id=${id}`)
            .then(res => res.json())
            .then(data => {
                cedula = data.MANAGER_CI.split('-');
                document.getElementById("id_form").value = data.MANAGER_ID;
                document.getElementById("nacionalidad").value = cedula[0] ?? 'V';
                document.getElementById("MANAGER_CI").value = cedula[1] ?? '';
                document.getElementById("NAME").value = data.NAME ?? '';
                document.getElementById("SECOND_NAME").value = data.SECOND_NAME ?? '';
                document.getElementById("SURNAME").value = data.SURNAME ?? '';
                document.getElementById("SECOND_SURNAME").value = data.SECOND_SURNAME ?? '';

                // Separar prefijo y número de teléfono para la edición
                const telefonoCompleto = data.CONTACT_PHONE;
                const partesTelefono = telefonoCompleto.split('-');
                if (partesTelefono.length === 2) {
                    document.getElementById("prefijo_telefono").value = partesTelefono[0];
                    document.getElementById("CONTACT_PHONE").value = partesTelefono[1];
                } else {
                    // Si no tiene el formato esperado, asignar el valor completo al número y un prefijo por defecto
                    document.getElementById("prefijo_telefono").value = '0412'; // O el que consideres por defecto
                    document.getElementById("CONTACT_PHONE").value = telefonoCompleto;
                }

                document.getElementById("EMAIL").value = data.EMAIL;
                document.getElementById("INSTITUTION_ID").value = data.INSTITUTION_ID;
                dialog.showModal();
            })
            .catch(err => {
                alert("Error al cargar los datos del responsable: " + err);
            });
    }

    // Desactivar responsable
    window.eliminarResponsable = function (id) {
        if (confirm("¿Está seguro de desactivar este responsable?")) {
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
                    alert("Responsable desactivado correctamente");
                    listarResponsables('activos');
                    listarResponsables('inactivos');
                } else {
                    alert(res.message || res.error || "Error al desactivar responsable");
                }
            })
            .catch(err => {
                alert("Error en la comunicación con el servidor: " + err);
            });
        }
    }

    // Restaurar responsable
    window.restaurarResponsable = function (id) {
        if (confirm("¿Está seguro de restaurar este responsable?")) {
            const form = new FormData();
            form.append("accion", "restaurar");
            form.append("id", id);

            fetch("../controllers/institution_manager/InstitutionManager.php", {
                method: "POST",
                body: form
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    alert(res.message || "Responsable restaurado correctamente");
                    listarResponsables('activos');
                    listarResponsables('inactivos');
                } else {
                    alert(res.message || res.error || "Error al restaurar responsable");
                }
            })
            .catch(err => {
                alert("Error en la comunicación con el servidor: " + err);
            });
        }
    }

    // Función para limpiar estilos y campos del formulario
    function limpiarFormularioResponsable() {
        formulario.reset();
        document.getElementById("id_form").value = "";
        // Oculta los mensajes de error de cédula y correo
        document.getElementById("error-cedula").style.display = "none";
        document.getElementById("error-correo").style.display = "none";
        // Si tienes clases de error, elimínalas aquí
        formulario.querySelectorAll('.formulario__input').forEach(input => {
            input.classList.remove('input-error');
        });
        // Restablecer el prefijo del teléfono a su valor por defecto si es necesario
        document.getElementById("prefijo_telefono").value = '0412';
    }

    // Botón cerrar modal responsable
    document.querySelector("#dialog-responsable .x").onclick = function() {
        limpiarFormularioResponsable();
        dialog.close();
    };

    // Al cerrar el modal con cualquier método
    dialog.addEventListener('close', function() {
        limpiarFormularioResponsable();
    });



    function cerrarTodosLosModales() {
        // Cierra el modal de institución si existe y está abierto
        const dialogInstitucion = document.getElementById("dialog");
        if (dialogInstitucion && dialogInstitucion.open) dialogInstitucion.close();
        // Cierra el modal de responsable si existe y está abierto
        const dialogResponsable = document.getElementById("dialog-responsable");
        if (dialogResponsable && dialogResponsable.open) dialogResponsable.close();
    }
});
</script>
<?php require 'footer.php'; ?>