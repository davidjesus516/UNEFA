<?php
require 'header.php';
?>
<span class="text">Estudiante</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="document.getElementById('dialog').showModal();">Nuevo +</button>

        <dialog id="dialog">
            <h2>Registrar Estudiante</h2>
            <form action="#" class="formulario" id="formulario">
                <input type="hidden" id="id">

                <!-- Grupo: Cédula -->
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="cedula_completa" class="formulario__label">Cédula <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <select id="nacionalidad" class="formulario__input" name="nacionalidad">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="V">V-</option>
                            <option value="E">E-</option>
                            <option value="P">P-</option>
                        </select>
                        <input type="text" maxlength="8" class="formulario__input"
                            name="cedula" id="cedula"
                            placeholder="Número de cédula" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>

                <!-- Nombres -->
                <div class="formulario__grupo" id="grupo__primer_nombre">
                    <label for="primer_nombre" class="formulario__label">Primer Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input"
                            name="primer_nombre" id="primer_nombre"
                            placeholder="Ingrese el primer nombre" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="grupo__segundo_nombre">
                    <label for="segundo_nombre" class="formulario__label">Segundo Nombre</label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input"
                            name="segundo_nombre" id="segundo_nombre"
                            placeholder="Ingrese el segundo nombre">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Apellidos -->
                <div class="formulario__grupo" id="grupo__primer_apellido">
                    <label for="primer_apellido" class="formulario__label">Primer Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input"
                            name="primer_apellido" id="primer_apellido"
                            placeholder="Ingrese el primer apellido" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="grupo__segundo_apellido">
                    <label for="segundo_apellido" class="formulario__label">Segundo Apellido</label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input"
                            name="segundo_apellido" id="segundo_apellido"
                            placeholder="Ingrese el segundo apellido">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Género y Estado Civil -->
                <div class="formulario__grupo">
                    <label for="genero" class="formulario__label">Género <span class="obligatorio">*</span></label>
                    <select id="genero" name="genero" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Otro</option>
                    </select>
                </div>

                <div class="formulario__grupo">
                    <label for="estado_civil" class="formulario__label">Estado Civil <span class="obligatorio">*</span></label>
                    <select id="estado_civil" name="estado_civil" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="S">Soltero</option>
                        <option value="C">Casado</option>
                        <option value="D">Divorciado</option>
                        <option value="V">Viudo</option>
                    </select>
                </div>

                <!-- Contacto -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="tel" class="formulario__input"
                            name="telefono" id="telefono"
                            placeholder="Ej: 04121234567"
                            pattern="[0-9]{11}"
                            maxlength="11" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Debe contener 11 dígitos numéricos</p>
                </div>

                <div class="formulario__grupo" id="grupo__correo">
                    <label for="correo" class="formulario__label">Correo <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="email" class="formulario__input"
                            name="correo" id="correo"
                            placeholder="ejemplo@correo.com" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El correo debe tener un formato válido</p>
                </div>

                <!-- Selectores -->
                <div class="formulario__grupo">
                    <label for="turno" class="formulario__label">Turno <span class="obligatorio">*</span></label>
                    <select id="turno" name="turno" class="formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="D">Diurno</option>
                        <option value="N">Nocturno</option>
                    </select>
                </div>

                <div class="formulario__grupo">
                    <label for="carrera" class="formulario__label">Carrera <span class="obligatorio">*</span></label>
                    <select id="carrera" name="carrera" class="formulario__input" required>
                        <option value="" disabled selected>Cargando carreras...</option>
                    </select>
                </div>

                <!-- Mensajes y Botones -->
                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor complete el formulario correctamente </p>
                </div>

                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">¡Registro exitoso!</p>
                </div>
            </form>
            <button onclick="document.getElementById('dialog').close();"
                aria-label="Cerrar"
                class="x">❌</button>
        </dialog>
    </div>

    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>Cédula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Género</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Carrera</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody id="datos"></tbody>
    </table>

</div>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/estudiante.js"></script>

<?php
require 'footer.php';
?>