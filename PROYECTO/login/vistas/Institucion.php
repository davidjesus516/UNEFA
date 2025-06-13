<?php require 'header.php'; ?>
<span class="text">Instituciones</span>

<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" id="btn-nueva-institucion" aria-label="Abrir formulario de nueva institución">
            Nueva <span>+</span>
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Institución</h2>

            <form action="#" class="formulario" id="formulario">
                <input type="hidden" id="id_form" name="id_form">

                <!-- RIF -->
                <div class="formulario__grupo" id="grupo__rif">
                    <label for="rif" class="formulario__label">RIF <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="rif" id="rif" 
                               placeholder="Ej: J-123456789" pattern="[JGVEP]-[0-9]{8,9}" 
                               title="Formato: X-123456789" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Formato válido: X-123456789</p>
                </div>

                <!-- Nombre -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="nombre" class="formulario__label">Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nombre" id="nombre" 
                               placeholder="Ingrese el nombre de la institución" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="formulario__grupo" id="grupo__direccion">
                    <label for="direccion" class="formulario__label">Dirección Fiscal<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <textarea class="formulario__input" name="direccion" id="direccion" 
                                  placeholder="Ingrese la dirección" required></textarea>
                    </div>
                </div>

                <!-- Teléfono -->
                <div class="formulario__grupo" id="grupo__contacto">
                    <label for="contacto" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="tel" class="formulario__input" name="contacto" id="contacto" 
                               placeholder="Ej: 02121234567" required>
                    </div>
                </div>

                <!-- Tipo de Práctica -->
                <div class="formulario__grupo" id="grupo__tipo_practica">
                    <label for="tipo_practica" class="formulario__label">Tipo Práctica <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="tipo_practica" id="tipo_practica" 
                               placeholder="Ej: Pasantías, Servicio Comunitario" required>
                    </div>
                </div>

                <!-- Región -->
                <div class="formulario__grupo" id="grupo__region">
                    <label for="region" class="formulario__label">Región <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="region" id="region" 
                               placeholder="Ej: Capital, Central" required>
                    </div>
                </div>

                <!-- Núcleo -->
                <div class="formulario__grupo" id="grupo__nucleo">
                    <label for="nucleo" class="formulario__label">Núcleo <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="nucleo" id="nucleo" 
                               placeholder="Ej: Principal, Extensiones" required>
                    </div>
                </div>

                <!-- Extensión -->
                <div class="formulario__grupo" id="grupo__extension">
                    <label for="extension" class="formulario__label">Extensión <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="extension" id="extension" 
                               placeholder="Ej: Valencia, Maracay" required>
                    </div>
                </div>

                <!-- Tipo de Institución -->
                <div class="formulario__grupo" id="grupo__tipo_institucion">
                    <label for="tipo_institucion" class="formulario__label">Tipo Institución <span class="obligatorio">*</span></label>
                    <select id="tipo_institucion" name="tipo_institucion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <!-- <option value="PUBLICA">PÚBLICA</option>
                        <option value="PRIVADA">PRIVADA</option>
                        <option value="MIXTA">MIXTA</option> -->
                    </select>
                </div>

                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente.</p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>

            <button type="button" class="x" id="cerrar-modal" aria-label="Cerrar formulario de institución">❌</button>
        </dialog>
    </div>

    <!-- Pestañas para activos/inactivos -->
    <div class="tabs">
        <button class="tab-button active" onclick="cambiarTab('activos')">Instituciones Activas</button>
        <button class="tab-button" onclick="cambiarTab('inactivos')">Instituciones Inactivas</button>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de instituciones">
            <thead>
                <tr class="w3-light-grey">
                    <th>RIF</th>
                    <th>Nombre</th>
                    <th>Dirección Fiscal</th>
                    <th>Teléfono</th>
                    <th>Tipo</th>
                    <th>Región</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos-activos"></tbody>
            <tbody id="datos-inactivos" style="display: none;"></tbody>
        </table>
    </div>
