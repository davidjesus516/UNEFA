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

                <!-- Cédula -->
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="cedula" class="formulario__label">Cédula <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input formulario__grupo-cedula">
                        <select class="formulario__input formulario__codigo-select" id="nacionalidad" name="nacionalidad" required>
                            <option value="V">V-</option>
                            <option value="E">E-</option>
                            <option value="P">P-</option>
                        </select>

                        <input type="text" class="formulario__input formulario__cedula-input"
                            name="cedula" id="cedula" placeholder="Ej: 12345678"
                            pattern="\d{7,8}" maxlength="8" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Formato válido: X-12345678</p>
                </div>

                <!-- Primer Nombre -->
                <div class="formulario__grupo" id="grupo__primer_nombre">
                    <label for="primer_nombre" class="formulario__label">Primer Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="primer_nombre" id="primer_nombre" placeholder="Ingrese el nombre" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Segundo Nombre -->
                <div class="formulario__grupo" id="grupo__segundo_nombre">
                    <label for="segundo_nombre" class="formulario__label">Segundo Nombre</label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="segundo_nombre" id="segundo_nombre" placeholder="Ingrese el segundo nombre">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                </div>

                <!-- Primer Apellido -->
                <div class="formulario__grupo" id="grupo__primer_apellido">
                    <label for="primer_apellido" class="formulario__label">Primer Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="primer_apellido" id="primer_apellido" placeholder="Ingrese el primer apellido" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                </div>

                <!-- Segundo Apellido -->
                <div class="formulario__grupo" id="grupo__segundo_apellido">
                    <label for="segundo_apellido" class="formulario__label">Segundo Apellido</label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="segundo_apellido" id="segundo_apellido" placeholder="Ingrese el segundo apellido">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                </div>

                <!-- Sexo -->
                <div class="formulario__grupo" id="grupo__sexo">
                    <label for="sexo" class="formulario__label">Sexo <span class="obligatorio">*</span></label>
                    <select id="sexo" name="sexo" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>

                <!-- Teléfono -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <select class="formulario__input formulario__codigo-select" name="codigo_telefono" required>
                            <option value="0412">0412</option>
                            <option value="0414">0414</option>
                            <option value="0416">0416</option>
                            <option value="0422">0422</option>
                            <option value="0424">0424</option>
                            <option value="0426">0426</option>
                            <option value="0255">0255</option>
                        </select>
                        <input type="tel" class="formulario__input formulario__telefono-input" name="telefono" id="telefono" placeholder="0000000" pattern="\d{7}" required>
                    </div>
                </div>

                <!-- Correo -->
                <div class="formulario__grupo" id="grupo__correo">
                    <label for="e_mail" class="formulario__label">Correo Electrónico <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="email" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electrónico" required>
                    </div>
                </div>

                <!-- Condición -->
                <div class="formulario__grupo">
                    <label for="condicion" class="formulario__label">Condición <span class="obligatorio">*</span></label>
                    <select id="condicion" name="condicion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <!-- Agrega opciones reales -->
                    </select>
                </div>

                <!-- Dedicación -->
                <div class="formulario__grupo">
                    <label for="dedicacion" class="formulario__label">Dedicación <span class="obligatorio">*</span></label>
                    <select id="dedicacion" name="dedicacion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <!-- Agrega opciones reales -->
                    </select>
                </div>

                <!-- Categoría -->
                <div class="formulario__grupo">
                    <label for="categoria" class="formulario__label">Categoría <span class="obligatorio">*</span></label>
                    <select id="categoria" name="categoria" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <!-- Agrega opciones reales -->
                    </select>
                </div>

                <!-- Profesión -->
                <div class="formulario__grupo">
                    <label for="profesion" class="formulario__label">Profesión <span class="obligatorio">*</span></label>
                    <select id="profesion" name="profesion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <!-- Agrega opciones reales -->
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

            <button onclick="window.dialog.close();" class="x" aria-label="Cerrar formulario de tutor">❌</button>
        </dialog>
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
            <tbody id="datos"></tbody>
        </table>
    </div>
</div>

<script src="js/estudiante/jquery-3.7.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formulario");
    const tablaBody = document.getElementById("datos");
    const dialog = document.getElementById("dialog");
    const userId = 1; // Reemplaza por ID real del usuario si aplica

    // Cargar tutores al iniciar
    listarTutores();

    function listarTutores() {
        fetch("../controllers/tutor/Tutor.php?accion=listar")
            .then(response => response.json())
            .then(data => {
                tablaBody.innerHTML = "";
                data.forEach(tutor => {
                    tablaBody.innerHTML += `
                        <tr>
                            <td>${tutor.TUTOR_CI}</td>
                            <td>${tutor.NAME} ${tutor.SECOND_NAME ?? ''}</td>
                            <td>${tutor.SURNAME} ${tutor.SECOND_SURNAME ?? ''}</td>
                            <td>${tutor.GENDER}</td>
                            <td>${tutor.CONTACT_PHONE}</td>
                            <td>${tutor.EMAIL}</td>
                            <td>${tutor.PROFESSION}</td>
                            <td>
                                <button onclick="editarTutor(${tutor.TUTOR_ID})">✏️</button>
                                <button onclick="eliminarTutor(${tutor.TUTOR_ID})">🗑️</button>
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
            } else {
                alert("Error al guardar");
            }
        });
    });

    window.editarTutor = function (id) {
        fetch(`../controllers/tutor/Tutor.php?accion=buscar&id=${id}`)
            .then(res => res.json())
            .then(data => {

                console.log(data);
                document.getElementById("id_form").value = data.TUTOR_ID;
                document.getElementById("cedula").value = data.TUTOR_CI;
                document.getElementById("primer_nombre").value = data.NAME;
                document.getElementById("segundo_nombre").value = data.SECOND_NAME;
                document.getElementById("primer_apellido").value = data.SURNAME;
                document.getElementById("segundo_apellido").value = data.SECOND_SURNAME;
                document.getElementById("sexo").value = data.GENDER;
                document.getElementById("telefono").value = data.CONTACT_PHONE;
                document.getElementById("e_mail").value = data.EMAIL;
                document.getElementById("profesion").value = data.PROFESSION;
                document.getElementById("condicion").value = data.CONDITION;
                document.getElementById("dedicacion").value = data.DEDICATION;
                document.getElementById("categoria").value = data.CATEGORY;
                dialog.showModal();
            });
    }

    window.eliminarTutor = function (id) {
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
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Lista de campos select a poblar
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

                // Limpia y agrega opciones
                select.innerHTML = `<option value="" disabled selected>Seleccione una opción</option>`;
                data.forEach(item => {
                    select.innerHTML += `<option value="${item.ABBREVIATION}">${item.NAME}</option>`;
                });
            });
    }
});
</script>



<?php require 'footer.php'; ?>
