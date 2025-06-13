<?php
require 'header.php';
?>
<link rel="stylesheet" href="css/style.css">

<span class="text">Seguimiento Estudiantil</span>
<div class="page-content">
    <!-- Sección de Formulario de modal-large -->
    <div class="modal-large-container">
        <div class="formulario-modal-large">
            <h2>Registro Seguimiento</h2>

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
                    <label class="formulario__label">Estudiante</label>
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
                        <option value="si">Si</option>
                        <option value="no">No</option>
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
                    <a href="registro_visita.php">Registro Visitas</a>
                </div>
                <!-- Grupo Observaciones -->
                <div class="formulario__grupo observaciones-completas">
                    <label class="formulario__label">Observaciones</label>
                    <textarea class="formulario__input" id="observaciones"
                        placeholder="Registre observaciones relevantes" rows="4"></textarea>
                </div>
            </div>

            <!-- Botonera -->
            <div class="botonera-modal-large">
                <button type="button" class="formulario__btn guardar" id="btn-guardar">Guardar</button>
                <button type="button" class="formulario__btn editar" id="btn-editar">Editar</button>
                <button type="button" class="formulario__btn eliminar" id="btn-eliminar">Eliminar</button>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.7.0.min.js"></script>

</div>
<?php
require 'footer.php';
?>