
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formulario");
    const dialog = document.getElementById("dialog");
    const btnNueva = document.getElementById("btn-nueva-institucion");
    const btnCerrar = document.getElementById("cerrar-modal");
    const tipoPracticaSelect = document.getElementById("tipo_practica");
    const carreraSelect = document.getElementById("carrera");
    const careerIdHidden = document.getElementById("career_id_hidden");
    // Limpiar formulario
    function limpiarFormulario() {
        formulario.reset();
        document.getElementById("id_form").value = "";
        $('#dialogTitle').text('Registrar Institución'); // Restaurar título por defecto
        $('#formulario').find('input, select, textarea').prop('disabled', false); // Habilitar todos los campos
        $('#carrera').prop('disabled', true); // Deshabilitar carrera específicamente
        $('.formulario__btn').show(); // Asegurarse que el botón de guardar esté visible

        // Resetear estilos de validación
        document.querySelectorAll('.formulario__grupo').forEach(group => {
            group.classList.remove('formulario__grupo-correcto', 'formulario__grupo-incorrecto');
        });
        document.querySelectorAll('.formulario__input-error-activo').forEach(el => {
            el.classList.remove('formulario__input-error-activo');
        });
        document.querySelectorAll('.formulario__grupo i').forEach(icon => {
            icon.classList.remove("fa-check-circle", "fa-times-circle");
        });
    }

    // Abrir modal y limpiar formulario
    btnNueva.addEventListener("click", function () {
        limpiarFormulario();
        dialog.showModal();
    });

    // Cerrar modal y limpiar formulario
    btnCerrar.addEventListener("click", function () {
        dialog.close();
        limpiarFormulario();
    });

    // --- INICIO VALIDACIÓN CLIENTE ---
    const formInputs = {
        rif: formulario.querySelector('#rif'),
        nombre: formulario.querySelector('#nombre'),
        direccion: formulario.querySelector('#direccion'),
        operadora: formulario.querySelector('#operadora'),
        telefono_numero: formulario.querySelector('#telefono_numero'),
        tipo_practica: formulario.querySelector('#tipo_practica'),
        carrera: formulario.querySelector('#carrera'),
        region: formulario.querySelector('#region'),
        nucleo: formulario.querySelector('#nucleo'),
        extension: formulario.querySelector('#extension'),
        tipo_institucion: formulario.querySelector('#tipo_institucion'),
    };

    const expresiones = {
        rif: /^[JGVEPjgvep]-\d{8,9}$/,
        nombre: /^[a-zA-ZÀ-ÿ\s0-9.,'-]{4,100}$/,
        direccion: /.{10,255}/s, // s flag para que . coincida con saltos de línea
        telefono_numero: /^\d{7}$/
    };

    const setValidationState = (element, isValid, message) => {
        const group = element.closest('.formulario__grupo');
        const errorP = group.querySelector('.formulario__input-error');
        const icon = group.querySelector('.formulario__validacion-estado');

        if (isValid) {
            group.classList.remove('formulario__grupo-incorrecto');
            group.classList.add('formulario__grupo-correcto');
            if (icon) {
                icon.classList.remove('fa-times-circle');
                icon.classList.add('fa-check-circle');
            }
            if (errorP) errorP.classList.remove('formulario__input-error-activo');
        } else {
            group.classList.remove('formulario__grupo-correcto');
            group.classList.add('formulario__grupo-incorrecto');
            if (icon) {
                icon.classList.remove('fa-check-circle');
                icon.classList.add('fa-times-circle');
            }
            if (errorP) {
                errorP.textContent = message;
                errorP.classList.add('formulario__input-error-activo');
            }
        }
    };

    const validateField = (field) => {
        let isValid = false;
        let message = '';
        const fieldName = field.name;

        if (expresiones[fieldName]) {
            isValid = expresiones[fieldName].test(field.value.trim());
            message = field.title || `El valor para ${fieldName} no es válido.`;
        } else if (field.tagName === 'SELECT' || field.tagName === 'TEXTAREA') {
            isValid = field.value.trim() !== '';
            message = `Debe seleccionar o rellenar este campo.`;
        }
        setValidationState(field, isValid, message);
        return isValid;
    };

    Object.values(formInputs).forEach(input => {
        if (input) {
            const eventType = (input.tagName === 'SELECT' || input.tagName === 'TEXTAREA') ? 'change' : 'blur';
            input.addEventListener(eventType, () => validateField(input));
            if (input.tagName === 'INPUT') {
                input.addEventListener('keyup', () => validateField(input));
            }
        }
    });
    // --- FIN VALIDACIÓN CLIENTE ---

    function listarInstituciones(tipo) {
        const endpoint = tipo === 'activos' ? 'listar_activas' : 'listar_inactivas';
        const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';

        fetch(`../controllers/Institucion/Institucion.php?accion=${endpoint}`)
            .then(response => response.json())
            .then(data => {
                // --- INICIO DEPURACIÓN ---
                console.log(`Data received for ${tipo}:`, data); // Muestra los datos recibidos en la consola
                // --- FIN DEPURACIÓN ---

                document.getElementById(tablaId).innerHTML = "";
                if (!Array.isArray(data) || data.length === 0) {
                    document.getElementById(tablaId).innerHTML = `<tr><td colspan="8">No hay instituciones ${tipo} disponibles.</td></tr>`;
                } else {
                    data.forEach(institucion => {
                        document.getElementById(tablaId).innerHTML += `
                    <!-- Assuming INSTITUTION_ID, RIF, INSTITUTION_NAME, etc. are correct keys -->
                    <tr taskid="${institucion.INSTITUTION_ID}">
                        <td>${institucion.RIF}</td>
                        <td>${institucion.INSTITUTION_NAME}</td>
                        <td>${institucion.INSTITUTION_CONTACT}</td>
                        <td>${institucion.PRACTICE_TYPE_NAME || 'N/A'}</td>
                        <td>${institucion.CAREER_NAME || 'N/A'}</td>
                        <td>
                            ${tipo === 'activos'
                                ? `<button class="task-action task-edit" data-id="${institucion.INSTITUTION_ID}" title="Editar">
                                        <span class="texto">Editar</span>
                                        <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                   </button>`
                                : ''
                            }
                        </td>
                        <td>
                            ${tipo === 'activos'
                                ? `<button class="task-action task-delete" data-id="${institucion.INSTITUTION_ID}" title="Eliminar">
                                        <span class="texto">Borrar</span>
                                        <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                   </button>`
                                : `<button class="task-action task-restore" data-id="${institucion.INSTITUTION_ID}" title="Restaurar">
                                        <span class="texto">Restaurar</span>
                                        <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                   </button>`
                            }
                        </td>
                        <td>
                            <button class="task-action task-view" data-id="${institucion.INSTITUTION_ID}" title="Consultar">
                                <span class="texto">Ver</span>
                                <span class="icon"><i class="fa-solid fa-search"></i></span>
                            </button>
                        </td>
                    </tr>
                `;
                    });
                }
            })
            .catch(error => {
                // --- INICIO DEPURACIÓN ---
                console.error('Error fetching institutions:', error);
                // --- FIN DEPURACIÓN ---
                document.getElementById(tablaId).innerHTML = `<tr><td colspan="8">Error al cargar las instituciones. ${error.message}</td></tr>`;
            });
    }

    // Registrar o actualizar
    formulario.addEventListener("submit", function (e) {
        e.preventDefault();

        let isFormValid = true;
        Object.values(formInputs).forEach(input => {
            if (input && input.hasAttribute('required')) {
                if (!validateField(input)) {
                    isFormValid = false;
                }
            }
        });

        if (!isFormValid) {
            dialog.close(); // Ocultar diálogo para mostrar la alerta
            Swal.fire('Error de Validación', 'Por favor, corrige los campos marcados en rojo.', 'error')
                .then(() => {
                    dialog.showModal(); // Reabrir diálogo después de la alerta
                });
            return;
        }

        const formData = new FormData(formulario);
        const id = formData.get("id_form"); // id_form is the hidden input for the ID
        const accion = id ? "actualizar" : "insertar";

        // Combinar los campos de teléfono en uno solo llamado 'contacto' que el backend espera
        const operadora = formData.get("operadora");
        const telefonoNumero = formData.get("telefono_numero");
        const fullPhoneNumber = `${operadora}-${telefonoNumero}`;
        formData.set("contacto", fullPhoneNumber);
        formData.delete("operadora");
        formData.delete("telefono_numero");

        formData.append("id", id); // Asegurarse de que el ID se añade si existe

        // Ocultar el diálogo antes de la petición para que se vea la alerta
        dialog.close();

        fetch(`../controllers/Institucion/Institucion.php?accion=${accion}`, {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Éxito', data.message || 'Operación exitosa', 'success');
                    limpiarFormulario();
                    listarInstituciones('activos');
                    listarInstituciones('inactivos');
                } else {
                    Swal.fire('Error', data.error || "Error al guardar", 'error').then(() => {
                        dialog.showModal();
                    });
                }
            }).catch(error => Swal.fire('Error', 'Error al enviar el formulario: ' + error.message, 'error').then(() => {
                dialog.showModal(); // También reabrir en caso de error de red
            }));
    });

    window.cambiarTab = function (tab, event) {
        // Cambiar botones activos
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        // Si el evento no se pasa, busca el botón por el tab
        const activeButton = event ? event.target : document.querySelector(`.tab-button[onclick*="'${tab}'"]`);
        if (activeButton) {
            event.target.classList.add('active');
        }

        // Mostrar/ocultar tablas
        if (tab === 'activos') {
            document.getElementById('datos-activos').style.display = '';
            document.getElementById('datos-inactivos').style.display = 'none';
            listarInstituciones('activos'); // Refrescar la lista activa
        } else {
            document.getElementById('datos-activos').style.display = 'none';
            document.getElementById('datos-inactivos').style.display = '';
            listarInstituciones('inactivos'); // Refrescar la lista inactiva
        }
    }

    // Helper function to populate a select element
    function populateSelect(selectElement, data, valueKey, textKey, defaultOptionText) {
        selectElement.innerHTML = `<option value="" disabled selected>${defaultOptionText}</option>`;
        if (Array.isArray(data)) {
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueKey];
                option.textContent = item[textKey];
                selectElement.appendChild(option);
            });
        } else {
            console.error("Data for populateSelect is not an array for:", selectElement.id, data);
        }
    }

    // Function to load generic combos (Region, Nucleus, Extension, Institution Type)
    function cargarCombosGenericos() {
        fetch('../controllers/Institucion/Institucion.php?accion=get_combos_genericos')
            .then(response => response.json())
            .then(data => {
                populateSelect(document.getElementById('region'), data.regiones, 'ABBREVIATION', 'NAME', 'Seleccione una región');
                populateSelect(document.getElementById('nucleo'), data.nucleos, 'ABBREVIATION', 'NAME', 'Seleccione un núcleo');
                populateSelect(document.getElementById('extension'), data.extensiones, 'ABBREVIATION', 'NAME', 'Seleccione una extensión');
                populateSelect(document.getElementById('tipo_institucion'), data.tipos_institucion, 'ABBREVIATION', 'NAME', 'Seleccione un tipo de institución');
            })
            .catch(error => console.error('Error al cargar combos genéricos:', error));
    }

    // Function to load Tipo Práctica
    function cargarTiposPractica() {
        fetch('../controllers/Institucion/Institucion.php?accion=get_tipos_practica')
            .then(response => response.json())
            .then(data => {
                populateSelect(tipoPracticaSelect, data, 'INTERNSHIP_TYPE_ID', 'NAME', 'Seleccione un tipo de práctica');
            })
            .catch(error => console.error('Error al cargar tipos de práctica:', error));
    }

    // Event listener for Tipo Práctica change
    tipoPracticaSelect.addEventListener('change', function () {
        const selectedTipoPracticaId = this.value;
        if (selectedTipoPracticaId) {
            cargarCarrerasPorTipoPractica(selectedTipoPracticaId);
            carreraSelect.disabled = false;
        } else {
            carreraSelect.innerHTML = '<option value="" disabled selected>Seleccione un tipo de práctica primero</option>';
            carreraSelect.disabled = true;
        }
    });

    // Function to load Carreras based on Tipo Práctica
    function cargarCarrerasPorTipoPractica(tipoPracticaId) {
        fetch(`../controllers/Institucion/Institucion.php?accion=get_carreras_by_tipo_practica&tipo_practica_id=${tipoPracticaId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                populateSelect(carreraSelect, data, 'CAREER_ID', 'CAREER_NAME', 'Seleccione una carrera');
            })
            .catch(error => console.error('Error al cargar carreras:', error));
    }

    // JQuery event listeners for dynamic buttons
    $(document).ready(function () {
        // Initial population of selects on page load
        cargarCombosGenericos();
        cargarTiposPractica();
        listarInstituciones('activos');
        listarInstituciones('inactivos');

        // Re-bind the vanilla submit handler to use jQuery form data
        // This is a bit of a mix, ideally all would be jQuery or vanilla

        // Event listener for Tipo Práctica change (for dynamic career loading)
        $('#tipo_practica').on('change', function () {
            const selectedTipoPracticaId = $(this).val();
            if (selectedTipoPracticaId) {
                cargarCarrerasPorTipoPractica(selectedTipoPracticaId);
                $('#carrera').prop('disabled', false);
            } else {
                $('#carrera').html('<option value="" disabled selected>Seleccione un tipo de práctica primero</option>');
                $('#carrera').prop('disabled', true);
            }
        });

        // Update hidden career_id_hidden when carrera select changes
        $('#carrera').on('change', function () {
            careerIdHidden.value = $(this).val();
        });

        // Validar RIF en tiempo real
        $("#rif").on("change", function () {
            const rif = $(this).val();
            const id = $("#id_form").val();

            if (rif) {
                fetch(`../controllers/Institucion/Institucion.php?accion=verificar_rif&rif=${rif}&id_excluir=${id || ''}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.existe) {
                            dialog.close(); // Ocultar diálogo para mostrar la alerta
                            Swal.fire('Advertencia', 'Este RIF ya está registrado.', 'warning')
                                .then(() => {
                                    dialog.showModal(); // Reabrir diálogo después de la alerta
                                    $(this).val("").focus(); // Limpiar y enfocar el campo RIF
                                });
                        }
                    });
            }
        });

        // Evento Editar
        $(document).on('click', '.task-edit', async function () {
            let id = $(this).data('id');
            limpiarFormulario(); // Prepara el form para edición
            $('#dialogTitle').text('Editar Institución'); // Título correcto

            try {
                const response = await fetch(`../controllers/Institucion/Institucion.php?accion=buscar_por_id&id=${id}`);
                if (!response.ok) throw new Error('Error al buscar la institución.');
                const data = await response.json();

                if (data) {
                    $("#id_form").val(data.INSTITUTION_ID);
                    $("#rif").val(data.RIF);
                    $("#nombre").val(data.INSTITUTION_NAME);
                    $("#direccion").val(data.INSTITUTION_ADDRESS);

                    // Dividir el contacto para poblar los campos de teléfono
                    const contactParts = (data.INSTITUTION_CONTACT || '').split('-');
                    $("#operadora").val(contactParts[0] || '');
                    $("#telefono_numero").val(contactParts[1] || '');
                    $("#region").val(data.REGION);
                    $("#nucleo").val(data.NUCLEUS);
                    $("#extension").val(data.EXTENSION);
                    $("#tipo_institucion").val(data.INSTITUTION_TYPE);

                    // Set tipo_practica and wait for careers to load
                    $("#tipo_practica").val(data.PRACTICE_TYPE);

                    if (data.PRACTICE_TYPE) {
                        $('#carrera').prop('disabled', false);
                        // Await for careers to be loaded before setting the value
                        await fetch(`../controllers/Institucion/Institucion.php?accion=get_carreras_by_tipo_practica&tipo_practica_id=${data.PRACTICE_TYPE}`)
                            .then(res => res.json())
                            .then(carrerasData => {
                                populateSelect(carreraSelect, carrerasData, 'CAREER_ID', 'CAREER_NAME', 'Seleccione una carrera');
                                // Ahora que las opciones están pobladas, establece el valor
                                $("#carrera").val(data.CAREER_ID);
                            });
                    } else {
                        $('#carrera').html('<option value="" disabled selected>Seleccione un tipo de práctica primero</option>');
                        $('#carrera').prop('disabled', true);
                    }

                    $("#dialog")[0].showModal();
                }
            } catch (error) {
                Swal.fire('Error', 'No se pudieron cargar los datos para editar: ' + error.message, 'error');
            }
        });

        // Evento Consultar
        $(document).on('click', '.task-view', async function () {
            let id = $(this).data('id');

            limpiarFormulario(); // Resetea el estado del form

            try {
                const response = await fetch(`../controllers/Institucion/Institucion.php?accion=buscar_por_id&id=${id}`);
                if (!response.ok) throw new Error('Error al buscar la institución.');
                const data = await response.json();

                if (data) {
                    $("#id_form").val(data.INSTITUTION_ID);
                    $("#rif").val(data.RIF);
                    $("#nombre").val(data.INSTITUTION_NAME);
                    $("#direccion").val(data.INSTITUTION_ADDRESS);

                    // Dividir el contacto para poblar los campos de teléfono
                    const contactParts = (data.INSTITUTION_CONTACT || '').split('-');
                    $("#operadora").val(contactParts[0] || '');
                    $("#telefono_numero").val(contactParts[1] || '');
                    $("#region").val(data.REGION);
                    $("#nucleo").val(data.NUCLEUS);
                    $("#extension").val(data.EXTENSION);
                    $("#tipo_institucion").val(data.INSTITUTION_TYPE);

                    // Set tipo_practica and wait for careers to load
                    $("#tipo_practica").val(data.PRACTICE_TYPE);

                    if (data.PRACTICE_TYPE) {
                        $('#carrera').prop('disabled', false);
                        // Await for careers to be loaded before setting the value
                        await fetch(`../controllers/Institucion/Institucion.php?accion=get_carreras_by_tipo_practica&tipo_practica_id=${data.PRACTICE_TYPE}`)
                            .then(res => res.json())
                            .then(carrerasData => {
                                populateSelect(carreraSelect, carrerasData, 'CAREER_ID', 'CAREER_NAME', 'Seleccione una carrera');
                                // Ahora que las opciones están pobladas, establece el valor
                                $("#carrera").val(data.CAREER_ID);
                            });
                    } else {
                        $('#carrera').html('<option value="" disabled selected>Seleccione un tipo de práctica primero</option>');
                        $('#carrera').prop('disabled', true);
                    }

                    // Cambiar a modo consulta
                    $('#dialogTitle').text('Consultar Institución');
                    $('#formulario').find('input, select, textarea').prop('disabled', true);
                    $('.formulario__btn').hide(); // Ocultar botón de guardar

                    $("#dialog")[0].showModal();
                }
            } catch (error) {
                Swal.fire('Error', 'No se pudieron cargar los datos para consultar: ' + error.message, 'error');
            }
        });

        // Evento Eliminar (Desactivar)
        $(document).on('click', '.task-delete', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: '¿Está seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, desactivar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = new FormData();
                    form.append("id", id);
                    fetch("../controllers/Institucion/Institucion.php?accion=eliminar", {
                        method: "POST",
                        body: form
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Desactivada!', data.message || 'La institución ha sido desactivada.', 'success');
                                listarInstituciones('activos');
                                listarInstituciones('inactivos');
                            } else {
                                Swal.fire('Error', data.error || 'No se pudo desactivar la institución.', 'error');
                            }
                        });
                }
            });
        });

        // Evento Restaurar (Activar)
        $(document).on('click', '.task-restore', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: '¿Desea restaurar la institución?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, restaurar',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = new FormData();
                    form.append("id", id);
                    fetch("../controllers/Institucion/Institucion.php?accion=restaurar", {
                        method: "POST",
                        body: form
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Restaurada!', data.message || 'La institución ha sido restaurada.', 'success');
                                listarInstituciones('activos');
                                listarInstituciones('inactivos');
                            } else {
                                Swal.fire('Error', data.error || 'No se pudo restaurar la institución.', 'error');
                            }
                        });
                }
            });
        });
    });
});