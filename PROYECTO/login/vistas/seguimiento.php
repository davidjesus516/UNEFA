<?php
require 'header.php';
?>
<link rel="stylesheet" href="css/style.css">

<span class="text">Seguimiento Estudiantil</span>
<div class="page-content">
    <!-- Sección de Formulario de Seguimiento -->
    <div class="seguimiento-container">
        <div class="formulario-seguimiento">
            <h2>Registro de Seguimiento</h2>

            <!-- Fila de Campos Principales -->
            <div class="fila-superior">
                <!-- Grupo Cédula -->
                <div class="formulario__grupo">
                    <label class="formulario__label">C.I. Estudiante <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text"
                            class="formulario__input"
                            id="cedula-estudiante"
                            placeholder="Ingrese la cédula"
                            autocomplete="off"
                            pattern="[0-9]*"
                            inputmode="numeric"
                            onkeypress="return validarNumero(event)"
                            style="width: 100%;">
                        <i class="formulario__validacion-estado fas fa-search"></i>
                    </div>
                    <p class="formulario__input-error" id="error-cedula"></p>
                </div>

                <!-- Grupo Nombre -->
                <div class="formulario__grupo">
                    <label class="formulario__label">Nombre Estudiante</label>
                    <input type="text" class="formulario__input" id="nombre-estudiante" style="width: 100%;" readonly>
                </div>
            </div>
            <div class="formulario__grupo">
                <label class="formulario__label">Título Informe <span class="obligatorio">*</span></label>
                <textarea class="formulario__input formulario__textarea" name="" id="direccion" placeholder="Titulo del Informe"></textarea>
            </div>
            <br>
            <!-- Fila de Campos Secundarios -->
            <div class="fila-inferior">
                <!-- Grupo Traslado -->
                <div class="formulario__grupo">
                    <label class="formulario__label">Traslado</label>
                    <select id="traslado" class="formulario__input">
                        <option value="interno">Interno</option>
                        <option value="externo">Externo</option>
                        <option value="pendiente">Pendiente</option>
                    </select>
                </div>

                <!-- Grupo Recorrido -->
                <div class="formulario__grupo grupo-recorrido">
                    <label class="formulario__label">Recorrido</label>
                    <div class="recorrido-container">
                        <textarea class="formulario__input" id="recorrido"
                            placeholder="Describa el recorrido" rows="3"></textarea>
                    </div>
                </div>
            </div>


            <div class="formulario__grupo" style="display: flex;">
                <div class="formulario__label" style="width: 15rem;">
                    <a href="registro_visita.php">Registro de Visitas</a>
                </div>
                <!-- Grupo Observaciones -->
                <div class="formulario__grupo observaciones-completas">
                    <label class="formulario__label">Observaciones</label>
                    <textarea class="formulario__input" id="observaciones"
                        placeholder="Registre observaciones relevantes" rows="4"></textarea>
                </div>
            </div>

            <!-- Botonera -->
            <div class="botonera-seguimiento">
                <button type="button" class="formulario__btn guardar" id="btn-guardar">Guardar</button>
                <button type="button" class="formulario__btn editar" id="btn-editar">Editar</button>
                <button type="button" class="formulario__btn eliminar" id="btn-eliminar">Eliminar</button>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Autocompletado de Cédula
            $('#cedula-estudiante').on('input', function() {
                const cedula = $(this).val();
                if (cedula.length >= 6) {
                    $.ajax({
                        url: '../controllers/estudiante/buscarPorCedula.php',
                        method: 'POST',
                        data: {
                            cedula: cedula
                        },
                        success: function(response) {
                            const data = JSON.parse(response);
                            if (data.success) {
                                $('#nombre-estudiante').val(data.nombre);
                                cargarHistorial(data.id);
                            } else {
                                $('#error-cedula').text('Estudiante no encontrado').show();
                            }
                        }
                    });
                }
            });

            // Cargar Historial de Visitas
            function cargarHistorial(estudianteId) {
                $.get(`../controllers/seguimiento/historial.php?id=${estudianteId}`, function(data) {
                    let template = '';
                    JSON.parse(data).forEach(visita => {
                        template += `<tr>
                            <td>${visita.fecha}</td>
                            <td>${visita.tipo}</td>
                            <td>${visita.responsable}</td>
                            <td>
                                <button class="btn-ver" data-id="${visita.id}">👁️</button>
                                <button class="btn-editar" data-id="${visita.id}">✏️</button>
                            </td>
                        </tr>`;
                    });
                    $('#historial-visitas').html(template);
                });
            }

            // Manejo de Botones
            $('#btn-guardar').click(function() {
                guardarInforme('nuevo');
            });

            $('#btn-editar').click(function() {
                guardarInforme('actualizar');
            });

            $('#btn-eliminar').click(function() {
                if (confirm('¿Eliminar este informe permanentemente?')) {
                    // Lógica de eliminación
                }
            });

            function guardarInforme(accion) {
                const datos = {
                    estudiante_id: $('#cedula-estudiante').val(),
                    titulo: $('#titulo-informe').val(),
                    traslado: $('#traslado').val(),
                    recorrido: $('#recorrido').val(),
                    observaciones: $('#observaciones').val(),
                    accion: accion
                };

                $.post('../controllers/seguimiento/gestionar.php', datos)
                    .done(function(response) {
                        // Actualizar interfaz
                    });
            }
        });


        document.getElementById('cedula-estudiante').addEventListener('input', function(e) {
            const valorAnterior = this.value;
            const nuevoValor = valorAnterior.replace(/[^0-9]/g, '');

            if (valorAnterior !== nuevoValor) {
                this.classList.add('input-error');
                setTimeout(() => this.classList.remove('input-error'), 1000);
            }

            this.value = nuevoValor;
        });
    </script>



</div>
<?php
require 'footer.php';
?>