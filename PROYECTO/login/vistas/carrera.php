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
                <input type="hidden" id="id">
                
                <!-- Código de Carrera -->
                <div class="formulario__grupo" id="grupo__codigo">
                    <label for="codigo" class="formulario__label">Código <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="codigo" id="codigo" placeholder="Ingrese el código de la carrera" required>
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
            <tbody id="datos">
                <!-- Filas dinámicas -->
            </tbody>
        </table>
    </div>
</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Cargar tipos de pasantías al abrir el modal
    document.getElementById('dialog').addEventListener('click', function() {
        cargarTiposPasantias();
    });

    // Función para cargar los tipos de pasantías
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
                                   name="tipos_pasantias" value="${tipo.INTERNSHIP_TYPE_ID}">
                            <label for="tipo_${tipo.INTERNSHIP_TYPE_ID}">${tipo.NAME}</label>
                        </div>
                    `;
                });
            });
    }

    // Función para cargar las carreras en la tabla
    function cargarCarreras() {
        fetch('../controllers/carrera/Carrera.php?accion=listar_activos')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('datos');
                tbody.innerHTML = '';
                
                data.forEach(carrera => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${carrera.CAREER_CODE}</td>
                            <td>${carrera.CAREER_NAME}</td>
                            <td>${carrera.MINIMUM_GRADE}</td>
                            <td>
                                <button onclick="editarCarrera(${carrera.CAREER_ID})">✏️</button>
                                <button onclick="eliminarCarrera(${carrera.CAREER_ID})">🗑️</button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    // Llamar a la función para cargar carreras al inicio
    cargarCarreras();

    // Manejar el envío del formulario
    document.getElementById('formulario').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('id').value;
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
                alert('Operación exitosa');
                document.getElementById('dialog').close();
                this.reset();
                cargarCarreras();
            } else {
                alert('Error: ' + (data.error || 'No se pudo completar la operación'));
            }
        });
    });

    // Funciones globales para editar y eliminar
    window.editarCarrera = function(id) {
        fetch(`../controllers/carrera/Carrera.php?accion=buscar_para_editar&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const carrera = data[0];
                    document.getElementById('id').value = carrera.CAREER_ID;
                    document.getElementById('codigo').value = carrera.CAREER_CODE;
                    document.getElementById('nombre').value = carrera.CAREER_NAME;
                    document.getElementById('nota').value = carrera.MINIMUM_GRADE;
                    
                    // Marcar los checkboxes de tipos de pasantías
                    carrera.CAREER_INTERNSHIP_TYPES.forEach(tipo => {
                        const checkbox = document.getElementById(`tipo_${tipo.INTERNSHIP_TYPE_ID}`);
                        if (checkbox) checkbox.checked = true;
                    });
                    
                    document.getElementById('dialog').showModal();
                }
            });
    };

    window.eliminarCarrera = function(id) {
        if (confirm('¿Está seguro de eliminar esta carrera?')) {
            const formData = new FormData();
            formData.append('id', id);
            
            fetch('../controllers/carrera/Carrera.php?accion=eliminar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Carrera eliminada');
                    cargarCarreras();
                } else {
                    alert('Error al eliminar');
                }
            });
        }
    };
});
</script>

<?php
require 'footer.php';
?>