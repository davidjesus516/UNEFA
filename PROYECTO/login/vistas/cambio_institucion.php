<?php
require 'header.php';
?>
<style>

</style>

<span class="text">Ventana -> <a href="cambio_registro.php">Cambio Registro</a> -> Cambio Institución</span>
<div class="page-content">
    <!-- Sección de Formulario de modal-large -->
    <div class="modal-large-container">
        <div class="formulario-modal-large">
            <h2>Cambio Institución</h2>

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

            <div class="fila-superior">
                <div class="formulario__grupo">
                    <label class="formulario__label">Institución Anterior</label>
                    <input type="text" class="formulario__input" id="nombre-estudiante" style="width: 100%;" readonly>
                </div>
                <!-- institucion -->
                <div class="formulario__grupo">
                    <label for="institucion" class="formulario__label">Nueva Institución <span class="obligatorio">*</span></label>
                    <select id="institucion" name="institucion" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                </div>
                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
                </div>
            </div>
            <div class="formulario__grupo">
                <label for="responsable" class="formulario__label">Nuevo Responsable <span class="obligatorio">*</span></label>
                <select id="responsable" name="responsable" class="formulario__input" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                </select>
            </div>


            <div class="formulario__grupo">
                <label class="formulario__label">Motivo cambio: <span class="obligatorio">*</span></label>
                <textarea class="formulario__input formulario__textarea" name="" id="" placeholder="Motivo del cambio"></textarea>
            </div>
        </div>

        <!-- Botonera -->
        <div class="botonera-modal-large">
            <button type="button" class="formulario__btn guardar" id="btn-guardar">Guardar</button>
            <!-- <button type="button" class="formulario__btn editar" id="btn-editar">Editar</button> -->
        </div>
    </div>
</div>

<script src="js/jquery-3.7.0.min.js"></script>

</div>
<?php
require 'footer.php';
?>