<?php
require 'header.php';
?>
<span class="text">Empresa</span>
<div class="page-content">

    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>RIF</th>
                <th>Empresa</th>
                <th>Dirección Empresa</th>
                <th>Nombre del Contacto</th>
                <th>Telefono del Contacto</th>
                <th>Telefono Empresa</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>
    <br>
    <hr>
    <br>
    <form action="" class="formulario" id="formulario">
        <!-- Grupo: Usuario -->
        <input type="hidden" id="id">
        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">RIF <span class="obligatorio">*</span></label>
            <select id="" class="formulario__input" name="tipo-cedula">
                <option value="">V-</option>
                <option value="">E-</option>
                <option value="">J-</option>
                <option value="">G-</option>
                <option value="">P-</option>
            </select>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese el RIF">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">El usuario tiene que ser de x a x dígitos y solo puede contener numeros etc.</p>
        </div>

        <!-- Grupo:  -->
        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Nombre de la Empresa <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Nombre de la Empresa">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Dirección de la Empresa <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Dirección de la Empresa">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Nombre del Contacto <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese la Nombre del Contacto">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Telefono del Contacto <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <select class="formulario__input" id="telefono_contacto">
                    <option value="0412-">0412-</option>
                    <option value="0414-">0414-</option>
                    <option value="0424-">0424-</option>
                    <option value="0426-">0426-</option>
                    <option value="0255-">0255-</option>
                </select>
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese el Telefono del Contacto">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario__input-error">Validacion</p>
        </div>

        <div class="formulario__grupo" id="">
            <label for="" class="formulario__label">Telefono de la Empresa <span class="obligatorio">*</span></label>
            <div class="formulario__grupo-input">
                <select class="formulario__input" id="telefono_Empresa">
                    <option value="0412-">0412-</option>
                    <option value="0414-">0414-</option>
                    <option value="0424-">0424-</option>
                    <option value="0426-">0426-</option>
                    <option value="0255-">0255-</option>
                </select>
                <input type="text" class="formulario__input" name="" id="" placeholder="Ingrese el Telefono de la Empresa">
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
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
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/empresa/main.js"></script>
<?php
require 'footer.php';
?>