<?php
require 'header.php';
?>
<style>

</style>

<span class="text">Culminación Pasantia</span>
<div class="page-content">
    <!-- Sección de Formulario de modal-large -->
    <div class="modal-large-container">
        <div class="formulario-modal-large">
            <h2>Culminación</h2>

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
                <textarea class="formulario__input formulario__textarea" name="" id="direccion" placeholder="Titulo del Informe" readonly></textarea>
            </div>

            <div class="formulario__grupo" id="grupo__">
                <label for="" class="formulario__label">Nota<span class="obligatorio">*</span></label>
                <div class="formulario__grupo-input">
                    <input type="number" class="formulario__input" name="" id="nota" placeholder="Nota" min=0 max=20 step=any required>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <p class="formulario__input-error">Validación</p>
            </div>

<div class="status aprovado">Aprobado</div>
<!-- o -->
<div class="status reprovado">Reprobado</div>

            <!-- Botonera -->
            <div class="botonera-modal-large">
                <button type="button" class="formulario__btn guardar" id="btn-guardar">Guardar</button>
                <button type="button" class="formulario__btn editar" id="btn-editar">Editar</button>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.7.0.min.js"></script>

</div>
<?php
require 'footer.php';
?>