<?php
require 'header.php';
?>
<span class="text">Institución</span>
<div class="page-content">

    <div class="modal">
        <dialog id="respuesta-modal"></dialog>
    </div>

    <div id="main-modal" class="modal">
        <button class="primary" onclick="document.getElementById('institucion-dialog').showModal();">Nuevo +</button>

        <dialog id="institucion-dialog">
            <h2>Registrar Institución</h2>

            <form action="" class="formulario" id="formulario">

                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">
                <div class="formulario__grupo" id="grupo__rif">
                    <label for="" class="formulario__label">RIF <span class="obligatorio">*</span></label>
                    <select id="l_rif" class="formulario__input" name="tipo-cedula">
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="J">J-</option>
                        <option value="G">G-</option>
                    </select>
                    <input type="text" class="formulario__input" name="" id="n_rif" placeholder="Ingrese el RIF">
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>

                    <p class="formulario__input-error">solo puede contener numeros de maximo 9 digitos</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Nombre de la Empresa <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese la Nombre de la Empresa">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Dirección Fiscal<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <textarea class="formulario__input formulario__textarea" name="" id="direccion" placeholder="Ingrese la Dirección de la Empresa"></textarea>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                
                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Contacto<span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select class="formulario__input" id="telefono_Empresa">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="0412-">0412-</option>
                            <option value="0414-">0414-</option>
                            <option value="0424-">0424-</option>
                            <option value="0426-">0426-</option>
                            <option value="0255-">0255-</option>
                        </select>
                        <input type="text" class="formulario__input" name="" id="telefono" placeholder="Ingrese el Telefono de la Empresa">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Tipo Institucion <span class="obligatorio">*</span></label>
                    <select id="Tipo_Institucion" aria-placeholder="Tipo Institucion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
                    <select id="carrera" aria-placeholder="carrera" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!--  -->
                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Tipo Practica <span class="obligatorio">*</span></label>
                    <select id="Tipo_Practica" aria-placeholder="Tipo Practica" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>
            </form>
            <button onclick="document.getElementById('institucion-dialog').close();"
                aria-label="Cerrar"
                class="x">❌</button>
        </dialog>
    </div>


    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>RIF</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Dirección</th>
                <th>Carrera</th>
                <th>Práctica</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="datos-instituciones"></tbody>
    </table>

</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/Institucion.js"></script>

<?php
require 'footer.php';
?>