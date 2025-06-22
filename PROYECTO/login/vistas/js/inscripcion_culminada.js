// Cargar periodos para el modal de consulta (aunque esté deshabilitado, es bueno tener los datos)
cargarPeriodos();

// Función para mostrar mensajes con SweetAlert2
function mostrarMensaje(mensaje, tipo = 'info') {
    Swal.fire({
        title: tipo.charAt(0).toUpperCase() + tipo.slice(1), // Capitalize
        text: mensaje,
        icon: tipo,
        confirmButtonText: 'Aceptar'
    });
}

function cargarPeriodos() {
    fetch('../controllers/profesional_practices/profesional_practices.php?accion=listar_periodos')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById("periodo");
            select.innerHTML = ''; // Limpiar opciones previas
            if (Array.isArray(data)) {
                // Agregar una opción por defecto
                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = "Seleccione un período";
                defaultOption.disabled = true;
                select.appendChild(defaultOption);

                data.forEach(periodo => {
                    const option = document.createElement("option");
                    option.value = periodo.PERIOD_ID;
                    option.textContent = periodo.DESCRIPTION;
                    select.appendChild(option);
                });
            } else {
                const option = document.createElement("option");
                option.value = '';
                option.textContent = 'No hay periodos disponibles';
                select.appendChild(option);
            }
        })
        .catch(() => {
            const select = document.getElementById("periodo");
            select.innerHTML = '';
            const option = document.createElement("option");
            option.value = '';
            option.textContent = 'Error al cargar periodos';
            select.appendChild(option);
        });
}

function listarPreinscripcionesCulminadas(tipo) {
    const endpoint = tipo === 'aprobados' ? 'listar_culminadas_aprobadas' : 'listar_culminadas_reprobadas';
    const tablaId = tipo === 'aprobados' ? 'datos-aprobados' : 'datos-reprobados';

    let tbody = document.getElementById(tablaId);
    if (!tbody) {
        console.error(`Elemento con ID ${tablaId} no encontrado.`);
        return;
    }

    fetch(`../controllers/profesional_practices/profesional_practices.php?accion=${endpoint}`)
        .then(res => res.json())
        .then(data => { // Add console.log for debugging
            console.log(`Data received for ${tipo} culminadas:`, data);
            tbody.innerHTML = '';
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    const acciones = `
                        <button class="task-view" onclick="verInscripcion(${row.INSCRIPCION_ID})"><span class="texto">Ver</span><span class="icon"><i class="fa-solid fa-search"></i></span></button>
                    `;
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.STUDENTS_CI || ''}</td>
                        <td>${row.ESTUDIANTE || ''}</td>
                        <td>${row.CONTACTO || row.CONTACT_PHONE || ''}</td>
                        <td>${row.PERIOD_DESCRIPTION || ''}</td>
                        <td>${row.ENROLLMENT || ''}</td> 
                        <td>${row.TIPO_PRACTICA || ''}</td>
                        <td>${row.CULMINATION_DATE ? new Date(row.CULMINATION_DATE).toLocaleDateString() : ''}</td> 
                        <td>${acciones}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                // Modified to catch empty arrays or non-array data without 'mensaje'
                const tr = document.createElement('tr'); 
                tr.innerHTML = `<td colspan="8">${data.mensaje || `No hay registros ${tipo} disponibles.`}</td>`;
                tbody.appendChild(tr);
            }
        })
        .catch((error) => {
            console.error(`Error al cargar inscripciones ${tipo}:`, error);
            tbody.innerHTML = `<tr><td colspan="6">Error al cargar inscripciones culminadas (${tipo})</td></tr>`;
        });
}

document.addEventListener("DOMContentLoaded", function() {
    window.dialog = document.getElementById("dialog");

    // verInscripcion: muestra los datos en el formulario de solo lectura
    window.verInscripcion = function(id) {
        fetch(`../controllers/profesional_practices/profesional_practices.php?accion=buscar_preinscripcion_por_id&id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data) {
                    const tipo_practica_select = document.getElementById("tipo_practica");
                    tipo_practica_select.innerHTML = ''; // Limpiar opciones previas

                    if (data.combos && Array.isArray(data.combos.internship_types)) {
                        data.combos.internship_types.forEach(tipo => {
                            const option = document.createElement("option");
                            option.value = tipo.INTERNSHIP_TYPE_ID;
                            option.textContent = tipo.NAME;
                            tipo_practica_select.appendChild(option);
                        });
                    }

                    document.getElementById("id_form").value = data.INSCRIPCION_ID || '';
                    document.getElementById("cedula").value = data.CEDULA || '';
                    document.getElementById("nacionalidad").value = data.NACIONALIDAD || '';
                    document.getElementById("Estudiante").value = data.ESTUDIANTE || '';
                    document.getElementById("id_estudiante").value = data.STUDENTS_ID || '';
                    document.getElementById("periodo").value = data.PERIOD_ID || '';
                    document.getElementById("tipo_practica").value = data.INTERNSHIP_TYPE_ID || '';
                    document.getElementById("matricula").value = data.ENROLLMENT || '';
                    
                    dialog.showModal();
                } else {
                    mostrarMensaje("No se encontraron los datos de la preinscripción.", "error");
                }
            });
    };


    // cambiarTab: muestra/oculta correctamente los tbodys de aprobados/reprobados
    window.cambiarTab = function(tab, event) {
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        document.getElementById('datos-aprobados').style.display = (tab === 'aprobados') ? '' : 'none';
        document.getElementById('datos-reprobados').style.display = (tab === 'reprobados') ? '' : 'none';
        listarPreinscripcionesCulminadas(tab);
    };

    // Carga inicial de la tabla de aprobados
    listarPreinscripcionesCulminadas('aprobados');
});