<a href="responsables.php" class="btn-link-responsables" style="margin: 1rem 0; display: inline-block;">
    Ir a Responsables Institucionales
</a>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formulario");
    const dialog = document.getElementById("dialog");
    const btnNueva = document.getElementById("btn-nueva-institucion");
    const btnCerrar = document.getElementById("cerrar-modal");

    // Limpiar formulario
    function limpiarFormulario() {
        formulario.reset();
        document.getElementById("id_form").value = "";
    }

    // Abrir modal y limpiar formulario
    btnNueva.addEventListener("click", function() {
        limpiarFormulario();
        dialog.showModal();
    });

    // Cerrar modal y limpiar formulario
    btnCerrar.addEventListener("click", function() {
        dialog.close();
        limpiarFormulario();
    });

    // Limpiar formulario al cerrar el modal (por cualquier método)
    dialog.addEventListener("close", function() {
        limpiarFormulario();
    });

    // Cargar instituciones activas al iniciar
    listarInstituciones('activos');
    listarInstituciones('inactivos'); // <-- Agrega esta línea

    function listarInstituciones(tipo) {
        const endpoint = tipo === 'activos' ? 'listar_activas' : 'listar_inactivas';
        const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';
        
        fetch(`../controllers/Institucion/Institucion.php?accion=${endpoint}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById(tablaId).innerHTML = "";
                data.forEach(institucion => {
                    document.getElementById(tablaId).innerHTML += `
                        <tr taskid="${institucion.INSTITUTION_ID}">
                            <td>${institucion.RIF}</td>
                            <td>${institucion.INSTITUTION_NAME}</td>
                            <td>${institucion.INSTITUTION_ADDRESS}</td> 
                            <td>${institucion.INSTITUTION_CONTACT}</td>
                            <td>${institucion.INSTITUTION_TYPE}</td>
                            <td>${institucion.REGION}</td>
                            <td>
                                ${
                                    tipo === 'activos'
                                    ? `<button class="task-action task-edit" data-id="${institucion.INSTITUTION_ID}">
                                            <span class="texto">Editar</span>
                                            <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                       </button>`
                                    : ''
                                }
                            </td>
                            <td>
                                ${
                                    tipo === 'activos'
                                    ? `<button class="task-action task-delete" data-id="${institucion.INSTITUTION_ID}">
                                            <span class="texto">Borrar</span>
                                            <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                       </button>`
                                    : `<button class="task-action task-restore" data-id="${institucion.INSTITUTION_ID}">
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

    // Registrar o actualizar
    formulario.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(formulario);
        const id = formData.get("id_form");
        const accion = id ? "actualizar" : "insertar";

        formData.append("id", id);

        fetch(`../controllers/Institucion/Institucion.php?accion=${accion}`, {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert(res.message || "Operación exitosa");
                formulario.reset();
                dialog.close();
                listarInstituciones('activos');
                listarInstituciones('inactivos');
            } else {
                alert(res.error || "Error al guardar");
            }
        });
    });

    window.editarInstitucion = function (id) {
        fetch(`../controllers/Institucion/Institucion.php?accion=buscar_por_id&id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data) {
                    document.getElementById("id_form").value = data.INSTITUTION_ID;
                    document.getElementById("rif").value = data.RIF;
                    document.getElementById("nombre").value = data.INSTITUTION_NAME;
                    document.getElementById("direccion").value = data.INSTITUTION_ADDRESS;
                    document.getElementById("contacto").value = data.INSTITUTION_CONTACT;
                    document.getElementById("tipo_practica").value = data.PRACTICE_TYPE;
                    document.getElementById("region").value = data.REGION;
                    document.getElementById("nucleo").value = data.NUCLEUS;
                    document.getElementById("extension").value = data.EXTENSION;
                    document.getElementById("tipo_institucion").value = data.INSTITUTION_TYPE;
                    
                    dialog.showModal();
                }
            });
    }

    window.desactivarInstitucion = function (id) {
        if (confirm("¿Está seguro de desactivar esta institución?")) {
            const form = new FormData();
            form.append("id", id);

            fetch("../controllers/Institucion/Institucion.php?accion=eliminar", {
                method: "POST",
                body: form
            })
            .then(res => res.json())
            .then(res => {
                alert(res.message || (res.success ? "Institución desactivada" : "Error al desactivar"));
                if (res.success) {
                    listarInstituciones('activos');
                    listarInstituciones('inactivos');
                }
            });
        }
    }

    window.activarInstitucion = function (id) {
        if (confirm("¿Está seguro de reactivar esta institución?")) {
            const form = new FormData();
            form.append("id", id);

            fetch("../controllers/Institucion/Institucion.php?accion=restaurar", {
                method: "POST",
                body: form
            })
            .then(res => res.json())
            .then(res => {
                alert(res.message || (res.success ? "Institución reactivada" : "Error al reactivar"));
                if (res.success) {
                    listarInstituciones('activos');
                    listarInstituciones('inactivos');
                }
            });
        }
    }

    // Validar RIF en tiempo real
    document.getElementById("rif").addEventListener("change", function() {
        const rif = this.value;
        const id = document.getElementById("id_form").value;
        
        if (rif) {
            fetch(`../controllers/Institucion/Institucion.php?accion=verificar_rif&rif=${rif}&id_excluir=${id || ''}`)
                .then(res => res.json())
                .then(res => {
                    if (res.existe) {
                        alert("Este RIF ya está registrado");
                        this.value = "";
                    }
                });
        }
    });

    window.cambiarTab = function(tab) {
        // Cambiar botones activos
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // Mostrar/ocultar tablas
        if (tab === 'activos') {
            document.getElementById('datos-activos').style.display = '';
            document.getElementById('datos-inactivos').style.display = 'none';
        } else {
            document.getElementById('datos-activos').style.display = 'none';
            document.getElementById('datos-inactivos').style.display = '';
        }
    }

    $(document).ready(function () {
        // Evento Editar
        $(document).on('click', '.task-edit', function () {
            let id = $(this).data('id');
            fetch(`../controllers/Institucion/Institucion.php?accion=buscar_por_id&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        $("#id_form").val(data.INSTITUTION_ID);
                        $("#rif").val(data.RIF);
                        $("#nombre").val(data.INSTITUTION_NAME);
                        $("#direccion").val(data.INSTITUTION_ADDRESS);
                        $("#contacto").val(data.INSTITUTION_CONTACT);
                        $("#tipo_practica").val(data.PRACTICE_TYPE);
                        $("#region").val(data.REGION);
                        $("#nucleo").val(data.NUCLEUS);
                        $("#extension").val(data.EXTENSION);
                        $("#tipo_institucion").val(data.INSTITUTION_TYPE);
                        $("#dialog")[0].showModal();
                    }
                });
        });

        // Evento Eliminar (Desactivar)
        $(document).on('click', '.task-delete', function () {
            let id = $(this).data('id');
            if (confirm("¿Está seguro de desactivar esta institución?")) {
                const form = new FormData();
                form.append("id", id);
                fetch("../controllers/Institucion/Institucion.php?accion=eliminar", {
                    method: "POST",
                    body: form
                })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message || (res.success ? "Institución desactivada" : "Error al desactivar"));
                        if (res.success) {
                            listarInstituciones('activos');
                            listarInstituciones('inactivos');
                        }
                    });
            }
        });

        // Evento Restaurar (Activar)
        $(document).on('click', '.task-restore', function () {
            let id = $(this).data('id');
            if (confirm("¿Está seguro de reactivar esta institución?")) {
                const form = new FormData();
                form.append("id", id);
                fetch("../controllers/Institucion/Institucion.php?accion=restaurar", {
                    method: "POST",
                    body: form
                })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message || (res.success ? "Institución reactivada" : "Error al reactivar"));
                        if (res.success) {
                            listarInstituciones('activos');
                            listarInstituciones('inactivos');
                        }
                    });
            }
        });
    });
});
</script>

<?php require 'footer.php'; ?>